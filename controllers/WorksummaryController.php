<?php
/**
 * 工作总结管理controller
 */
namespace app\controllers;
use app\models\WorkSummary;
use yii\widgets\LinkPager;
use app\models\Rank;
use app\models\Department;
use app\models\WorkSummaryContent;
use app\models\Unit;
use Yii;

class WorksummaryController extends \app\commands\HelloController
{
    /**
     * 历年工作总结列表
     * @return type
     */
    public function actionIndex()
    {
        $results = WorkSummary::getList();
       
        $pages = LinkPager::widget(['pagination' => $results['pages'], 'firstPageLabel'=>"首页",
                            'prevPageLabel'=>'上一页',
                            'nextPageLabel'=>'下一页',
                            'lastPageLabel'=>'末页']); 
        $results["pages"] = $pages;
        
        return $this->render('index', $results);
       
    }
    
    /**
     * 创建工作总结任务
     */
    public function actionAdd(){
        $request = Yii::$app -> request;
       
        if($request->isPost){
            $errors = [];
            $params = Yii::$app->request->post();
            //vaild
            if(empty($params["name"])){
                $errors["name"] = [
                    "err_msg" => "工作总结名称"
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
           
            $model = new WorkSummary();
            $model->work_title = $params["name"];
            $model->ranks = implode(",", $params["rank"]);
            $model->departments = implode(",", $params["department"]);
            $model->start_time = date("Y-m-d", strtotime($examine_t[0]));
            $model->end_time = date("Y-m-d", strtotime($examine_t[1]));
            $model->pub_time = date("Y-m-d H:i:s");
            $model->save();
            self::packJson(["code"=> 0, "data" => ["msg" => "OK", "href" => Yii::$app->urlManager->createUrl("worksummary")]]); 
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
        $results["rank_list"] = $rank_list;
        
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
        
        return $this->render('add', $results);
    }
    
    
    public function actionDel($id){
         $model = WorkSummary::findOne(["work_id"=>$id]);
         
         $model->status = $model->status ==1 ? 0 : 1;
          if($model && $model->save()){
            self::packJson(["code"=> 0, "data" => ["reload" => 1]]);
        }
           
        self::packJson(["code"=> -1, "data" => ["reload" => 1, "msg" => "系统错误，请稍候再试！"]]);
         
//         if($model && date("Y-m-d") < $model->start_time){
//             $model->delete();
//             self::packJson(["code"=> 0, "data" => ["reload" => 1]]);
//         }else{
//             self::packJson(["code"=> -1, "data" => ["reload" => 1, "msg" => "操作失败，请稍候再试。"]]);
//         }
    }
    
    
    public function actionInfo($id){
        $model = WorkSummary::findOne(["work_id"=>$id]);
        $request = Yii::$app -> request;
       
        if($model && $request->isPost){
            $errors = [];
            $params = Yii::$app->request->post();
            //vaild
           
            
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
          
            
            $model->ranks = implode(",", $params["rank"]);
            $model->departments = implode(",", $params["department"]);
            
           
            $model->save();
            
            self::packJson(["code"=> 0, "data" => ["msg" => "OK", "href" => Yii::$app->urlManager->createUrl("worksummary")]]); 
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
        $results["rank_list"] = $rank_list;
        
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
        $results["model"] = $model;
        return $this->render('info', $results);
    }
    
     public function actionContent_list($id){
        $results = WorkSummaryContent::getList($id);
        $pages = LinkPager::widget(['pagination' => $results['pages'],'firstPageLabel'=>"首页",
                            'prevPageLabel'=>'上一页',
                            'nextPageLabel'=>'下一页',
                            'lastPageLabel'=>'末页']); 
        $results["pages"] = $pages;
        //all unit
        $unit = Unit::find()->where(["unit_status" => Unit::$status_true])->all();
        $unit_list=[];
        foreach($unit as $v){
            $unit_list[] = [
                'id'=>$v->unit_id,
                'name'=>$v->unit_name,
            ];
        }
        $results["unit_list"] = $unit_list;
        //all rank
        $rank = Rank::find()->where(["rank_status" => Rank::$status_true])->all();
        $rank_list=[];
        foreach($rank as $v){
            $rank_list[] = [
                'id'=>$v->rank_id,
                'name'=>$v->rank_name,
            ];
        }
        $results["rank_list"] = $rank_list;
        return $this->render('content_list', $results);
    }
    
    /**
     * 内容详情
     */
    public function actionContent_info($id){
       
        $content["model"] = WorkSummaryContent::getInfo($id);
        
        return $this->render('content_info', $content);
    }
}
