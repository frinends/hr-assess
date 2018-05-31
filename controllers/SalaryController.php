<?php
/**
 * 薪资管理controller
 */
namespace app\controllers;
use app\models\Unit;
use app\models\Rank;
use app\models\SalaryModel;
use app\models\Salary;
use yii\web\UploadedFile;
use yii\widgets\LinkPager;


use Yii;


class SalaryController extends \app\commands\HelloController
{
    /**
     * 历年工作总结列表
     * @return type
     */
    public function actionIndex()
    {
        $parames = Yii::$app->request->get();
        
        $salary_model = SalaryModel::find()->where(["status"=>1])->orderBy("weight")->all();
         
        $field = $names = [];
        foreach ($salary_model as $v){
            
            if(!in_array($v["e_name"], [ "company", "rangeCode", "range", "group", "position", "subGroup"])){
                $names[$v["e_name"]] = $v["name"];
                $field[] = Salary::tableName().".".$v["e_name"];
            }
        }
        $field[] = Salary::tableName().".id";
        
        if(!empty($parames)){
            $results  = Salary::getList($field);
            
            $pages = LinkPager::widget(
                        [
                            'pagination' => $results['pages'],
                            'firstPageLabel'=>"首页",
                            'prevPageLabel'=>'上一页',
                            'nextPageLabel'=>'下一页',
                            'lastPageLabel'=>'末页'
                        ]); 
            $results["pages"] = $pages;
        }  else {
            $results["pages"] = NULL;
            $results["model"] = NULL;
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
        $results["names"] = $names;
       
        return $this->render('index', $results);
       
    }
    
    
    /**
     * 上传工资文档
     * @return type
     */
    public function actionAdd(){
        
        $request = \Yii::$app->request;
        if($request->isPost){
            $errors = [];
            $file = UploadedFile::getInstanceByName("file");
            
            if(!$file){
                $errors["salary_file"] = [
                    "err_msg" => "请先上传薪资文件"
                ];
            }elseif(!in_array($file->extension,array('xls','xlsx'))){
                $errors["salary_file"] = [
                    "err_msg" => "文件格式不正确，请上传xls或xlsx格式的文件。"
                ];
            }

            if(!empty($errors)){
                self::packJson(["code"=> -1, "data" => ["errors" => $errors]]);
            }
            $filepath =  \Yii::$app->basePath . "/web/uploads/";

            $filename = date('Y-m-d',time()).'_'.rand(1,9999).".". $file->extension;
            $excelFile = $filepath.$filename;
            $file->saveAs($excelFile);   //保存文件

            $phpexcel = new \PHPExcel();
            
            try {
                $phpexcel = \PHPExcel_IOFactory::load($excelFile)->getSheet(0);//载入文件并获取第一个sheet  
                
            } catch (Exception $ex) {
                
            }
            $total_line  = $phpexcel->getHighestRow();//总行数 
            $total_column= \PHPExcel_Cell::columnIndexFromString($phpexcel->getHighestColumn());//总列数  
            
            $start_row = 0;
            for($row = 0;$row <= $total_line; $row++){
                $firstRow = trim($phpexcel->getCell("A".$row)->getValue());
                if($firstRow == "序号"){
                    $start_row = $row;
                    break;
                }
            }
            if($start_row == 0){
                echo json_encode("上传的文件内容不正确");
                Yii::$app->end();
            }
            for($column = 1; $column < $total_column; $column++){
                $data[$column] = trim($phpexcel->getCellByColumnAndRow($column, $start_row)->getValue());
            }
           
            //获取模版
            $response = $this->escape($data);
            $start_row++;
           
            for($row = $start_row;$row <= $total_line; $row++){
                unset($model);
                $columns = [];
                for($column = 1; $column <= $total_column; $column++){
                    $columns[] = $phpexcel->getCellByColumnAndRow($column, $row)->getValue();
                }
                
                $model = Salary::findOne(["salary"=> $columns[array_search("salary", $response["field"])], "year" => $columns[array_search("year", $response["field"])] ,"month"=> $columns[array_search("month", $response["field"])], "employee_number"=>$columns[array_search("employee_number", $response["field"])]]);

                if(empty($model)){
                    $model = new Salary();
                }
                
               
                foreach ($response["field"] as $k => $v){
                    $model->$v = $columns[$k];
                }
                $model->save();
            }
            
            echo json_encode("上传成功");
            Yii::$app->end();
            
        }
        return $this->render('add', []);
    }
    
    
    /**
     * 获取模版
     * @param type $content
     * @return type
     */
    private function escape($content){
        $all = SalaryModel::find()->all();
        $colNameArr = [];
        
        foreach ($all as $v){
            $colNameArr[$v["e_name"]] = $v["name"];
        }
        
        $response = [];
        
        foreach ($content as $k => $v){
            if(in_array($v, $colNameArr)){
                $response["key"][] = $k;
                $response["field"][] = array_search($v, $colNameArr);
                
            }else{
               $response["error"][] = $v; 
            }
        }
        return $response;
    }
    
    
    /**
     * 设置薪资模版
     * @return type
     */
    public function actionModel(){
        $list = SalaryModel::find()->orderBy("status desc, weight asc")->all();
        return $this->render("model", ["list"=>$list]);
    }
    
    public function actionChangeweight(){
        $params = Yii::$app->request->post();
        foreach ($params["weight"] as $k=>$v){
            $c = SalaryModel::updateAll(["weight"=>$v], "id=".$k);
           
        }
        self::packJson(["code"=> 0, "data" => ["reload" => 1]]);
    }

        /**
     * 添加薪资模版
     */
    public function actionAddmodel(){
        
        $params = Yii::$app->request->post();
        
        $errors = [];
        if(empty($params["name"])){
            $errors["name"] = [
                "err_msg" => "请填写中文模版名称"
            ];
        }
        
        if(empty($params["e_name"])){
            $errors["e_name"] = [
                "err_msg" => "请填写英文模版名称"
            ];
        }
        
        if(!preg_match("/^[a-zA-Z\s]+$/",$params["e_name"])){
            $errors["e_name"] = [
                "err_msg" => "请勿使用其它字符"
            ];
        }

        if(!empty($errors)){
            self::packJson(["code"=> -1, "data" => ["errors" => $errors]]);
        }
        
        $s = SalaryModel::find()->where(["name" => $params["name"]])->one();
        if($s){
            $errors["name"] = [
                "err_msg" => "模版名称已存在"
            ];
        }
        
        $s = SalaryModel::find()->where(["e_name" => $params["e_name"]])->one();
        if($s){
            $errors["e_name"] = [
                "err_msg" => "模版名称已存在"
            ];
        }
        if(!empty($errors)){
            self::packJson(["code"=> -1, "data" => ["errors" => $errors]]);
        }
        
        $e_name = preg_replace('# #', '', $params["e_name"]);
      
        //表增加字段
        try {
            $table = Salary::tableName();
            $sql = "alter table {$table} add {$e_name} decimal(10,2) DEFAULT 0 COMMENT '{$params["name"]}'";
            $connection = Yii::$app->db;
            $connection->createCommand($sql)->query();
        } catch (Exception $ex) {
            self::packJson(["code"=> -1, "data" => ["reload" => 1, "msg" => "系统错误，请稍候再试！"]]);
        }
        
        $model = new SalaryModel();
        $model->name = trim($params["name"]);
        $model->e_name = $e_name;
        $model->weight = (int)$params["weight"];
        $model->status = 1;
        $model->save();
        self::packJson(["code"=> 0, "data" => ["msg" => "密码修改成功", "reload" => 1]]); 
    }
    
    /**
     * 薪资模版操作
     * @param type $id
     */
    public function actionHandle($id){
        
        $model = SalaryModel::findOne($id);
        
        $model->status = $model->status == 1 ? 0 : 1;
        if($model && $model->save())
            self::packJson(["code"=> 0, "data" => ["reload" => 1]]);

        self::packJson(["code"=> -1, "data" => ["reload" => 1, "msg" => "系统错误，请稍候再试！"]]);
      
    }
    
    
    /**
     * 删除记录
     * @param type $id
     */
    public function actionDel($id){
        if(Yii::$app->user->getIdentity()->role == "admin"){
            $model = Salary::find()->where(["id"=>$id])->one();
            $model->delete();
            self::packJson(["code"=> 0, "data" => ["reload" => 1]]);
        }
    }
    
}
