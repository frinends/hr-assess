<?php

namespace app\models;
use app\models\Rank;
use Yii;

/**
 * This is the model class for table "sh_examine_task_info".
 *
 * @property integer $id
 * @property integer $task_id
 * @property integer $weight
 * @property string $examine_people
 * @property string $examine_people_type
 * @property string $was_to_examine_people
 * @property integer $model_id
 */
class ExamineTaskInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%examine_task_info}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_id', 'weight', 'examine_people', 'examine_people_type', 'was_to_examine_people', 'model_id'], 'required'],
            [['task_id', 'weight', 'model_id'], 'integer'],
            [['examine_people', 'examine_people_type', 'was_to_examine_people'], 'string', 'max' => 255],
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
            'examine_people' => 'Examine People',
            'examine_people_type' => 'Examine People Type',
            'was_to_examine_people' => 'Was To Examine People',
            'model_id' => 'Model ID',
        ];
    }
    
    /**
     * 关联职级
     */
    public function getToExamineRank(){
        return $this->hasOne(Rank::className(), ['rank_id' => 'was_to_examine_people']);
    }
}
