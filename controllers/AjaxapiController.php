<?php

namespace app\controllers;

use app\models\Department;

class AjaxapiController extends \app\commands\HelloController
{
    public function actionDepartment($id){
        $department = Department::find()->where(["dep_status" => Department::$status_true, "unit_id" => $id])->orderBy("dep_status")->all();
        $response=$list=[];
        foreach($department as $v){
            $list[] = [
                'id'=>$v->dep_id,
                'name'=>$v->dep_name,
            ];
        }
        $response = [
            "code" => 1,
            "result" => [
                "list"=>$list
            ]
        ];
        exit(json_encode($response));
    }
}
