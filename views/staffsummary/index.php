<?php
/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
?>



<div class="row">
    <div class="col-xs-10">
        <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">我的工作总结列表</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered table-hover dataTable" >
                                <thead>
                                    <tr role="row" class="bg-light-blue">
                                        <th class="sorting"  >编号</th>
                                        <th class="sorting"  >名称</th>
                                        <th class="sorting"  >开始时间</th>
                                        <th class="sorting"  >结束时间</th>
                                        <th class="sorting"  >发布时间</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $d = date("Y-m-d");?>
                                    <?php foreach ($list as $k => $v):?>
                                    <tr role="row" class="odd">
                                      <td><?= $k+1;?></td>
                                      <td><a href="<?= Yii::$app->urlManager->createUrl(['staffsummary/info','id' => $v->work_id])?>"><?= $v->work_title;?></a></td>
                                      <td><?= $v->start_time;?></td>
                                      <td><?= $v->end_time;?></td>
                                      <td><?= date("Y-m-d", strtotime($v->pub_time));?></td>
                                      
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