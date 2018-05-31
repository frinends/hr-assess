<?php
/**
 * 公司管理
 */
namespace app\controllers;

use app\models\Unit;//单位model
use app\models\Department;//部门model
use app\models\Rank;//职级model
use app\models\Charge;//分管关系model

use Yii;


class CompanyController extends \app\commands\HelloController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    /**
     * 单位list
     */
    public function actionUnit(){
        $list = Unit::find()->orderBy("unit_status")->all();
        return $this->render('unit', ["list"=>$list]);
    }
    
    /**
     * 单位详情
     * @param type $id
     * @return type
     */
    public function actionUnit_detail($id){
        $unit_info = Unit::findOne($id);
        return $this->render('unit_detail', ["info"=>$unit_info]);
    }
    
    /**
     * 删除单位
     * @param type $id
     */
    public function actionUnit_del($id){
        $model = Unit::findOne($id);
        
        $model->unit_status = $model->unit_status == Unit::$status_false ? Unit::$status_true : Unit::$status_false;
        if($model && $model->save())
            self::packJson(["code"=> 0, "data" => ["reload" => 1]]);

        self::packJson(["code"=> -1, "data" => ["reload" => 1, "msg" => "系统错误，请稍候再试！"]]);
      
    }
    
    /**
     * 添加/修改单位
     */
    public function actionUnit_handle(){
        $errors = [];
        $params = Yii::$app->request->post();
        
        if(!isset($params["unit_name"]) || empty($params["unit_name"])){
            $errors["unit_name"] = [
                "err_msg" => "单位名称不能为空"
            ];
        }
        if(mb_strlen($params["unit_name"], "UTF8") > 20){
            $errors["unit_name"] = [
                "err_msg" => "单位名称最长不能超过20个字符"
            ];
        }
        if(!empty($errors)){
            self::packJson(["code"=> -1, "data" => ["errors" => $errors]]);
        }
        if(isset($params["unit_id"]) && $params["unit_id"] > 0)
            $model = Unit::findOne($params["unit_id"]);
        else
            $model = new Unit();

        $model->attributes = $params;
        $model->save();
        
        self::packJson(["code"=> 0, "data" => ["msg" => "添加成功", "reload" => 1]]);
    }

    /**
     * 部门list
     */
    public function actionDepartment(){
        $list = Department::find()->joinWith("unit")->all();
        $units = Unit::find()->where(["unit_status" => Unit::$status_true])->all();
        return $this->render('department', ["list"=>$list, "units"=>$units]);
    }
    
    /**
     * 部门详情
     * @param type $id
     * @return type
     */
    public function actionDepartment_detail($id){
        $department_info = Department::findOne($id);
        $units = Unit::find()->where(["unit_status" => Unit::$status_true])->all();
        return $this->render("department_detail", ["info" => $department_info, "units"=>$units]);
    }
    
    /**
     * 停用部门
     * @param type $id
     */
    public function actionDepartment_del($id){
        $model = Department::findOne($id);
        
        $model->dep_status = $model->dep_status == Department::$status_false ? Department::$status_true : Department::$status_false;
        if($model && $model->save())
            self::packJson(["code"=> 0, "data" => ["reload" => 1]]);

        self::packJson(["code"=> -1, "data" => ["reload" => 1, "msg" => "系统错误，请稍候再试！"]]);
    }
    
    /**
     * 部门管理 - handle
     */
    public function actionDepartment_handle(){
        $errors = [];
        $params = Yii::$app->request->post();
        if(!isset($params["unit_id"]) || empty($params["unit_id"])){
            $errors["unit_id"] = [
                "err_msg" => "请选择一个单位"
            ];
        }
        if(!isset($params["dep_name"]) || empty($params["dep_name"])){
            $errors["dep_name"] = [
                "err_msg" => "部门名称不能为空"
            ];
        }
        if(mb_strlen($params["dep_name"], "UTF8") > 20){
            $errors["dep_name"] = [
                "err_msg" => "部门名称最长不能超过20个字符"
            ];
        }
        if(!empty($errors)){
            self::packJson(["code"=> -1, "data" => ["errors" => $errors]]);
        }
        if(isset($params["dep_id"]) && $params["dep_id"] > 0)
            $model = Department::findOne($params["dep_id"]);
        else
            $model = new Department();

        $model->attributes = $params;
        $model->save();
        
        self::packJson(["code"=> 0, "data" => ["msg" => "操作成功", "reload" => 1]]);
        
    }
    
    /**
     * 职级list
     */
    public function actionRank(){
        $list = Rank::find()->all();
        return $this->render('rank', ["list"=>$list]);
    }
    
    /**
     * 职级详情
     * @param type $id
     * @return type
     */
    public function actionRank_detail($id){
        $rank_info = Rank::findOne($id);
        
        return $this->render("rank_detail", ["info" => $rank_info]);
    }
    
    /**
     * 停用职级
     * @param type $id
     */
    public function actionRank_del($id){
        $model = Rank::findOne($id);
        
        $model->rank_status = $model->rank_status == Rank::$status_false ? Rank::$status_true : Rank::$status_false;
        if($model && $model->save())
            self::packJson(["code"=> 0, "data" => ["reload" => 1]]);

        self::packJson(["code"=> -1, "data" => ["reload" => 1, "msg" => "系统错误，请稍候再试！"]]);
    }
    
    /**
     * 职级管理 - handle
     */
    public function actionRank_handle(){
        $errors = [];
        $params = Yii::$app->request->post();
        
        if(!isset($params["rank_name"]) || empty($params["rank_name"])){
            $errors["rank_name"] = [
                "err_msg" => "职级名称不能为空"
            ];
        }
        if(mb_strlen($params["rank_name"], "UTF8") > 20){
            $errors["rank_name"] = [
                "err_msg" => "职级名称最长不能超过20个字符"
            ];
        }
        if(!empty($errors)){
            self::packJson(["code"=> -1, "data" => ["errors" => $errors]]);
        }
        if(isset($params["rank_id"]) && $params["rank_id"] > 0)
            $model = Rank::findOne($params["rank_id"]);
        else
            $model = new Rank();

        $model->attributes = $params;
        $model->save();
        
        self::packJson(["code"=> 0, "data" => ["msg" => "操作成功", "reload" => 1]]);
        
    }
    
    
    /**
     * 分管关系
     */
    public function actionIn_charge(){
        $dep_list = Department::find()->all();
     
        $list = Charge::find()->joinWith(["department", "employee"])->all();
        return $this->render("charge", ["list" => $list, "dep_list" => $dep_list]);
    }
    
    
    /**
     * 添加分管关系
     */
    public function actionCharge_add(){
        $errors = [];
        $params = Yii::$app->request->post();
        
        if(!isset($params["manage_people"]) || empty($params["manage_people"])){
            $errors["manage_people"] = [
                "err_msg" => "管理人不能为空"
            ];
        }
       
        if(!isset($params["dep"]) || empty($params["dep"])){
            $errors["dep"] = [
                "err_msg" => "请选择一个部门"
            ];
        }
        
        if(!empty($errors)){
            self::packJson(["code"=> -1, "data" => ["errors" => $errors]]);
        }
        $employees = $params["manage_people"];
        $employee = \app\models\Employee::find()->where(['or', [ 'name' => $employees], [ 'employee_number' => $employees]])->one();
        if(empty($employee)){
            $errors["manage_people"] = [
                "err_msg" => "管理人不存在"
            ];
            self::packJson(["code"=> -1, "data" => ["errors" => $errors]]);
        }
        $model = new Charge();
        $model->employee_id = $employee["employee_id"];
        $model->dep_id = (int)$params["dep"];
        $model ->save();
        
        self::packJson(["code"=> 0, "data" => ["msg" => "操作成功", "reload" => 1]]);
    }
    
    
    /**
     * 删除分管关系
     */
    public function actionCharge_del($id){
        $mode = Charge::findOne($id);
        $mode->delete();
        self::packJson(["code"=> 0, "data" => ["reload" => 1]]);
    }
}
