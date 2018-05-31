<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%employee_resetpwd}}".
 *
 * @property integer $id
 * @property integer $employee_id
 * @property string $token
 * @property string $creat_time
 * @property string $ip
 * @property string $status
 */
class EmployeeResetpwd extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%employee_resetpwd}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employee_id'], 'integer'],
            [['creat_time'], 'safe'],
            [['status'], 'string'],
            [['token', 'ip'], 'string', 'max' => 255],
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
            'token' => 'Token',
            'creat_time' => 'Creat Time',
            'ip' => 'Ip',
            'status' => 'Status',
        ];
    }
}
