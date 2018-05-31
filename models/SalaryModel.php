<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%salary_model}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $e_name
 * @property integer $weight
 * @property integer $status
 */
class SalaryModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%salary_model}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['weight', 'status'], 'integer'],
            [['name', 'e_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'e_name' => 'E Name',
            'weight' => 'Weight',
            'status' => 'Status',
        ];
    }
}
