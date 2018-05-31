<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%shield}}".
 *
 * @property integer $employee_id
 * @property integer $task_id
 * @property integer $to_employee_id
 */
class Shield extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shield}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employee_id', 'task_id', 'to_employee_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'employee_id' => 'Employee ID',
            'task_id' => 'Task ID',
            'to_employee_id' => 'To Employee ID',
        ];
    }
}
