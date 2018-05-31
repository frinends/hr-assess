<?php
/**
 * 员工总结
 */
namespace app\controllers;

use Yii;
use app\models\WorkSummaryContent;
use app\models\WorkSummary;



class StaffsummaryController extends \app\commands\EmployeeController
{
    
    public function actions() {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
            ]
        ];
    }

    /**
     * 我的工作总结列表
     * @return type
     */
    public function actionIndex()
    {
        $results = WorkSummary::getList(100, Yii::$app->user->getIdentity()->dep_id);
        $list = [];
        $rank = Yii::$app->user->getIdentity()->rank_id;
        foreach ($results["model"] as $v){
            
            if(in_array($rank, explode(",", $v->ranks)) || $v->ranks == 0){
                $list[] = $v;
            }
        }
        return $this->render('index', ["list"=>$list]);
       
    }
    
    /**
     * 工作总结详情
     * @param type $id
     */
    public function actionInfo($id){
        $content["model"] = WorkSummaryContent::getMyInfo($id, Yii::$app->user->getId());
        $content["wmodel"] = WorkSummary::find()->where(["work_id"=>$id])->one();
        
        if(empty($content["model"])){
            return $this->render('content_info_no', $content);
        }
        return $this->render('content_info', $content);
    }
    
    /**
     * 工作总结详情
     * @param type $id
     */
    public function actionOther_info($id, $employee){
        $content["model"] = WorkSummaryContent::getMyInfo($id, $employee);
        $content["tt"] = "work";
        if(empty($content["model"])){
           
            return $this->render('content_info_no', $content);
        }
        return $this->render('content_info', $content);
    }
    
    
    /**
     * 上传工作总结
     * @param type $id
     * @return type
     */
    public function actionAdd(){
        
        $id = Yii::$app->request->get("id");
        $model = WorkSummary::find()->where(["work_id" => $id])->one();
        $request = Yii::$app->request;
        if($request->isPost){
            $params = Yii::$app->request->post();
            $workModel = new WorkSummaryContent();
            $workModel->employee_id = Yii::$app->user->getId();
            $workModel->work_id = $id;
            $workModel->content = $params["w0"];
            $workModel->ins_time = date("Y-m-d H:i:s");
            $workModel->save();
           
            return $this->redirect(Yii::$app->urlManager->createUrl(["staffsummary/info", "id"=>$id]));
        }
        return $this->render("add", ["model"=>$model]);
    }
    
    
    /**
     * 修改工作总结
     * @param type $id
     */
    public function actionUpdate($id){
        
        $model = WorkSummary::find()->where(["work_id" => $id])->one();
        $content = WorkSummaryContent::find()->where(["work_id" => $id, 'employee_id' => Yii::$app->user->getId()])->one();
        
        $request = Yii::$app->request;
        if($request->isPost){
            $params = Yii::$app->request->post();
 
            $content->content = $params["w0"];
         
            $content->save();
            return $this->redirect(Yii::$app->urlManager->createUrl(["staffsummary/info", "id"=>$id]));
        }
        return $this->render("update", ["model"=>$model, "content" => $content]);
    }
    
}
