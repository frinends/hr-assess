<?php
/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
$request = Yii::$app->request->get();

?>



<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">绩效考核已评分人员列表</h3>
             
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                <thead>
                                    <tr role="row" class="bg-light-blue">
                                        <th class=" text-center">序号</th>
                                        <th class=" text-center"  >评分人员</th>
                                        <th class=" text-center"  >部门</th>
                                        <th class=" text-center"  >职级</th>
                                        <th class=" text-center"  ></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($model as $k => $v):?>
                                    <tr role="row" class="odd">
                                      <td><?= $k+1;?></td>
                                      <td><?= $v["name"]?></td>
                                      <td><?= $v["dep_name"]?></td>
                                      <td><?= $v["rank_name"]?></td>
                                      <td>
                                          <?php if($v["is_done"] == 0):?>
                                          <a class="btn btn-danger" target="_blank" href="<?= Yii::$app->urlManager->createUrl(['performance/hnot', 'employee_id'=> $v["employee_id"], 'task_id' => $v["task_id"]])?>" >未完成人员</a>
                                          <?php endif;?>
                                          <a class="btn btn-success" target="_blank" href="<?= Yii::$app->urlManager->createUrl(['performance/already', 'employee_id'=> $v["employee_id"], 'task_id' => $v["task_id"]])?>">已完成人员</a>
                                      </td>
                                      
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?=$pages?>
                </div>
            </div>
        </div>
    </div>
</div>
