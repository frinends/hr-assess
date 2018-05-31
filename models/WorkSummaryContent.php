<?php

namespace app\models;

use Yii;
use yii\data\Pagination;
use app\models\Employee;
use app\models\WorkSummary;

/**
 * This is the model class for table "{{%work_summary_content}}".
 *
 * @property integer $id
 * @property integer $employee_id
 * @property integer $work_id
 * @property string $content
 * @property string $ins_time
 */
class WorkSummaryContent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%work_summary_content}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employee_id', 'work_id'], 'integer'],
            [['content'], 'string'],
            [['ins_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee_id' => 'Employee ID',
            'work_id' => 'Work ID',
            'content' => 'Content',
            'ins_time' => 'Ins Time',
        ];
    }
    
    /**
     * 关联单位
     */
    public function getEmployee(){
        return $this->hasOne(Employee::className(), ['employee_id' => 'employee_id']);
    }
    
    /**
     * 列表
     */
    public static function getList($work_id){
        $condition = $e_conditionFilter = $employee_ids = [];
        
        if($employees = Yii::$app->request->get("employees")){
            $e_conditionFilter = ['or', ['like', 'name', $employees], ['like', 'employee_number', $employees]];
           
        }
        if($unit = Yii::$app->request->get("unit")){
            $condition["unit_id"] = $unit;
        }
        if($department = Yii::$app->request->get("department")){
            $condition["dep_id"] = $department;
        }
        if($rank = Yii::$app->request->get("rank")){
            $condition["rank_id"] = $rank;
        }
        
        
        $condition["work_id"] = $work_id;
        
        $data = self::find()->joinWith(["employee"])->where($condition)->andWhere($e_conditionFilter);
        
        
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '15']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();
       
        return [
              'model' => $model,
              'pages' => $pages,
        ];
               
    }
    
    /**
     * 工作总结详情
     * @param type $id
     * @return type
     */
    public static function getInfo($id){
        $model = self::find()->joinWith(["employee"])->where(["id"=>$id])->one();
        return $model;
    }
    
    /**
     * 工作总结详情
     * @param type $id
     * @return type
     */
    public static function getMyInfo($id, $employee_id){
        $model = self::find()->joinWith(["employee"])->where([self::tableName().".work_id"=>$id, self::tableName().".employee_id"=>$employee_id])->one();
        
        return $model;
    }
    
    /**
     * 关联工作总结任务表
     * @return type
     */
    public function getSummary(){
        return $this->hasOne(WorkSummary::className(), ['work_id' => 'work_id']);
    }
    
    /**
     * 员工工作总结列表
     * @param type $id
     * @return type
     */
    public static function employeeList($id){
        $condition = [
            "employee_id" => $id
        ];
        $data = self::find()->joinWith(["summary"])->where($condition)->all();
        return $data;
    }
}
