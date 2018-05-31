<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%examine_model_option}}".
 *
 * @property integer $tpl_id
 * @property integer $model_id
 * @property string $title
 * @property string $contents
 * @property string $detail
 * @property integer $score
 * @property integer $weight
 */
class ExamineModelOption extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%examine_model_option}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_id', 'score', 'weight'], 'integer'],
            [['title'], 'string', 'max' => 100],
            [['contents', 'detail'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tpl_id' => 'Tpl ID',
            'model_id' => 'Model ID',
            'title' => 'Title',
            'contents' => 'Contents',
            'detail' => 'Detail',
            'score' => 'Score',
            'weight' => 'Weight',
        ];
    }
}
