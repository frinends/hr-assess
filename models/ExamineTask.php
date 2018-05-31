<?php

namespace app\models;

use Yii;
use app\models\ExamineTaskInfo;
/**
 * This is the model class for table "{{%examine_task}}".
 *
 * @property integer $task_id
 * @property string $task_title
 * @property string $start_time
 * @property string $end_time
 * @property string $pub_time
 * @property integer $status
 */
class ExamineTask extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%examine_task}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['task_title'], 'string', 'max' => 255],
            [['start_time', 'end_time', 'pub_time'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'task_id' => 'Task ID',
            'task_title' => 'Task Title',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'pub_time' => 'Pub Time',
            'status' => 'Status',
        ];
    }
    
    public function getTaskOption(){
         return $this->hasMany(ExamineTaskInfo::className(), ['task_id' => 'task_id'])->orderBy("id asc");
    }
    
    
}
