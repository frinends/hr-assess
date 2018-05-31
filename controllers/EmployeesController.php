<?php
/**
 * 员工管理controller
 */
namespace app\controllers;

use app\models\Employee;
use yii\widgets\LinkPager;
use app\models\Unit;
use app\models\Rank;
use app\models\Department;
use app\models\EmployeeLog;
use Yii;

class EmployeesController extends \app\commands\HelloController
{
    
    /**
     * 搜索员工
     */
    public function actionSearch(){
        $request = Yii::$app->request;
        $name = $request->post("name");
        $result = Employee::find()->joinWith(["unit", "department", "rank"])->where(["is_work" => 0])->andWhere(['like','name',$name])->all();
        $employees = [];
        foreach ($result as $v){
            $employees[] = [
                "id" => $v->employee_id,
                "name" => $v->name,
                "dep_name" => $v->department->dep_name,
            ];
        }
        self::packJson(["code"=> 0, "data" => ["employees" => $employees]]);
       
    }
    
    /**
     * 员工列表
     * @return type
     */
    public function actionIndex()
    {
        
        $results = Employee::getList();
       
        $pages = LinkPager::widget(['pagination' => $results['pages'],'firstPageLabel'=>"首页",
                            'prevPageLabel'=>'上一页',
                            'nextPageLabel'=>'下一页',
                            'lastPageLabel'=>'末页']); 
        $results["pages"] = $pages;
        //all unit
        $unit = Unit::find()->where([ "unit_status" => Unit::$status_true])->all();
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
         
        return $this->render('index', $results);
    }
    
    /**
     * 职工详情
     */
    public function actionInfo($id){
        $request = Yii::$app->request;
        $results["model"] = $model = Employee::findOne(["employee_id"=>$id]);
        if($request->isPost && isset($results["model"]) && !empty($results["model"])){
            $errors = [];
            $unit = $request->post("unit");
            $department = $request->post("department");
            $rank = $request->post("rank");
            $is_work = $request->post("is_work");
            $employee_number = $request->post("employee_number");
            if(!isset($employee_number) || empty($employee_number)){
                $errors["employee_number"] = [
                    "err_msg" => "请填写员工编号"
                ];
            }
            if(!isset($unit) || empty($unit)){
                $errors["unit"] = [
                    "err_msg" => "请选择一个单位"
                ];
            }
            
            if(!isset($department) || empty($department)){
                $errors["department"] = [
                    "err_msg" => "请选择一个部门"
                ];
            }
            
            if(!isset($rank) || empty($rank)){
                $errors["rank"] = [
                    "err_msg" => "请选择一个职级"
                ];
            }
            
            if(!empty($errors)){
                self::packJson(["code"=> -1, "data" => ["errors" => $errors]]);
            }
            $model -> name = $request->post("name");
            $model -> identity_card = $request->post("identity_card");
            $model -> employee_number = $request->post("employee_number");
            $model -> position = $request->post("position");
            $model -> sex = $request->post("sex");
            $model -> politics_status = $request->post("politics_status");
            $model -> mobile = $request->post("mobile");
            $model -> email = $request->post("email");
            
            $model -> unit_id = $unit;
            $model -> dep_id = $department;
            $model -> rank_id = $rank;
            $model -> is_work = $is_work;
            
            if(!empty($request->post("pwd_initialize"))){
             
                $model -> password = md5(md5($request->post("employee_number")));
            }
            $model->save();
            self::packJson(["code"=> 0, "data" => ["msg" => "修改成功", "reload" => 1]]);  
            
        }
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
        
        //department
        $departments = Department::findAll(["unit_id" => $results["model"]->unit_id]);
        $department_list = [];
        foreach ($departments as $v){
            $department_list[] = [
                "id" => $v->dep_id,
                "name" => $v->dep_name,
            ];
        }
        $results["department_list"] = $department_list;
        
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
         
        return $this->render('info', $results);
    }
    
