<?php
/**
 * 员工绩效考核controller
 */
namespace app\controllers;
use app\models\ExamineTask;
use app\models\ExamineTaskInfo;
use app\models\Employee;
use app\models\Charge;
use app\models\ExamineModel;
use app\models\ExamineTaskScoreRecord;
use app\models\ScoreRecord;
use app\models\ExamineTaskOther;
use yii\data\Pagination;
use Yii;

class PtaskController extends \app\commands\EmployeeController
{
    /**
     * 我的考核任务
     * @return type
     */
    public function actionIndex(){
        
        $condition = ['status'=>1];
        
        $results = ExamineTask::find()->where($condition)->andFilterWhere(['like', 'departments', Yii::$app->user->getIdentity()->dep_id])->all();
        $list = [];
        $user = \Yii::$app->user->getIdentity();
        
        foreach($results as $result){
            $tasks = ExamineTaskInfo::find()->where(["task_id" => $result->task_id])->all();
            
            //屏蔽不参与考核人员
            $other = ExamineTaskOther::find()->where(["task_id"=>$result->task_id])->one();
            if(!empty($other) && in_array($user->employee_id, explode(",", $other->employee))){
                continue;
            }
            $is_true = false;
            foreach ($tasks as $task){
                
                switch ( $task->examine_people_type ){
                    case "1"://所有
                        if($user->rank_id == $task->examine_people){
                            $is_true = true;
                        }
                        break;
                    case "2"://本部门
                        if($user->rank_id == $task->examine_people){
                            $is_true = true;
                        }
                        break;
                    case "3"://指定人员
                        if(in_array($user->employee_id, explode(",", $task->examine_people))){
                            $is_true = true;
                        }
                        break;
                }
                if($is_true){
                    break;
                }                
            }
            if($is_true){
                $list[] = $result;
            }
        }        
        return $this->render('index', ["list"=>$list]);
    }
    
