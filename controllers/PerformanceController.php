<?php
/**
 * 绩效考核
 */
namespace app\controllers;
use Yii;

use app\models\ExamineModel;
use app\models\ExamineModelOption;
use app\models\ExamineTaskOther;
use app\models\Rank;
use app\models\ExamineTask;
use app\models\ExamineTaskInfo;
use app\models\Unit;
use app\models\ExamineTaskScore;
use app\models\ExamineTaskScoreRecord;
use app\models\Employee;
use yii\widgets\LinkPager;
use yii\data\Pagination;
use app\models\Department;
use app\models\ExamineTaskWeight;

class PerformanceController extends \app\commands\HelloController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionScoreinfo()
    {
        $request = Yii::$app -> request;
        $params = $request->get();
        $task_id = $params["task_id"];
        $id = $params["id"];
        $list = [];
        $result = ExamineTaskScoreRecord::find()->where(["task_id" => $task_id, "to_employee_id" => $id])->orderBy("employee_id")->groupBy(["employee_id", "to_employee_id"])->all();
        foreach ($result as $v){
            $em = Employee::find()->joinWith(["department", "rank"])->where(["employee_id" => $v->employee_id])->one();
            $sql = "select sum(score) sc from sh_examine_task_score_record where employee_id =". $v->employee_id." and to_employee_id=".$v->to_employee_id ." and task_id=".$task_id;
            $r = \Yii::$app->db->createCommand($sql)->queryOne();
            $list[] = [
                "name" => $em->name,
                "dep_name" => $em->department->dep_name,
                "rank_name" => $em->rank->rank_name,
                "score" => $r["sc"]
            ];
        }
        
        return $this->render('scoreinfo', ["list" => $list]);
    }
    
    
    public function actionScoreexcel()
    {
        $request = Yii::$app -> request;
        $params = $request->get();
        $task_id = $params["task_id"];
        $id = $params["id"];
        $list = [];
        $result = ExamineTaskScoreRecord::find()->where(["task_id" => $task_id, "to_employee_id" => $id])->orderBy("employee_id")->groupBy(["employee_id", "to_employee_id"])->all();
        foreach ($result as $v){
            $em = Employee::find()->joinWith(["department", "rank"])->where(["employee_id" => $v->employee_id])->one();
            $sql = "select sum(score) sc from sh_examine_task_score_record where employee_id =". $v->employee_id." and to_employee_id=".$v->to_employee_id ." and task_id=".$task_id;
            $r = \Yii::$app->db->createCommand($sql)->queryOne();
            $list[] = [
                "name" => $em->name,
                "dep_name" => $em->department->dep_name,
                "rank_name" => $em->rank->rank_name,
                "score" => $r["sc"]
            ];
        }
        
        $objectPHPExcel = new \PHPExcel();
        $objectPHPExcel->setActiveSheetIndex(0);
        //设置excel头
        
        $objectPHPExcel->getActiveSheet()->mergeCells('A1:E1');
        $objectPHPExcel->getActiveSheet()->getStyle("A1:E1")->getFont()->setSize(16)->setBold(true);  
        
        $objectPHPExcel->getActiveSheet()->setCellValue('A1', "得分情况");
        $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('A2','序号');
        $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('B2','人员');
        $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('C2','部门');
        $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('D2','职级');
        $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('E2','总得分');
       
        $objectPHPExcel->setActiveSheetIndex(0)->getStyle("A2:E2")->getFont()->setSize(14);  
        $objectPHPExcel->setActiveSheetIndex(0)->getDefaultRowDimension()->setRowHeight(20); 
        $objectPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setAutoSize(true); 
        $objectPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setAutoSize(true); 
        $objectPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setAutoSize(true); 
        //水平居中
        $objectPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        
        $n = 3;
        foreach ($list as $k => $v){
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$n, $k+1);
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$n, $v["name"]);
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$n, $v["dep_name"]);
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$n, $v["rank_name"]);
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$n, $v["score"]);
            
            $n++;
        }
    $objectPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
    $objectPHPExcel->getActiveSheet()->getPageSetup()->setVerticalCentered(false);
    
    ob_end_clean();
    ob_start();
    $file_name = iconv("UTF-8", "GBK", '得分情况.xls"');
    header('Content-Type : application/vnd.ms-excel');
    header('Content-Disposition:attachment;filename="'.$file_name);
    $objWriter= \PHPExcel_IOFactory::createWriter($objectPHPExcel,'Excel5');
    $objWriter->save('php://output');
        
     
    }
    
    
    /**
     * 发布绩效考核
     */
    public function actionPub(){
        
        $request = Yii::$app -> request;
       
        if($request->isPost){
            $errors = [];
            $params = $request->post();
            //vaild
            if(empty($params["title"])){
                $errors["title"] = [
                    "err_msg" => "考核名称不能为空！"
                ];
            }
            
            if(empty($params["examine_t"])){
                $errors["examine_t"] = [
                    "err_msg" => "请选择开始-结束时间"
                ];
            }
            
            if(empty($params["rank"]) ){
                $errors["rank[]"] = [
                    "err_msg" => "请选择职级"
                ];
            }
            
            if(empty($params["department"])){
                $errors["department[]"] = [
                    "err_msg" => "请选择部门"
                ];
            }
           
            if(!empty($errors)){
                self::packJson(["code"=> -1, "data" => ["errors" => $errors]]);
            }
            $examine_t = explode(" - ", $params["examine_t"]);
            
            $department = implode(",", $params["department"]);
            
            $model = new ExamineTask();
            $model->task_title = $params["title"];
            $model->start_time = date("Y-m-d", strtotime($examine_t[0]));
            $model->end_time = date("Y-m-d", strtotime($examine_t[1]));
            $model->pub_time = date("Y-m-d H:i:s");
            $model->departments = $department;
            $model->work_id = (int)$params["work"];
            $model->status = 0;
            $model->save();
            
            $data = [
                "code"=> 0, 
                "data" => [
                    "msg" => "OK", 
                    "href" => Yii::$app->urlManager->createUrl([
                        "performance/settaskoption",
                        "id"=>$model->task_id, 
                        "ranks"=>  implode(",", $params["rank"])
                        ])
                    ]
            ];
           
            self::packJson($data); 
        }
        //all rank
        $rank = Rank::find()->where(["rank_status" => Rank::$status_true])->all();
        $rank_list=[];
        foreach($rank as $v){
            $rank_list[] = [
                'id'=>$v->rank_id,
                'name'=>$v->rank_name,
            ];
        }
        
        //department
        $departments = Department::findAll(["dep_status"=>1]);
       
        $department_list = [];
        foreach ($departments as $v){
            $department_list[] = [
                "id" => $v->dep_id,
                "name" => $v->dep_name,
            ];
        }
        $results["department_list"] = $department_list;
        
        
        $work_summary = \app\models\WorkSummary::find()->where(["status" => 1])->orderBy("work_id DESC")->all();
        
        $results["rank_list"] = $rank_list;
        $results["work_summary"] = $work_summary;
        return $this->render('pub', $results);
    }
    
    
    /**
     * 设置选项
     * @param type $id
     */
    public function actionSettaskoption($id, $ranks){
        $results["model"] = ExamineTask::find()->where(["task_id" => $id])->one();
        if(!$results["model"] || empty($results["model"])){
           return $this->redirect(Yii::$app->urlManager->createUrl("performance/pub"));
        }
        $request = Yii::$app -> request;
       
        if($request->isPost){
            $errors = [];
            $params = $request->post();
            $ranks = $params["rank"];
//            $weights = $params["weight"];
            $task_models = $params["task_model"];
            $users = $params["users"];
            foreach ($ranks as $k => $rank){
//                $w = 0;
                $is_r = [];
                
                $error = true;
                foreach ($rank as $k1=> $r){
//                    $w+=$weights[$k][$k1];
                    if($r == 999){//指定人员
                        if(empty($users[$k][$k1])){
                            $error = false;
                        }
                    }
                    $new_r = explode("_", $r);
                    $is_r[] = $new_r[0];
                }
                
                
                if (count($is_r) != count(array_unique($is_r)) && !$error){
                    $errors["rank_error[".$k."][]"] = [
                        "err_msg" => "请不要选择重复的考核人；请选择指定人员"
                    ];
                }elseif(!$error){
                    $errors["rank_error[".$k."][]"] = [
                        "err_msg" => "请选择指定人员"
                    ];
                }elseif(count($is_r) != count(array_unique($is_r))){
                    $errors["rank_error[".$k."][]"] = [
                        "err_msg" => "请不要选择重复的考核人"
                    ];
                }
                
//                if($w != 100){
//                    $errors["weight_error[".$k."][]"] = [
//                        "err_msg" => "权重相加不等于100"
//                    ];
//                }
                
            }
            if(!empty($errors)){
                self::packJson(["code"=> -1, "data" => ["errors" => $errors]]);
            }
            //插入记录
            foreach ($ranks as $k => $rank){
                
                foreach ($rank as $k1 => $r){
                    $new_r = explode("_", $r);
                    
                    $model = new ExamineTaskInfo;
                    $model->task_id = (int)$id;
                    $model->weight = 0;
                    $model->examine_people = (string)$new_r[0];
                    $model->examine_people_type = (string)(isset($new_r[1]) ? 2 : 1);
                    $model->was_to_examine_people = (string)$k;
                    $model->model_id = (int)$task_models[$k][$k1];
                    
                    $model->insert();
                }
            }
            
            ExamineTask::updateAll(["status"=>2], "task_id={$id}");
            
            $data = [
                "code"=> 0, 
                "data" => [
                    "msg" => "OK",
                    "href" => Yii::$app->urlManager->createUrl(["performance/task"])
                ]
            ];
            self::packJson($data); 
        }
        
        
        //all task model
        $results["model_list"] = ExamineModel::find()->where(["status"=>1])->orderBy("model_id desc")->all();
        
        //all rank
        $rank = Rank::find()->where(["rank_status" => Rank::$status_true])->all();
        $rank_list = $rank_list_examine = [];
        foreach($rank as $v){
            $rank_list[] = [
                'id'=>$v->rank_id,
                'name'=>$v->rank_name,
            ];
            if(in_array ($v->rank_id, explode(",", $ranks))){
                $rank_list_examine[] = [
                    'id'=>$v->rank_id,
                    'name'=>$v->rank_name,
                ];
            }
        }
        $results["ranks"] = $ranks;
        $results["rank_list"] = $rank_list;
        $results["rank_list_examine"] = $ranks == 0 ? $rank_list : $rank_list_examine;
        return $this->render('task_option', $results);
    }


    /**
     * 模版列表
     * @return type
     */
    public function actionTpl(){
        $list = ExamineModel::find()->orderBy("model_id desc")->where(["status"=>1])->all();
        return $this->render("p_tpl",["list" => $list]);
    }
    
    /**
     * 添加模版列表
     * @return type
     */
    public function actionTpladd(){
        
        $request = Yii::$app -> request;
       
        if($request->isPost){
            $errors = [];
            $params = $request->post();
            if(empty($params["title"])){
                $errors["title"] = [
                    "err_msg" => "请填写标题"
                ];
            }
            
            if(empty($params["type"])){
                $errors["type"] = [
                    "err_msg" => "请选择类型"
                ];
            }
            
            $score = 0;
            foreach ($params["name"] as $k => $name){
                if(empty($name)){
                    $errors["name[{$k}]"] = [
                        "err_msg" => "请选择类型"
                    ];
                }
                if(empty($params["score"][$k])){
                    $errors["score[{$k}]"] = [
                        "err_msg" => "请填写分值"
                    ];
                }
                $score+=$params["score"][$k];
                if($params["type"] == 2){
                    foreach ($params["option"][$k] as $o_k => $o_v){
                    if(empty($o_v)){
                        $errors["option[{$k}][{$o_k}]"] = [
                            "err_msg" => "请填写选项"
                        ];
                    }}
                }
            }
            if($score != 100){
                $errors["msg"] = [
                    "err_msg" => "分值相加不等于100"
                ];
            }
            
            if(!empty($errors)){
                self::packJson(["code"=> -1, "data" => ["errors" => $errors]]);
            }
            
            $model = new ExamineModel();
            $model->type = $params["type"];
            $model->title = $params["title"];
            if(!$model->save()){
                $errors["msg"] = [
                    "err_msg" => "系统错误"
                ];
                self::packJson(["code"=> -1, "data" => ["errors" => $errors]]);
            }
            $model_id = $model->model_id;
            
            foreach ($params["name"] as $k => $name){
                $model_option = new ExamineModelOption();
                $model_option->model_id = $model_id;
                $model_option->title = $params["name"][$k];
                $model_option->contents = implode(",", $params["option"][$k]);
                $model_option->detail = $params["meta"][$k]; 
                $model_option->score = $params["score"][$k]; 
                $model_option->weight = $params["weight"][$k];
                $model_option->save();
            }
            $data = [
                "code"=> 0, 
                "data" => [
                    "msg" => "OK", 
                    "href" => Yii::$app->urlManager->createUrl(["performance/tpl"])
                    ]
            ];
           
            self::packJson($data); 
        }
        return $this->render("p_tpl_add",[]);
    }
    
    
    /**
     * 模版详情
     * @param type $id
     * @return type
     */
    public function actionTplinfo($id){
        $model = ExamineModel::find()->where([ExamineModel::tableName().".model_id"=>$id])->joinWith(["tplOption"])->one();
        return $this->render("p_tpl_info",["model" => $model]);
    }
    
    
    /**
     * 删除模版
     * @param type $id
     */
    public function actionTpldel($id) {
        $model = ExamineModel::find()->where(["model_id"=>$id])->one();
        if(!$model){
            self::packJson(["code"=> -1, "data" => ["reload" => 1, "msg" => "要操作的模版不存在"]]);
        }
        
        $model->status = 0;
        $model->save();
        
        $data = [
            "code"=> 0, 
            "data" => [
                "msg" => "删除成功", 
                "href" => Yii::$app->urlManager->createUrl(["performance/tpl"])
                ]
        ];
        self::packJson($data); 
    }
    
    /**
     * 考核任务列表
     */
    public function actionTask(){
        $results = ExamineTask::find()->where(["status"=>[1, 2]])->orderBy("task_id desc")->all();
        $list = [];
        foreach ($results as $v){
            $partake_count = ExamineTaskScoreRecord::getPartakeCount($v->task_id);
            $all_partake_count = ExamineTaskScoreRecord::getNoPartakeCount($v->task_id);
            $list[] = [
                "task_id" => $v->task_id,
                "task_title" => $v->task_title,
                "partake_count" => $partake_count,
                "no_partake_count" => count($all_partake_count) - $partake_count,
                "start_time" => $v->start_time,
                "end_time" => $v->end_time,
                "pub_time" => $v->pub_time,
                "work_id" => $v->work_id,
                "status" => $v->status,
            ];
        }
       
        return $this->render("task",["list"=>$list]);
    }
    
    /**
     * 考核任务详情
     * @return type
     */
    public function actionTask_info($id){
        
        $data["model"] = ExamineTask::find()->joinWith("taskOption")->where([ExamineTask::tableName().".task_id"=>$id])->one();
        $taskOption = [];

        foreach ($data["model"]["taskOption"] as $v){
            //考核人
            $examine_people = "";
            
            switch ($v->examine_people_type){
                case "1":
                    $rank = Rank::findOne(["rank_id" => $v->examine_people]);
                    $examine_people = "全部".$rank["rank_name"];
                    break;
                case "2":
                    $rank = Rank::findOne(["rank_id" => $v->examine_people]);
                    $examine_people = "本部门".$rank["rank_name"];
                    break;
                case "3":
                    $examine_people = "指定人员";
                    break;
            }
            //模版名称
            $model = ExamineModel::findOne(["model_id"=>$v->model_id]);
            $model_name = $model->title;
            $name = "指定人员";
            if(in_array($v->examine_people_type, ["1", "2"])){
                //被考核人
                $rank = Rank::findOne(["rank_id" => $v->was_to_examine_people]);
                $name = $rank["rank_name"];
            }
            $taskOption[$v->was_to_examine_people]["name"] = $name;
            $taskOption[$v->was_to_examine_people]["option"][] = [
                "weight" => $v->weight,
                "model_name" => $model_name,
                "examine_people" => $examine_people,
            ];
        }
        $data["taskOption"] = $taskOption;
      
        //all unit
        $unit = Unit::find()->where(["unit_status" => Unit::$status_true])->all();
        $unit_list=[];
        foreach($unit as $v){
            $unit_list[] = [
                'id'=>$v->unit_id,
                'name'=>$v->unit_name,
            ];
        }
        $data["unit_list"] = $unit_list;
        
        //all rank
        $rank = Rank::find()->where(["rank_status" => Rank::$status_true])->all();
        $rank_list=[];
        foreach($rank as $v){
            $rank_list[] = [
                'id'=>$v->rank_id,
                'name'=>$v->rank_name,
            ];
        }
        $data["rank_list"] = $rank_list;
        //all task model
        $data["model_list"] = ExamineModel::find()->where(["status"=>1])->orderBy("model_id desc")->all();
        
        return $this->render("task_info", $data);
    }
    
    
    /**
     * 获取人员
     */
    public function actionEmployee(){
        $params = Yii::$app -> request ->post();
        
        $condition = [
            "is_work" => 0
        ];
        if(!empty($params["unit"])){
            $condition["unit_id"] = (int)$params["unit"];
        }
        if(!empty($params["department"])){
            $condition["dep_id"] = (int)$params["department"];
        }
        if(!empty($params["rank"])){
            $condition["rank_id"] = (int)$params["rank"];
        }
        
        $employees = \app\models\Employee::find()->where($condition)->all();
        $html = "<option value=''>请选择考核人员</option>";
        foreach ($employees as $employee){
            $html.= "<option value='".$employee['employee_id']."'>".$employee['name']."</option>";
        }
        echo $html;
    }

    /**
     * 设置其他考核
     * @return type
     */
    public function actionSet_other_task(){
        
        $request = Yii::$app -> request;
       
        if($request->isPost){
            $errors = [];
            $params = $request->post();
            $id = $params["id"];//考核编号
            $model_id = $params["task_model"];//模版ID
//            $weight = $params["weight"];//权重
            
            $people_1 = array_unique($params["people_1"]);//考核人
            $people_2 = array_unique($params["people_2"]);//被考核人
            
            $model = new ExamineTaskInfo();
            $model->task_id = (int)$id;
            $model->weight = 0;
            $model->examine_people = (string)implode(",", $people_1);
            $model->examine_people_type = '3';
            $model->was_to_examine_people = (string)implode(",", $people_2);
            $model->model_id = (int)$model_id;
            
            $model->insert();
            
            self::packJson(["code"=> 0, "data" => ["reload" => 1]]);
           
        }
    }
    
    
    /**
     * 得分记录
     * @param type $id
     */
    public function actionTask_content($id){
        
        $data = ExamineTaskScore::find()->joinWith(["employee"])->where(["task_id" => $id, "tpl_id"=>0]);
       
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '15']);
        
        $model = $data->offset($pages->offset)->limit($pages->limit)->orderBy("id ASC")->all();
        
        $pages = LinkPager::widget(['pagination' => $pages,'firstPageLabel'=>"首页",
                            'prevPageLabel'=>'上一页',
                            'nextPageLabel'=>'下一页',
                            'lastPageLabel'=>'末页']); 
        
        $list = [];
        foreach ($model as $e){
            $content = "";     
            $score_r = ExamineTaskScore::find()->joinWith(["modelOption", "employee"])->where([ExamineTaskScore::tableName().".task_id"=> $id, ExamineTaskScore::tableName().".employee_id"=>$e["employee_id"]])->orderBy(ExamineTaskScore::tableName().".employee_id ASC,". ExamineModelOption::tableName().".weight ASC")->all();
            $a_s = 0;
            foreach ($score_r as $v){
                if($v->tpl_id > 0){
                    $content .= $v->modelOption->title.":".$v->score."  ";
                    $name = $v->employee->name;
                    
                }else{
                    $a_s+= $v->score;
                }
            }
            $list[] = [
                "employee_id"=>$e["employee_id"],
                "content"   => $content,
                "name"      => $name,
                "dep_name"  => $e->employee->department->dep_name,
                "rank_name"  => $e->employee->rank->rank_name,
                "score"     => $a_s
            ];
        }
        

        return $this->render("task_score", ["list" => $list, "pages"=>$pages, "id" => $id]);
    }
    
    /**
     * 导出excel
     */
    public function actionGender_excel($id){
        $model = ExamineTaskScore::find()->joinWith(["employee"])->where(["task_id" => $id, "tpl_id"=>0])->all();
        //任务信息
        $task = ExamineTask::findOne(["task_id" => $id]);
 
        $objectPHPExcel = new \PHPExcel();
        $objectPHPExcel->setActiveSheetIndex(0);
        //设置excel头
        $objectPHPExcel->getActiveSheet()->mergeCells('A1:O1');
        $objectPHPExcel->getActiveSheet()->getStyle("A1:F1")->getFont()->setSize(16)->setBold(true);  
//        $objectPHPExcel->getActiveSheet()->mergeCells('A2:A3');
//        $objectPHPExcel->getActiveSheet()->mergeCells('B2:B3');
//        $objectPHPExcel->getActiveSheet()->mergeCells('C2:C3');
//        $objectPHPExcel->getActiveSheet()->mergeCells('D2:D3');
//        $objectPHPExcel->getActiveSheet()->mergeCells('E2:E3');
        $objectPHPExcel->getActiveSheet()->mergeCells('F2:O2');
        $objectPHPExcel->getActiveSheet()->setCellValue('A1', $task->task_title);
        $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('A2','序号');
        $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('B2','人员');
        $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('C2','部门');
        $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('D2','职级');
        $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('E2','总得分');
        $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('F2','单项得分');
        
        $objectPHPExcel->setActiveSheetIndex(0)->getStyle("A2:F2")->getFont()->setSize(14);  
        $objectPHPExcel->setActiveSheetIndex(0)->getDefaultRowDimension()->setRowHeight(20); 
        $objectPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setAutoSize(true); 
        $objectPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setAutoSize(true); 
        $objectPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setAutoSize(true); 
        //水平居中
        $objectPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
             
        $n = 3;
        foreach ($model as $k => $e){           
            $score_r = ExamineTaskScore::find()->joinWith(["modelOption"])->where([ExamineTaskScore::tableName().".task_id"=> $id, ExamineTaskScore::tableName().".employee_id"=>$e["employee_id"]])->orderBy(ExamineTaskScore::tableName().".employee_id ASC, ". ExamineModelOption::tableName().".weight ASC")->all();
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$n, $k+1);
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$n, $e->employee->name);
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$n, $e->employee->department->dep_name);
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$n, $e->employee->rank->rank_name);
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$n, $e->score);
          
            $m = 0;
            foreach ($score_r as $v){
                if($v->tpl_id > 0){
                    $zimu = self::getAbc($m);
                    $m++;
                    $objectPHPExcel->setActiveSheetIndex(0)->setCellValue($zimu.$n, $v->modelOption->title.":".$v->score);
                }
            }
            
            $n++;
        }
        
        $objectPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
        $objectPHPExcel->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

        ob_end_clean();
        ob_start();
        $file_name = iconv("UTF-8", "GBK", $task->task_title.'-'.date("Y年m月d日").'.xls"');
        header('Content-Type : application/vnd.ms-excel');
        header('Content-Disposition:attachment;filename="'.$file_name);
        $objWriter= \PHPExcel_IOFactory::createWriter($objectPHPExcel,'Excel5');
        $objWriter->save('php://output');
        
    }
    
    public static function getAbc($n){
      $abc = ["F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];
      $re = '';
      if($n<26){
          $re = $abc[$n];
      }else{
         $m = floor($n/26);
         $x = $n%26;
         $re = $abc[$m-1].$abc[$x];
      }
     return $re;
  }

    /**
     * 生成得分
     * @param type $id
     */
    public function actionGender_score($id){
        set_time_limit(300);
       
        //删除以前统计的得分
        $model = new ExamineTaskScore();
        $model->deleteAll("task_id=".$id);
        
        //考核对应的权重
        $task_weight = ExamineTaskWeight::find()->where(["task_id"=>$id])->all();
       
        //获取所有的被考核人
        $b_task_employee = ExamineTaskScoreRecord::getNoPartakeCountA($id);
        
        foreach ($b_task_employee as $v){
         
            //$user_score = [];
            $z_score = [];
            foreach ($task_weight as $w){
                $rank = explode(",", $w->rank);
               
                //获取符合条件的人
                if(in_array(0, $rank)){//有指定人员
                    array_push($rank, 5);
                }
                //符合条件的人员打分情况
                $result = ExamineTaskScoreRecord::find()->select(['tpl_id','score'])->joinWith(["employee"])->where([Employee::tableName().".rank_id" => $rank, "to_employee_id" => $v])->all();
                
                $score = [];
                foreach ($result as $r){
                    
                    
                    $s1 = $r->score;// * ($w->weight/100);
                    $score[$r->tpl_id][] = $s1;
                }
                unset($result);
                
                //总分
                foreach ($score as $k1 => $s){
                    $s1 = (array_sum($s)/count($s)) * ($w->weight/100);
                    $z_score[$k1] = isset($z_score[$k1]) ? ($s1+$z_score[$k1]):$s1;
                }
                unset($score);
            }
            
//            if( empty($user_score) || !($user_score["all_score"]>0)){
//                continue;
//            }
            
            $model->isNewRecord = true;
            $model->employee_id = $v;
            $model->task_id = $id;
            $model->tpl_id = 0;
            $model->score = (string)sprintf("%.2f", array_sum($z_score));
            $model->save() && $model->id=0;
           
            foreach ($z_score as $sk=>$sv){
                $model->isNewRecord = true;
                $model->employee_id = $v;
                $model->task_id = $id;
                $model->tpl_id = $sk;
                $model->score = (string)sprintf("%.2f", $sv);
                $model->save() && $model->id=0;
            }
            unset($z_score);
            
        }
        
        self::packJson(["code"=> 0, "data" => ["reload" => 1]]);
    }
    
    
    /**
     * 开启或关闭
     * @param type $id
     */
    public function actionOperating($id){
        $model = ExamineTask::find()->where(["task_id"=>$id])->one();
        if(in_array($model->status, [1, 2])){
            $model->status = $model->status ==1 ? 2 : 1;
        }
        
        if($model && $model->save()){
            self::packJson(["code"=> 0, "data" => ["reload" => 1]]);
        }
            

        self::packJson(["code"=> -1, "data" => ["reload" => 1, "msg" => "系统错误，请稍候再试！"]]);
        
    }
    
    
    /**
     * 不考核列表
     * @return type
     */
    public function actionOther(){
        $result = ExamineTaskOther::find()->joinWith(["task"])->orderBy("task_id desc")->all();
        $data["result"] = [];
        foreach ($result as $k => $v){
            $employees = Employee::find()->where(["employee_id" => explode(",", $v->employee)])->all();
            $data["result"][] = ["task" => $v, "employees" => $employees];
        }
  
        return $this->render("other", $data);
    }
    
    /**
     * 编辑
     * @param type $id
     * @return type
     */
    public function actionEditother($id){
        $request = Yii::$app -> request;
       
        if($request->isPost){
            
            $params = Yii::$app->request->post();
            //vaild
            
            ExamineTaskOther::updateAll(["employee" => empty($params["employees"]) ? "" : implode(",", $params["employees"])], "task_id=".$id);
            
            self::packJson(["code"=> 0, "data" => ["msg" => "设置成功", "href" => Yii::$app->urlManager->createUrl(["performance/other"])]]); 
        }
        
        $data["task_other"] = ExamineTaskOther::find()->joinWith(["task"])->where([ ExamineTaskOther::tableName().".task_id" => $id])->one();
        $data["employees"] = Employee::find()->where(["employee_id" => explode(",", $data["task_other"]->employee)])->all();
       

        return $this->render("setother_a", $data);
    }
    
    /**
     * 设置不参与考核人
     */
    public function actionSetother(){
        
        $request = Yii::$app -> request;
       
        if($request->isPost){
            $errors = [];
            $params = Yii::$app->request->post();
            //vaild
            if(empty($params["task"])){
                $errors["task"] = [
                    "err_msg" => "请选择考核任务"
                ];
            }
            
//            if(empty($params["employees"])){
//                $errors["e_p"] = [
//                    "err_msg" => "请添加不参与考核人"
//                ];
//            }
            
            if(!empty($errors)){
                self::packJson(["code"=> -1, "data" => ["errors" => $errors]]);
            }
            
            $other = ExamineTaskOther::find()->where(["task_id" => $params["task"]])->one();
            if($other){
                $errors["task"] = [
                    "err_msg" => "考核任务已设置过"
                ];
                self::packJson(["code"=> -1, "data" => ["errors" => $errors]]);
            }
            
            $model = new ExamineTaskOther();//ExamineTaskOther::find()->where(["task_id" => $params["task"]])->one();
            $model->task_id = $params["task"];
            $model->employee = empty($params["employees"]) ? "" : implode(",", $params["employees"]);
            $model->save();
            self::packJson(["code"=> 0, "data" => ["msg" => "设置成功", "href" => Yii::$app->urlManager->createUrl(["performance/other"])]]); 
        }
        $data["result"] = ExamineTask::find()->orderBy("task_id desc")->where(["status"=>["1", "2"]])->all();
        
        return $this->render("setother", $data);
    }
    
    /**
     * 已打分的人
     */
    public function actionTask_handle($id){

        $result = ExamineTaskScoreRecord::getList($id);
        
        $pages = LinkPager::widget(['pagination' => $result['pages'],'firstPageLabel'=>"首页",
                            'prevPageLabel'=>'上一页',
                            'nextPageLabel'=>'下一页',
                            'lastPageLabel'=>'末页']); 
        $result["pages"] = $pages;
        
        $new_model = [];
        foreach ($result["model"] as $v){
            $n = ExamineTaskScoreRecord::isDone($v->task_id, $v->employee_id);
            $new_model[] = [
                "name" => $v->employee->name,
                "dep_name" => $v->employee->department->dep_name,
                "rank_name" => $v->employee->rank->rank_name,
                "employee_id" => $v->employee_id,
                "task_id" => $v->task_id,
                "is_done" => $n > 0 ? 0 : 1//是否完成
            ];
        }
        $result["model"] = $new_model;
        return $this->render("handle", $result);
    }
    
    public function actionTask_handleno($id){
        
        $all_partake = ExamineTaskScoreRecord::getNoPartakeEmployee($id);
   
        $condition["is_work"] = 0;
        $condition["employee_id"] = $all_partake;
        $data = Employee::find()->joinWith(["department", "rank"])->where($condition);
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '15']);
        
        $result["model"] = $data->offset($pages->offset)->limit($pages->limit)->orderBy(Department::tableName().".sort asc,".Rank::tableName().".sort asc")->all();
       
        $pages = LinkPager::widget(['pagination' => $pages,'firstPageLabel'=>"首页",
                            'prevPageLabel'=>'上一页',
                            'nextPageLabel'=>'下一页',
                            'lastPageLabel'=>'末页']); 
        $result["pages"] = $pages;
       
        return $this->render("handleno", $result);
    }
    
    /**
     * 已经评分过的人员
     */
    public function actionAlready(){
        $params = Yii::$app -> request->get();
        $task_id = $params["task_id"];
        $employee_id = $params["employee_id"];
        
        $result = ExamineTaskScoreRecord::getAlreadyList($task_id, $employee_id);
        
        $pages = LinkPager::widget(['pagination' => $result['pages'],'firstPageLabel'=>"首页",
                            'prevPageLabel'=>'上一页',
                            'nextPageLabel'=>'下一页',
                            'lastPageLabel'=>'末页']); 
        $result["pages"] = $pages;
        $result["employee"] = Employee::find()->where(["employee_id" => $employee_id])->one();
        return $this->render("already", $result);
    }
    
    /**
     * 未评分过的人员
     */
    public function actionHnot(){
        $params = Yii::$app -> request->get();
        $task_id = $params["task_id"];
        $employee_id = $params["employee_id"];
        
        //获取屏蔽的人员
        $shield = \app\models\Shield::find()->where(["task_id"=>$task_id, "employee_id"=>$employee_id])->all();
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

        $result = array_diff(array_unique($task_employee), array_unique($no_task_employee));
        
        $data = Employee::find()->joinWith(["department", "rank"])->where(["employee_id" => $result]);
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '15']);
        
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();
       
        $pages = LinkPager::widget(['pagination' => $pages,'firstPageLabel'=>"首页",
                            'prevPageLabel'=>'上一页',
                            'nextPageLabel'=>'下一页',
                            'lastPageLabel'=>'末页']); 
        $result["pages"] = $pages;
        $result["model"] = $model;
        $result["employee"] = $employee;
        return $this->render("hnot", $result);
    }
    
    
    /**
     * 设置权重
     * @param type $id
     */
    public function actionSet_weight($id) {
        
        $request = Yii::$app -> request;
       
        if($request->isPost){
            $errors = [];
            $params = $request->post();
            $weight = $params["weight"];
            $rank = isset($params["rank"]) ? $params["rank"]:NULL;
           
            $num = 0;
            foreach ($weight as $k=>$v){
                if(!($v > 0)){
                    $errors["weight[".$k."]"] = [
                        "err_msg" => "请设置权重"
                    ];
                }
                $num+= $v;
                if(!isset($rank[$k]) || empty($rank[$k])){
                    $errors["see_error"] = [
                        "err_msg" => "请设置考核人员职级"
                    ];
                }
            }
            if(!empty($errors)){
                self::packJson(["code"=> -1, "data" => ["errors" => $errors]]);
            }
            if($num != 100){
                $errors["see_error"] = [
                        "err_msg" => "设置的权重相加不等于100，请重新设置"
                    ];
                self::packJson(["code"=> -1, "data" => ["errors" => $errors]]);
            }
            ExamineTaskWeight::deleteAll(["task_id" => $id]);
            foreach ($weight as $k=>$v){
               
                $model = new ExamineTaskWeight();
                $model->task_id = $id;
                $model->weight = $v;
                $model->rank = implode(",", $rank[$k]);
                $model->save();
            }
            self::packJson(["code"=> 0, "data" => ["msg" => "设置成功", "reload" => 1]]); 
        }
        
        $task_weight = ExamineTaskWeight::find()->where(["task_id"=>$id])->all();
        
        $task_info = ExamineTaskInfo::find()->where(["task_id"=>$id])->groupBy("examine_people")->all();
        
        $ranks = [];
        $is_other = FALSE;
        foreach ($task_info as $v){
            if($v->examine_people_type == 3 && $is_other == false){
                $ranks[] = [
                    "id" => 0,
                    "name" => "指定人员"
                ];
                $is_other = TRUE;
            }else{
                $rank = Rank::find()->where(["rank_id" => $v->examine_people])->one();
                if($rank){
                    $ranks[] = [
                       "id" => $rank->rank_id,
                       "name" => $rank->rank_name
                   ];
                }
               
            }
        }
        $new_task_weight = [];
        foreach ($task_weight as $v){
            
            $rankids = explode(",", $v->rank);
            $rank_s = Rank::find()->where(["rank_id" => $rankids])->all();
            
            $new_task_weight[] = [
                "weight" => $v->weight,
                "is_other" => in_array(0, $rankids) ? 1 : 0,
                "ranks" => $rank_s
            ];
        }
        
        $result["task_weight"] = $new_task_weight;
        $result["ranks"] = $ranks;
        return $this->render("weight", $result);
    }
    
}
