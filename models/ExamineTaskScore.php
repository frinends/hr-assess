<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%examine_task_score}}".
 *
 * @property integer $id
 * @property integer $employee_id
 * @property integer $task_id
 * @property integer $tpl_id
 * @property string $score
 */
class ExamineTaskScore extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%examine_task_score}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employee_id', 'task_id', 'tpl_id'], 'integer'],
            [['score'], 'string', 'max' => 200],
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
            'tpl_id' => 'Tpl ID',
            'score' => 'Score',
        ];
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
