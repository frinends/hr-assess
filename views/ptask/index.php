<?php
/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
?>



<div class="row">
    <div class="col-xs-10">
        <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">我的考核任务</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered table-hover dataTable" >
                                <thead>
                                    <tr role="row" class="bg-light-blue">
                                        <th class="sorting">编号</th>
                                        <th class="sorting">考核名称</th>
                                        <th class="sorting">开始时间</th>
                                        <th class="sorting">结束时间</th>
                                        <th class="sorting"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $d = date("Y-m-d");?>
                                    <?php foreach ($list as $k => $v):?>
                                    <tr role="row" class="odd">
                                      <td><?= $k+1;?></td>
                                      <td><a href="<?= Yii::$app->urlManager->createUrl(['ptask/info','id' => $v->task_id])?>"><?= $v->task_title;?></a></td>
                                      <td><?= $v->start_time;?></td>
                                      <td><?= $v->end_time;?></td>
                                      <td><a href="<?= Yii::$app->urlManager->createUrl(['ptask/retshield','id' => $v->task_id])?>">找回不了解的人</a></td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>