<?php
/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title"><?= $e_task->task_title?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered table-hover dataTable score" >
                                <thead>
                                    <tr role="row" class="bg-light-blue">
                                        <th class="text-center">编号</th>
                                        <th class="text-center">姓名</th>
                                        <?php foreach ($e_model->tplOption as $option):?>
                                        <th class="text-center" ><span data-toggle="tooltip" title="<?= $option->detail?>"><?= $option->title?> <?= empty($option->detail) ? "" : '<i class="fa fa-fw fa-exclamation-circle"></i>'?> </span></th>
                                        <?php endforeach;?>
                                        <th class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $model = new app\models\ExamineTaskScoreRecord();?>
                                    <?php foreach ($employees as $k => $employee):?>
                                    <?php
                                        $s_r = $model->find()->where([ "employee_id"=>  Yii::$app->user->getIdentity()->employee_id,  "to_employee_id" => $employee->employee_id, "task_id" => $e_task->task_id])->all();
                                        $t_s = [];
                                        foreach($s_r as $score){
                                            $t_s[$score->tpl_id] = $score->score;
                                        }
                                    ?>
                                    <tr data-employee="<?= $employee->employee_id?>" data-p="<?= $p?>" data-type="<?= $_GET["type"]?>"  data-info="<?= $_GET["id"]?>" data-task="<?= $e_task->task_id?>" role="row">
                                        <td><?= (($p-1)*10)+$k+1?></td>
                                        <td >
                                            <a data-toggle="tooltip" title="部门：<?php echo $employee->department["dep_name"];?>；  职级：<?= $employee->rank->rank_name;?>" href="<?= Yii::$app->urlManager->createUrl(["staffsummary/other_info", "id" => $e_task->work_id, "employee" => $employee->employee_id])?>" target="_blank">
                                                    <?= $employee->name;?><i class="fa fa-fw fa-exclamation-circle"></i>
                                            </a>
                                        </td>
                                        <?php foreach ($e_model->tplOption as $option):?>
                                        <td >
                                            <select data-toggle="tooltip" title="<?= $option->title?>" data-tpl-id="<?= $option->tpl_id?>" class="form-control ">
                                                <option value="-1">请评分</option>
                                                <?php 
                                                    if($e_model->type == 1){                                                       
                                                        for ($i = $option->score; $i>= 0; $i--){
                                                            echo "<option ".(isset($t_s[$option->tpl_id]) && $t_s[$option->tpl_id] == $i ? 'selected' : '')." value='".$i."'>".$i."</option>";
                                                        }
                                                    }else{
                                                        $options = explode(",", $option->contents);
                                                        foreach ($options as $v){
                                                            echo "<option ".(isset($t_s[$option->tpl_id]) && $t_s[$option->tpl_id] == $i ? 'selected' : '')." value='".$v."'>".$v."</option>";
                                                        }
                                                    }
                                                ?>                                                
                                            </select>
                                        </td>    
                                        <?php endforeach;?>
                                        <td><a href="javascript:;" data-link="<?= Yii::$app->urlManager->createUrl(["ptask/shield",["employee_id"=>$employee->employee_id,"task_id"=>$e_task->task_id]])?>" class="shield">不了解</a></td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                               
                            </table>
                            <button type="submit" class="btn btn-success pull-right btn-score"><?= ($p * 10) < $number ? "下一批" : "提交"?></button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>