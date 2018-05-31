<?php
/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
?>



<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">工作总结列表</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                <thead>
                                    <tr role="row" class="bg-light-blue">
                                        <th class="sorting"  >编号</th>
                                        <th class="sorting"  >名称</th>
                                        <th class="sorting"  >开始时间</th>
                                        <th class="sorting"  >结束时间</th>
                                        <th class="sorting"  >状态</th>
                                        <th class="sorting"  ></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $d = date("Y-m-d");?>
                                    <?php foreach ($model as $k => $v):?>
                                    <tr role="row" class="odd">
                                      <td><?= $k+1;?></td>
                                      <td><a href="<?= Yii::$app->urlManager->createUrl(['worksummary/content_list','id' => $v->work_id])?>"><?= $v->work_title;?></a></td>
                                      <td><?= $v->start_time;?></td>
                                      <td><?= $v->end_time;?></td>
                                      <td><?= $v->status == 1 ? "开启中" : "关闭中"?></td>
                                      <td>
                                          <a class="btn btn-primary" href="<?= Yii::$app->urlManager->createUrl(['worksummary/info','id' => $v->work_id])?>">详情</a> 
                                          <a class="btn <?= $v->status == 1 ? "btn-danger" : "btn-success"?> btn-del" href="javascript:;" data-message="确认要<?= $v->status == 1 ? "关闭" : "开启"?>【<?= $v->work_title;?>】吗？" data-link="<?= Yii::$app->urlManager->createUrl(['worksummary/del', 'id' => $v->work_id])?>"><?= $v->status == 1 ? "关闭" : "开启"?></a>
                                         
                                      </td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?= $pages?>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>