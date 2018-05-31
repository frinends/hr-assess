<?php

namespace app\models;

use Yii;
use yii\data\Pagination;
/**
 * This is the model class for table "{{%employee}}".
 *
 * @property integer $employee_id
 * @property string $name
 * @property string $identity_card
 * @property string $employee_number
 * @property string $unit_id
 * @property string $dep_id
 * @property string $position
 * @property string $rank_id
 * @property integer $sex
 * @property string $politics_status
 * @property string $mobile
 * @property string $email
 * @property string $password
 * @property integer $is_work
 */
class Employee extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%employee}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sex', 'is_work'], 'integer'],
            [['name', 'identity_card', 'employee_number'], 'string', 'max' => 50],
            [['unit_id', 'dep_id', 'position', 'rank_id'], 'string', 'max' => 30],
            [['politics_status', 'mobile'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 60],
            [['role', 'password'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'employee_id' => 'Employee ID',
            'name' => 'Name',
            'identity_card' => 'Identity Card',
            'employee_number' => 'Employee Number',
            'unit_id' => 'Unit ID',
            'dep_id' => 'Dep ID',
            'position' => 'Position',
            'rank_id' => 'Rank ID',
            'sex' => 'Sex',
            'politics_status' => 'Politics Status',
            'mobile' => 'Mobile',
            'email' => 'Email',
            'password' => 'Password',
            'is_work' => 'Locker',
        ];
    }

    /**
     * 关联单位
     */
    public function getUnit(){
        return $this->hasOne(Unit::className(), ['unit_id' => 'unit_id']);
    }
    
    /**
     * 关联部门
     */
    public function getDepartment(){
        return $this->hasOne(Department::className(), ['dep_id' => 'dep_id']);
    }
    
    /**
     * 关联职级
     */
    public function getRank(){
        return $this->hasOne(Rank::className(), ['rank_id' => 'rank_id']);
    }
    
    
    /**
     * 员工个人信息
     * @param type $id
     * @return type
     */
    public static function getInfo($id){
        
        $condition["employee_id"] = $id;
        
        $data = self::find()->joinWith(["unit", "department", "rank"])->where($condition)->one();
        return $data;
    }

    /**
     * 员工列表
     * @return type
     */
    public static function getList(){
        $condition = $conditionFilter = [];
        if($employees = Yii::$app->request->get("employees")){
            $conditionFilter = ['or', ['like', 'name', $employees], ['like', 'employee_number', $employees]];
        }
        if($unit = Yii::$app->request->get("unit")){
            $condition[self::tableName().".unit_id"] = $unit;
        }
        if($department = Yii::$app->request->get("department")){
            $condition[self::tableName().".dep_id"] = $department;
        }
        if($rank = Yii::$app->request->get("rank")){
            $condition[self::tableName().".rank_id"] = $rank;
        }
        $condition["is_work"] = 0;
        $condition["role"] = "employee";
        $data = self::find()->joinWith(["unit", "department", "rank"])->where($condition)->andWhere($conditionFilter);
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '15']);
        
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();
       
        return [
              'model' => $model,
              'pages' => $pages,
        ];
               
    }
}
