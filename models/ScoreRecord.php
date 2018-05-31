<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%score_record}}".
 *
 * @property integer $id
 * @property integer $employee_id
 * @property integer $task_id
 * @property integer $task_info_id
 * @property integer $tpl_id
 * @property integer $score
 * @property integer $number
 */
class ScoreRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%score_record}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employee_id', 'task_id', 'task_info_id', 'tpl_id', 'score', 'number'], 'integer'],
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
            'task_id' => 'Task ID',
            'task_info_id' => 'Task Info ID',
            'tpl_id' => 'Tpl ID',
            'score' => 'Score',
            'number' => 'Number',
        ];
    }
    
    /**
     * 关联task_info
     */
    public function getTaskInfo(){
        return $this->hasOne(ExamineTaskInfo::className(), ['id' => 'task_info_id']);
    }
    
    /**
     * 关联考核模版选项
     */
    public function getModelOption(){
        return $this->hasOne(ExamineModelOption::className(), ['tpl_id' => 'tpl_id']);
    }
    
    /**
     * 关联考核模版选项
     */
    public function getEmployee(){
        return $this->hasOne(Employee::className(), ['employee_id' => 'employee_id']);
    }
}
