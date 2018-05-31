<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%unit}}".
 *
 * @property integer $unit_id
 * @property string $unit_name
 * @property string $unit_instime
 * @property integer $unit_status
 */
class Unit extends \yii\db\ActiveRecord
{
    public static $status_true = 1;
    public static $status_false = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%unit}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unit_instime'], 'safe'],
            [['unit_status'], 'integer'],
            [['unit_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'unit_id' => 'Unit ID',
            'unit_name' => 'Unit Name',
            'unit_instime' => 'Unit Instime',
            'unit_status' => 'Unit Status',
        ];
    }
}
