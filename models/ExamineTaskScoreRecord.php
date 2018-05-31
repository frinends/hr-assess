<?php

namespace app\models;

use app\models\Employee;
use yii\data\Pagination;
use Yii;

/**
 * This is the model class for table "{{%examine_task_score_record}}".
 *
 * @property integer $id
 * @property integer $employee_id
 * @property integer $task_id
 * @property integer $tpl_id
 * @property integer $to_employee_id
 * @property string $score
 */
class ExamineTaskScoreRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%examine_task_score_record}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employee_id', 'task_id', 'tpl_id', 'to_employee_id'], 'integer'],
            [['score'], 'string', 'max' => 200],
        ];
    }
    
    /**
     * 关联人员
     */
    public function getEmployee(){
        return $this->hasOne(Employee::className(), ['employee_id' => 'employee_id']);
    }
    
    /**
     * 关联人员
     */
    public function getEmployeeTo(){
        return $this->hasOne(Employee::className(), ['employee_id' => 'to_employee_id']);
    }
    
    /**
     * 员工列表
     * @return type
     */
    public static function getList($task_id){
        $condition = [];
        
        $condition["task_id"] = $task_id;
        $condition[Employee::tableName().".role"] = 'employee';
        $condition[Employee::tableName().".is_work"] = 0;
        $data = self::find()->joinWith(["employee"])->where($condition)->groupBy("employee_id");

        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '15']);
        
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();
       
        return [
              'model' => $model,
              'pages' => $pages,
        ];
               
    }
    
    public static function getPartakeCount($task_id){
        $condition[Employee::tableName().".role"] = 'employee';
        $condition[Employee::tableName().".is_work"] = 0;
        $condition["task_id"] = $task_id;
        return self::find()->joinWith(["employee"])->where($condition)->groupBy("employee_id")->count();
    }
    
    public static function getNoPartakeEmployee($task_id){
       
        $task_employee = self::getNoPartakeCount($task_id);
        
        $employee_id = [];
        $condition["task_id"] = $task_id;
        $condition[Employee::tableName().".role"] = 'employee';
        $condition[Employee::tableName().".is_work"] = 0;
        $result = self::find()->joinWith(["employee"])->where($condition)->groupBy(self::tableName().".employee_id")->all();
        
        foreach ($result as $r){
            $employee_id[] = $r->employee_id;
        }
       
        return array_diff(array_unique($task_employee), array_unique($employee_id));
    }
    
    /**
     * 所有的被考核人
     * @param type $task_id
     * @return type
     */
    public static function getNoPartakeCount($task_id){
        $task_info = ExamineTaskInfo::find()->where(["task_id" => $task_id])->all();
        $task = ExamineTask::find()->where(["task_id" => $task_id])->one();
        $task_employee = [];
        foreach ($task_info as $v){
            //指定人员
            if($v->examine_people_type == 3){
                $task_employee = array_merge($task_employee, explode(",", $v->was_to_examine_people));
                continue;
            }
            //全部
            
            $employees = Employee::find()->where([ "dep_id" => explode(",", $task->departments), "rank_id" => $v->examine_people, "is_work" => 0])->all();
            foreach ($employees as $e){
                $task_employee[] = $e->employee_id;
            } 
        }
        
        return array_unique($task_employee);
    }
    
    public static function getNoPartakeCountA($task_id){
        
        $result = Employee::find()->joinWith(["department", "rank"])->where(["is_work"=>0, "role" => "employee"])->orderBy(Department::tableName().".sort asc")->all();
        $employee = [];
        foreach ($result as $v){
            $employee[] = $v->employee_id;
        }
        unset($result);
        
        $result = ExamineTaskScoreRecord::find()->where(["task_id" => $task_id, "to_employee_id" => $employee])->groupBy(["to_employee_id"])->all();
        
        $task_employee = [];
        foreach ($result as $v){
            $task_employee[] = $v->to_employee_id;
        }
        unset($employee);
        unset($result);
        return array_unique($task_employee);
    }
    

    /**
     * 获取已评过分的人
     * @param type $task_id
     * @param type $employee_id
     * @return type
     */
    public static function getAlreadyList($task_id, $employee_id){
        $condition = [
            "task_id" => $task_id,
            "employee_id" => $employee_id
        ];
        
        $data = self::find()->with(["employeeTo"])->where($condition)->groupBy("to_employee_id");

        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '15']);
        
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();
       
        return [
              'model' => $model,
              'pages' => $pages,
        ];
        
    }
    
    
    /**
     * 获取未评过分的人
     * @param type $task_id 任务ID
     * @param type $employee_id 员工ID
     * @param type $task_employee 需要考核的人员
     * @param type $no_task_employee 不需要考核的人员
     * @return type
     */
    public static function getHnotList($task_id, $employee_id, $task_employee, $no_task_employee){
        $condition = [
            "task_id" => $task_id,
            "employee_id" => $employee_id,
        ];
        
        $data = self::find()->with(["employeeTo"])->where($condition)->groupBy("to_employee_id");

        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '15']);
        
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();
       
        return [
              'model' => $model,
              'pages' => $pages,
        ];
        
    }

        /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee_id' => 'Employee ID',
            'task_id' => 'Task ID',
            'tpl_id' => 'Tpl ID',
            'to_employee_id' => 'To Employee ID',
            'score' => 'Score',
        ];
    }
    
    
    public static function isDone($task_id, $employee_id){
       
        //获取屏蔽的人员
        $shield = Shield::find()->where(["task_id"=>$task_id, "employee_id"=>$employee_id])->all();
        $no_task_employee[] = $employee_id;
        foreach ($shield as $v){
            $no_task_employee[] = $v->to_employee_id;
        }
        //不参与考核的人员
        $task_other = ExamineTaskOther::find()->where(["task_id" => $task_id])->one();
        if($task_other){
            $no_task_employee = array_merge($no_task_employee, explode(",", $task_other->employee));
        }
        
        //已经考核过的
        $already_employee = ExamineTaskScoreRecord::find()->where(["task_id" => $task_id, "employee_id" => $employee_id])->groupBy("to_employee_id")->all();
        if($already_employee){
            foreach ($already_employee as $m){
                $no_task_employee[] = $m->to_employee_id;
            }
        }
        
        //人员信息
        $employee = Employee::find()->where(["employee_id" => $employee_id])->one();
        
        //考核任务详情
        $task_info = ExamineTaskInfo::find()->where(["task_id" => $task_id])->all();
        
        //被考核的员工
        $task_employee=[];
        foreach ($task_info as $v){
            /*
             * 指定人员考核， check是否是指定人员 --- start ---
             */
            if($v->examine_people_type == 3 && !in_array($employee_id, explode(",", $v->examine_people))){
                continue;
            }
            if($v->examine_people_type == 3 && in_array($employee_id, explode(",", $v->examine_people))){
                $task_employee = array_merge($task_employee, explode(",", $v->was_to_examine_people));
                continue;
            }
            /*
             * 指定人员考核， check是否是指定人员 --- end ---
             */
            
            // 职级不对应的时候屏蔽
            if($v->examine_people != $employee->rank_id){
                continue;
            }
            //对应的全部人员
            if($v->examine_people_type == 1){
                $employees = Employee::find()->where(["rank_id" => $v->was_to_examine_people, "is_work" => 0])->all();
                foreach ($employees as $e){
                    $task_employee[] = $e->employee_id;
                }
                continue;
            }
            //对应的本部门人员
            if($v->examine_people_type == 2){
                //当前用户的部门
                $where = [
                    "rank_id" => $v->was_to_examine_people, 
                    "is_work" => 0
                ];
                //如果被考核人是总助的情况下
                if($v->was_to_examine_people == 2){
                    $charge = \app\models\Charge::find()->where(["dep_id" => $employee->dep_id])->all();
                    $aid_id = [];
                    if(empty($charge)){
                        continue;
                    }
                    foreach ($charge as $c){
                        $aid_id[] = $c->employee_id;
                    }
                    $where["employee_id"] = $aid_id;
                }else{
                    $where["dep_id"] = $employee->dep_id;
                }
                
                $employees = Employee::find()->where($where)->all();
                foreach ($employees as $e){
                    $task_employee[] = $e->employee_id;
                }
                continue;
            }
            
        }

        return count(array_diff(array_unique($task_employee), array_unique($no_task_employee)));
    }
}