    /**
     * 考核任务详情
     */
    public function actionInfo($id){
     
        $user = \Yii::$app->user->getIdentity();
        
        $e_task = ExamineTask::findOne($id);
        $t = date("Y-m-d");
        if(!$e_task || $e_task->status != 1){
            return $this->redirect(\Yii::$app->urlManager->createUrl("site/nopermission"));
        }
        $list = [];
        
        $tasks = ExamineTaskInfo::find()->joinWith(["toExamineRank"])->where(["task_id" => $id, "examine_people" => $user->rank_id])->all();
        $info_ids = [];
        
        foreach ($tasks as $task){
           
            $e_sql = "";
            switch ($task->examine_people_type){
                //所有的符合要求的对象
                case "1":
                    $e_sql = "select employee_id from sh_employee where rank_id=".$task->was_to_examine_people;
                    break;
                //所有的本部门对象
                case "2":
                    if($user->rank_id == 5 && $task->was_to_examine_people == 2){
                        $chs = Charge::find()->where(["dep_id" => $user->dep_id])->all();
                        $em_id = [];
                        foreach ($chs as $ch){
                            $em_id[] = $ch->employee_id;
                        }
                        $e_sql = "select employee_id from sh_employee where rank_id=".$task->was_to_examine_people;
                        if(!empty($em_id)){
                            $e_sql .= " and employee_id in (".implode(',', $em_id).")";
                        }

                    }else{
                        $charges = Charge::find()->where(["employee_id" => $user->employee_id])->limit(10)->all();
                        $dep = [];
                        $em_id = [];
                        foreach ($charges as $charge){
                            $dep[] = $charge->dep_id;
                        }
                        array_push($dep, $user->dep_id);
                        $e_sql = "select employee_id from sh_employee where dep_id in(".implode(',', $dep).") and rank_id=".$task->was_to_examine_people;
                    }
                    break;
                //指定人员
                case "3":
                    $e_sql = "select employee_id from sh_employee where employee_id in(".$task->was_to_examine_people.")";
                    break;
            }
            
            
            
            
            //屏蔽的人员
            $shield = \app\models\Shield::find()->where(["task_id"=>$task->task_id, "employee_id"=>$user->employee_id])->all();
            $employee_id = [];
            foreach ($shield as $v){
                $employee_id[] = $v->to_employee_id;
            }
            
            
            //不参与考核的
            $other = ExamineTaskOther::find()->where(["task_id"=>$e_task->task_id])->one();
            if($other){
                $other_e = explode(",", $other->employee);
                $employee_id = array_merge($employee_id, $other_e);
            }
            if(!empty($employee_id)){
                $e_sql .= " and employee_id not in (".  implode(',', array_unique($employee_id)).")";
            }
            
            $text = "去评分";
            $type= 1;
            if(!empty($e_sql)){
                $sql = 'select count(DISTINCT to_employee_id) num FROM sh_examine_task_score_record where ';
                $sql .= ' employee_id='.$user->employee_id.' and task_id='.$task->task_id.' and to_employee_id in('.$e_sql.')';
            }
           
            
            
            if(!empty($sql)){
                //评过分数的人数
//                echo $sql;die;
                $r = \Yii::$app->db->createCommand($sql)->queryOne();
                $num = $r["num"];
                
                //需要评分的人数
                 if($task->was_to_examine_people == 2 && $user->rank_id == 5){
                     $charges = Charge::find()->where(["dep_id" => $user->dep_id])->all();
                    $r_id = [];
                    foreach ($charges as $ch){
                        $r_id[] = $ch->employee_id;
                    }
                    $where = [
                        "employee_id" => $r_id
                    ];
                    
                    $p_r = Employee::find()->where($where)->all();
                    
                }else{
                    $p_r = \Yii::$app->db->createCommand($e_sql)->queryAll();
                }
                $p_num = count($p_r);
               
                if($p_num == 0){
                    continue;
                }
                $text = $num == 0 ? "去评分" : ($num < $p_num ? "未全部完成" : "修改评分");
                
                $type = $num == 0 ? "1" : ($num < $p_num ? "3" : "2");
            }
            
            $list[] = [
                "name"  => ($task->examine_people_type == "2" ? "本部门" : "") . $task->toExamineRank->rank_name,
                "id"    => $task->id,
                "text"  => $text,
                "type"  => $type
            ];
        }
        
        $tasks = ExamineTaskInfo::find()->where(["task_id" => $id, "examine_people_type" => "3"])->all();
        
        $task_people = [];
        foreach ($tasks as $task){
            if(in_array($user->employee_id, explode(",", $task->examine_people))){
                $employee_id = [];
                
                //屏蔽的人员
                $shield = \app\models\Shield::find()->where(["task_id"=>$task->task_id, "employee_id"=>$user->employee_id])->all();
                foreach ($shield as $v){
                    $employee_id[] = $v->to_employee_id;
                }

                //不参与考核的
                $other = ExamineTaskOther::find()->where(["task_id"=>$e_task->task_id])->one();
                $other_e = explode(",", $other->employee);
                $employee_id = array_merge($employee_id, $other_e);
                
                //本部门人员
                $em = Employee::find()->where(["dep_id" => $user->dep_id])->all();
                foreach ($em as $m){
                    $employee_id[] = $m->employee_id;
                }
                
                $employee_id = array_merge($employee_id, $task_people);
                
                $sql = 'select count(DISTINCT to_employee_id) num FROM sh_examine_task_score_record where employee_id='.$user->employee_id.' and to_employee_id in('.$task->was_to_examine_people.')';
                $sql .= ' AND to_employee_id not in( '.  implode(",", $employee_id).')';
                $r = \Yii::$app->db->createCommand($sql)->queryOne();
                
                $num = $r["num"];
                $to_examine = explode(",", $task->was_to_examine_people);
                $intersect = array_intersect($employee_id, $to_examine);
                
                $p_num = empty($intersect) ? count($to_examine) : count(array_diff($to_examine, $intersect));
                if($p_num == 0){
                    continue;
                }
                $text = $num == 0 ? "去评分" : ($num < $p_num ? "未全部完成" : "修改评分");
                $type = $num == 0 ? "1" : ($num < $p_num ? "3" : "2");
                $list[] = [
                    "name"  => "指定人员考核",
                    "id"    => $task->id,
                    "text"  => $text,
                    "type"  => $type
                ];
                $task_people = array_merge($task_people, $to_examine);
            }
        }
        return $this->render('index_info', ["list"=>$list]);
    }

    
    /**
     * 评分
     */
    public function actionScore(){
        
        $user = \Yii::$app->user->getIdentity();
        $id   = \Yii::$app->request->get("id");
        $type = \Yii::$app->request->get("type");
        $type = (!isset($type) && empty($type)) ? 1 : $type;
        $p = empty(\Yii::$app->request->get("p")) ? 1 : \Yii::$app->request->get("p");
        $offset = ($p-1)*10;
        //考核任务详情
        $e_info = ExamineTaskInfo::findOne($id);
        
        //考核任务详情
        $e_task = ExamineTask::findOne($e_info->task_id);
        
        //考核模版
        $e_model = ExamineModel::find()->joinWith(["tplOption"])->where([ ExamineModel::tableName().".model_id" => $e_info->model_id])->one();
        
        $where = [];
        //考核对象
        switch ($e_info->examine_people_type){
            //所有的符合要求的对象
            case "1":
                $where = [ Employee::tableName().".rank_id" => $e_info->was_to_examine_people ];
                break;
            
            //所有的本部门对象
            case "2":
                $charges = Charge::find()->where(["employee_id" => $user->employee_id])->limit(10)->all();
                $dep = [];
                foreach ($charges as $charge){
                    $dep[] = $charge->dep_id;
                }
                array_push($dep, $user->dep_id);
                
                $where = [Employee::tableName().".rank_id" => $e_info->was_to_examine_people , Employee::tableName().".dep_id" => $dep];
                break;
            //指定人员
            case "3":
                $where = ["employee_id" => explode(",", $e_info->was_to_examine_people)];
               
                break;
        }
        
        $shield = \app\models\Shield::find()->where(["task_id"=>$e_task->task_id, "employee_id"=>$user->employee_id])->all();
        $employee_id = [];
        foreach ($shield as $v){
            $employee_id[] = $v->to_employee_id;
        }
        
        if($type == 3){
            $sql = "select DISTINCT to_employee_id  FROM sh_examine_task_score_record where employee_id=".$user->employee_id." and task_id=".$e_task->task_id;
            
            $s_r = \Yii::$app->db->createCommand($sql)->queryAll();
            $to_employee_id = [];
            foreach ($s_r as $v){
                $to_employee_id[] = (int)$v["to_employee_id"];
            }
            $employee_id = array_unique(array_merge($employee_id, $to_employee_id));
        }
      
        //屏蔽不参与考核人员
        $other = ExamineTaskOther::find()->where(["task_id"=>$e_task->task_id])->one();
        if(!empty($other)){
           
            $employee_id = array_merge($employee_id, explode(",", $other->employee));
        }
        
        //屏蔽已经打过分的
        if($e_info->examine_people_type == 3 && $type != 2){
            $sql = "select DISTINCT to_employee_id  FROM sh_examine_task_score_record where employee_id=".$user->employee_id." and task_id=".$e_task->task_id;
            $s_r = \Yii::$app->db->createCommand($sql)->queryAll();
            $to_employee_id = [];
            foreach ($s_r as $v){
                $to_employee_id[] = (int)$v["to_employee_id"];
            }
            
            $employee_id = array_unique(array_merge($employee_id, $to_employee_id));
        }
        
        //指定员工屏蔽掉本部门的
        if($e_info->examine_people_type == 3){
            $dep_e = Employee::find()->where(["dep_id"=>$user->dep_id])->all();
            foreach ($dep_e as $de){
                $employee_id[] = $de->employee_id;
            }
        }
        //员工考核总助级
        if($user->rank_id == 5 && $e_info->was_to_examine_people == 2){
            $charges = Charge::find()->where(["dep_id" => $user->dep_id])->all();
            $r_id = [];
            foreach ($charges as $ch){
                $r_id[] = $ch->employee_id;
            }
            $where = [
                "employee_id" => $r_id
            ];
            if(empty($employee_id)){
                $employees = Employee::find()->joinWith(["rank", "department"])->where($where)->orderBy('sh_department.sort ASC')->all();
                
                $number = Employee::find()->where($where)->count();
                
            }else{
                $employees = Employee::find()->joinWith(["rank", "department"])->where($where)->andWhere(["not in", "employee_id", $employee_id])->orderBy('sh_department.sort ASC')->all();
                $number = Employee::find()->where($where)->andWhere(["not in", "employee_id", $employee_id])->count();
             
            }
              
        }else{            
            if(empty($employee_id)){
                    $employees = Employee::find()->joinWith(["rank", "department"])->where($where)->orderBy('sh_department.sort ASC')->all();
                    $number = Employee::find()->where($where)->count();
            }else{
                    $employees = Employee::find()->joinWith(["rank", "department"])->where($where)->andWhere(["not in", "employee_id", $employee_id])->orderBy('sh_department.sort ASC')->all();
                    $number = Employee::find()->where($where)->andWhere(["not in", "employee_id", $employee_id])->count();
            }
        }
        $new_employees = [];
        $i = 0;
        
        foreach ($employees as $k => $v){
            if($k < $offset){
                continue;
            }
            if($i == 10){
                break;
            }
            $new_employees[] = $v;
            $i+=1;
        }
       
        $data = [
            "employees" => $new_employees,
            "e_model" => $e_model,
            "e_task" => $e_task,
            "number" => $number,
            "p" => $p
        ];
        
        return $this->render('score', $data);
    }
    
    
    /**
     * 不了解
     */
    public function actionShield(){
        $params = \Yii::$app->request->get(1);
       
        $user = \Yii::$app->user->getIdentity();
        $model = new \app\models\Shield;
        $model->employee_id = $user->employee_id;
        $model->task_id = $params["task_id"];
        $model->to_employee_id = $params["employee_id"];
        $model->save();
        self::packJson(["code"=> 0, "data" => ["msg" => "添加成功"]]);
    }
    
