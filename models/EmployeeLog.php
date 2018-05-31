<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%employee_log}}".
 *
 * @property integer $id
 * @property integer $employee_id
 * @property string $login_time
 * @property string $ip
 * @property string $forwarded_ip
 * @property string $logout_time
 */
class EmployeeLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%employee_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employee_id'], 'integer'],
            [['login_time', 'logout_time'], 'safe'],
            [['ip', 'forwarded_ip'], 'string', 'max' => 255],
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
            'login_time' => 'Login Time',
            'ip' => 'Ip',
            'forwarded_ip' => 'Forwarded Ip',
            'logout_time' => 'Logout Time',
        ];
    }
}