    /**
     * 添加职工
     */
    public function actionAdd(){
        $request = Yii::$app -> request;
        $model = new Employee();
        if($request->isPost){
            $errors = [];
            $params = Yii::$app->request->post();
            //vaild
            if(empty($params["name"])){
                $errors["name"] = [
                    "err_msg" => "请填写员工名称"
                ];
            }
            
            if(empty($params["identity_card"])){
                $errors["identity_card"] = [
                    "err_msg" => "请填写员工身份证"
                ];
            }
            
            if(empty($params["employee_number"])){
                $errors["employee_number"] = [
                    "err_msg" => "请填写员工编号"
                ];
            }
            
            if(empty($params["unit"])){
                $errors["unit"] = [
                    "err_msg" => "请选择员工单位"
                ];
            }
            
            if(empty($params["department"])){
                $errors["department"] = [
                    "err_msg" => "请选择员工部门"
                ];
            }
            
            if(empty($params["rank"])){
                $errors["rank"] = [
                    "err_msg" => "请选择员工职级"
                ];
            }
            
            if(empty($params["mobile"])){
                $errors["mobile"] = [
                    "err_msg" => "请填写正确的手机号"
                ];
            }
            
            if(empty($params["email"])){
                $errors["email"] = [
                    "err_msg" => "请填写正确的邮箱"
                ];
            }
            if(!empty($errors)){
                self::packJson(["code"=> -1, "data" => ["errors" => $errors]]);
            }
            
            $model->name = $request -> post("name");
            $model->identity_card = $request -> post("identity_card");
            $model->employee_number = $request -> post("employee_number");
            $model->unit_id = $request -> post("unit");
            $model->dep_id = $request -> post("department");
            $model->position = $request -> post("position");
            $model->rank_id = $request -> post("rank");
            $model->sex = $request -> post("sex");
            $model->politics_status = $request -> post("politics_status");
            $model->mobile = $request -> post("mobile");
            $model->email = $request -> post("email");
            $model->password = md5(md5(Yii::$app -> params["defaultPassword"]));
            $model->save();
            self::packJson(["code"=> 0, "data" => ["msg" => "修改成功", "reload" => 1]]); 
            
        }
        
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
        return $this->render('add', $results);
    }
    
    
    /**
     * 修改密码
     * @return type
     */
    public function actionChange_pwd(){
        
        return $this->render('add', $results);
    }
    
    /**
     * 退出登录
     * @return type
     */
     public function actionLogout()
    {
        $model = EmployeeLog::find()->where(["employee_id"=>  Yii::$app->user->getIdentity()->employee_id])->orderBy("id desc")->one();
        if($model){
            $model->logout_time = date("Y-m-d H:i:s");
            $model->save();
        }
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
    /**
     * 修改密码
     * @return type
     */
    public function actionChangepwd(){
        $request = Yii::$app -> request;
       
        if($request->isPost){
            $errors = [];
            $params = Yii::$app->request->post();
            //vaild
            if(empty($params["old_pwd"])){
                $errors["old_pwd"] = [
                    "err_msg" => "请填写旧密码"
                ];
            }
            
            if(empty($params["new_pwd"])){
                $errors["new_pwd"] = [
                    "err_msg" => "请填写新密码"
                ];
            }
            
            
            if(empty($params["new_pwd_confirm"])){
                $errors["new_pwd_confirm"] = [
                    "err_msg" => "请填写确认密码"
                ];
            }
            if(!empty($errors)){
                self::packJson(["code"=> -1, "data" => ["errors" => $errors]]);
            }
            
            if($params["new_pwd"] == "123456"){
                $errors["new_pwd"] = [
                    "err_msg" => "新密码过于简单，请重新设置"
                ];
            }
            
            if($params["new_pwd_confirm"] != $params["new_pwd"]){
                $errors["new_pwd_confirm"] = [
                    "err_msg" => "2次输入的密码不一致"
                ];
            }
            
            if(!empty($errors)){
                self::packJson(["code"=> -1, "data" => ["errors" => $errors]]);
            }
            
            $identity = Yii::$app->user->getIdentity();
            if($identity->password != md5(md5($params["old_pwd"]))){
                $errors["old_pwd"] = [
                    "err_msg" => "旧密码输入有误"
                ];
                self::packJson(["code"=> -1, "data" => ["errors" => $errors]]);
            }
            
            if($identity->password == md5(md5($params["new_pwd"]))){
                $errors["new_pwd"] = [
                    "err_msg" => "新密码不能与旧密码一样"
                ];
                self::packJson(["code"=> -1, "data" => ["errors" => $errors]]);
            }
            
            Employee::updateAll(["password"=>md5(md5($params["new_pwd"]))], "employee_id=".$identity->employee_id);
            self::packJson(["code"=> 0, "data" => ["msg" => "密码修改成功", "href" => Yii::$app->urlManager->createUrl(["employees/logout"])]]); 
        } 
            
        return $this->render('pwd');
    }

}
