<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%examine_task_other}}".
 *
 * @property integer $task_id
 * @property string $employee
 */
class ExamineTaskOther extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%examine_task_other}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_id'], 'required'],
            [['task_id'], 'integer'],
            [['employee'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'task_id' => 'Task ID',
            'employee' => 'Employee',
        ];
    }
    
    /**
     * 关联职级
     */
    public function getTask(){
        return $this->hasOne(ExamineTask::className(), ['task_id' => 'task_id']);
    }
}
