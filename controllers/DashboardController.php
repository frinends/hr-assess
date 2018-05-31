<?php
/**
 * 控制台controller
 */
namespace app\controllers;

use app\models\Employee;
use app\models\EmployeeLog;

use Yii;

class DashboardController extends \app\commands\EmployeeController
{
    /**
     * 个人控制台
     * @return type
     */
    public function actionIndex()
    {
        
        $id = Yii::$app->user->getId();
        $employeeLog = EmployeeLog::find()->where(["employee_id"=> $id ])->orderBy("login_time desc")->limit(2)->all();
        $results["employeeLog"] = [];
        if(isset($employeeLog[1]))
            $results["employeeLog"] = $employeeLog[1];
        
        $results["data"] = Employee::getInfo($id);
        
        return $this->render('index', $results);
    }
}
