<?php
/**
 * 员工薪资查询
 */
namespace app\controllers;
use app\models\SalaryModel;
use app\models\Salary;
use Yii;

class WageController extends \app\commands\EmployeeController
{
    /**
     * 薪资查询
     * @return type
     */
    public function actionIndex()
    {
        
        $salary_model = SalaryModel::find()->where(["status"=>1])->orderBy("weight")->all();
         
        $list = [];
        
        $field = $names = [];
        foreach ($salary_model as $v){
            
            if(!in_array($v["e_name"], [ "company", "position", "rangeCode", "range", "group", "subGroup", "employee_number"])){
                $names[$v["e_name"]] = $v["name"];
                $field[] = $v["e_name"];
            }
        }
        
        $params = Yii::$app->request->get();
        if(isset($params["year"]) && isset($params["month"]) ){
            
            $condition = [
                "employee_number" => Yii::$app->user->getIdentity()->employee_number,
                "year" => (int)$params["year"],
                "month" => (int)$params["month"],
            ];
            $list = Salary::find()->where($condition)->select($field)->all();
        }
      
        return $this->render('index', ["names" => $names, "field" => $field, "list" => $list]);
    }
    

}
