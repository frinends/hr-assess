<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%examine_task_weight}}".
 *
 * @property integer $id
 * @property integer $task_id
 * @property integer $weight
 * @property string $rank
 */
class ExamineTaskWeight extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%examine_task_weight}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_id', 'weight'], 'integer'],
            [['rank'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => 'Task ID',
            'weight' => 'Weight',
            'rank' => 'Rank',
        ];
    }
}
