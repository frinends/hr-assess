<?php

namespace app\models;

use Yii;
use app\models\Unit;
/**
 * This is the model class for table "sh_department".
 *
 * @property integer $dep_id
 * @property string $dep_name
 * @property integer $dep_status
 */
class Department extends \yii\db\ActiveRecord
{
    public static $status_true = 1;
    public static $status_false = 2;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%department}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unit_id'], 'required'],
            [['unit_id', 'dep_status'], 'integer'],
            [['dep_instime'], 'safe'],
            [['dep_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dep_id' => 'Dep ID',
            'dep_name' => 'Dep Name',
            'dep_status' => 'Dep Status',
        ];
    }
    
    /**
     * 关联unit表
     * @return type
     */
    public function getUnit(){
        return $this->hasOne(Unit::className(), ['unit_id' => 'unit_id']);
    }
}
