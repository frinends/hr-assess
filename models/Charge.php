<?php

namespace app\models;
use app\models\Department;
use app\models\Employee;
use Yii;

/**
 * This is the model class for table "{{%charge}}".
 *
 * @property integer $charge_id
 * @property integer $user_id
 * @property integer $dep_id
 */
class Charge extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%charge}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employee_id', 'dep_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'charge_id' => 'Charge ID',
            'employee_id' => 'User ID',
            'dep_id' => 'Dep ID',
        ];
    }
    
    /**
     * 关联部门
     */
    public function getDepartment(){
        return $this->hasOne(Department::className(), ['dep_id' => 'dep_id']);
    }
    
    
    /**
     * 关联员工
     */
    public function getEmployee(){
        return $this->hasOne(Employee::className(), ['employee_id' => 'employee_id']);
    }
}