    /**
     * 不了解
     */
    public function actionUnshield(){
        $params = \Yii::$app->request->get(1);
       
        $user = \Yii::$app->user->getIdentity();
        $condition = "employee_id=".$user->employee_id." and task_id=".(int)$params["task_id"]." and to_employee_id=".(int)$params["employee_id"];
        \app\models\Shield::deleteAll($condition);
        
        self::packJson(["code"=> 0, "data" => ["msg" => "解除成功"]]);
    }
    
    public function actionRetshield(){
        $id = \Yii::$app->request->get("id");
        $user = \Yii::$app->user->getIdentity();
        
        $e_task = ExamineTask::findOne($id);

        if(!$e_task || $e_task->status != 1){
            return $this->redirect(\Yii::$app->urlManager->createUrl("site/nopermission"));
        }
        $where = [
            "task_id" => $id,
            "employee_id" => $user->employee_id
        ];
        $shields = \app\models\Shield::find()->where($where)->all();
        $employees = [];
        foreach ($shields as $s){
            
            $employees[] = Employee::find()->joinWith(["unit", "department", "rank"])->where(["employee_id" => $s->to_employee_id])->one();
        }
        
        return $this->render('employees', ["employees"=>$employees, "task_id"=>$id]);
    }
    
    /**
     * 记录打分选项
     */
    public function actionRecord_scores(){
        $params = \Yii::$app->request->post();
        $user = \Yii::$app->user->getIdentity();
        $content = json_decode($params["content"], true);
       
        $model = new ExamineTaskScoreRecord();
        $s_model = new ScoreRecord();
        $task_id = 0;
        $p = 1;
        $info_id = 0;
        $text = "";
        $type = 1;
        foreach ($content as $v){
            $task_id = $v["task_id"];
            $text = $v["text"];
            $type = $v["type"];
            $p = $v["p"] > 1 ? $v["p"] : 1;
            $info_id = $v["info_id"];
            foreach ($v["content"] as $c){
                if(!($c["val"] < 0)){
                    //  记录 Start
                    $condition = [
                        "employee_id"    => (int)$user->employee_id,
                        "to_employee_id" => (int)$v["employee_id"],
                        "task_id"        => (int)$v["task_id"],
                        "tpl_id"         => (int)$c["id"],
                    ];
                    $result = $model->find()->where($condition)->one();
                    if($result){
                        $old_score = $result->score;
                        $model->updateAll(["score" => (string)$c["val"]], "id=".$result->id);
                    }else{
                        $attributes = [
                            "employee_id"    => (int)$user->employee_id,
                            "to_employee_id" => (int)$v["employee_id"],
                            "task_id"        => (int)$v["task_id"],
                            "tpl_id"         => (int)$c["id"],
                            "score"          => (string)$c["val"]
                        ];
                        $model->isNewRecord = true;
                        $model->setAttributes($attributes);
                        $model->save() && $model->id = 0;
                    }
                    // 记录End
                    
                    //记录总分
                    $s_result = $s_model->find()->where(["employee_id" => $v["employee_id"], "task_id" => $v["task_id"], "tpl_id"=>$c["id"], "task_info_id"=>$info_id])->one();
                    
                    if(!$s_result){
                        $s_model->isNewRecord = true;
                        $s_model->employee_id = (int)$v["employee_id"];
                        $s_model->task_id = (int)$v["task_id"];
                        $s_model->tpl_id = (int)$c["id"];
                        $s_model->task_info_id = (int)$info_id;
                        $s_model->score = (int)$c["val"];
                        $s_model->number = 1;
                        $s_model->save() && $s_model->id = 0;
                    }elseif(isset ( $old_score)){
                        $sc = (int)$c["val"] - $old_score;
                        switch ($sc){
                            case $sc > 0:
                                $s_model->updateAll(["score" => ($s_result->score + $sc)], "id=".$s_result->id);
                                break;
                            case $sc == 0:
                                break;
                            case $sc < 0:
                                $s_model->updateAll(["score" => ($s_result->score + $sc)], "id=".$s_result->id);
                                break;
                        }                        
                    }else{
                        $s_model->updateAll(["score" => (int)$c["val"], "number" => 1], "id=".$s_result->id);
                    }
                    unset($old_score);
                }
            }            
        }
        if($text == "下一批"){
            $href = \Yii::$app->urlManager->createUrl(["ptask/score", "type"=>$type, "id"=>$info_id, "p" => $p+1]);
        }else{
            $href = \Yii::$app->urlManager->createUrl(["ptask/info","id"=>$task_id]);
        }
        self::packJson(["code"=> 0, "data" => ["msg" => "添加成功", "href"=> $href]]);
    }
}
