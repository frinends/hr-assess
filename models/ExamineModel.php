<?php

namespace app\models;

use Yii;
use app\models\ExamineModelOption;
/**
 * This is the model class for table "{{%examine_model}}".
 *
 * @property integer $model_id
 * @property integer $type
 * @property string $title
 * @property integer $status
 */
class ExamineModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%examine_model}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'status'], 'integer'],
            [['title'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'model_id' => 'Model ID',
            'type' => 'Type',
            'title' => 'Title',
            'status' => 'Status',
        ];
    }
    
     public function getTplOption(){
        
         return $this->hasMany(ExamineModelOption::className(), ['model_id' => 'model_id'])->orderBy("weight asc");
    }
}
