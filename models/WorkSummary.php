<?php

namespace app\models;
use yii\data\Pagination;
use Yii;

/**
 * This is the model class for table "{{%work_summary}}".
 *
 * @property integer $work_id
 * @property string $work_title
 * @property string $ranks
 * @property string $departments
 * @property string $users
 * @property string $start_time
 * @property string $end_time
 * @property integer $status
 * @property string $pub_time
 */
class WorkSummary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%work_summary}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['users'], 'string'],
            [['status'], 'integer'],
            [['pub_time'], 'safe'],
            [['work_title', 'ranks'], 'string', 'max' => 50],
            [['departments'], 'string', 'max' => 100],
            [['start_time', 'end_time'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'work_id' => 'Work ID',
            'work_title' => 'Work Title',
            'ranks' => 'Ranks',
            'departments' => 'Departments',
            'users' => 'Users',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'status' => 'Status',
            'pub_time' => 'Pub Time',
        ];
    }
    
     /**
     * 工作总结列表
     */
    public static function getList($size = 15, $dep=null){
        if(empty($dep)){
            $data = self::find()->orderBy("pub_time desc");
        }else{
            $data = self::find()->andFilterWhere(['like', 'departments', $dep])->orderBy("pub_time desc");
        }
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => $size]);
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();
       
        return [
              'model' => $model,
              'pages' => $pages,
        ];
               
    }
}
