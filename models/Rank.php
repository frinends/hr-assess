<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%rank}}".
 *
 * @property integer $rank_id
 * @property string $rank_name
 * @property string $rank_instiome
 * @property integer $rank_status
 */
class Rank extends \yii\db\ActiveRecord
{
    public static $status_true = 1;
    public static $status_false = 2;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%rank}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rank_instiome'], 'safe'],
            [['rank_status'], 'integer'],
            [['rank_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rank_id' => 'Rank ID',
            'rank_name' => 'Rank Name',
            'rank_instiome' => 'Rank Instiome',
            'rank_status' => 'Rank Status',
        ];
    }
}
