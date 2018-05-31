<?php
/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
$request = Yii::$app->request->get();

?>



<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">绩效考核任务列表</h3>
              <div class="pull-right box-tools">
                  <button type="button" onclick="location.href='<?= Yii::$app->urlManager->createUrl(["performance/pub"])?>'" class="btn btn-block btn-success " >
                  发布考核任务
                </button>
                
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                <thead>
                                    <tr role="row" class="bg-light-blue">
                                        <th class="sorting text-center">序号</th>
                                        <th class="sorting text-center"  >名称</th>
                                        <th class="sorting text-center"  >已参与评分人数</th>
                                        <th class="sorting text-center"  >未参与评分人数</th>
                                        <th class="sorting text-center"  >开始时间</th>
                                        <th class="sorting text-center"  >结束时间</th>
                                        <th class="sorting text-center"  >状态</th>
                                        <th class="sorting"  ></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($list as $k => $v):?>
                                    <tr role="row" class="odd">
                                      <td><?= $k+1;?></td>
                                      <td><a href="<?= Yii::$app->urlManager->createUrl(["performance/task_content", 'id' => $v["task_id"]])?>"><?= $v["task_title"];?></a></td>
                                      <td><a href="<?= Yii::$app->urlManager->createUrl(["performance/task_handle", 'id' => $v["task_id"]])?>"><?= $v["partake_count"];?></a></td>
                                      <td><a href="<?= Yii::$app->urlManager->createUrl(["performance/task_handleno", 'id' => $v["task_id"]])?>"><?= $v["no_partake_count"];?></a></td>
                                      <td><?= $v["start_time"];?></td>
                                      <td><?= $v["end_time"];?></td>
                                      <td>
                                          <?= $v["status"] == 1 ? "开启中" : "关闭中"?>
                                      </td>
                                      <td>
                                          <a class="btn btn-primary" href="<?= Yii::$app->urlManager->createUrl(['performance/task_info', 'id' => $v["task_id"]])?>">详情</a>
                                          <a class="btn btn-primary" href="<?= Yii::$app->urlManager->createUrl(['performance/set_weight', 'id' => $v["task_id"]])?>">设置权重</a>
                                          <a class="btn <?= $v["status"] == 1 ? "btn-danger" : "btn-success"?> btn-del" href="javascript:;" data-message="确认要<?= $v["status"] == 1 ? "关闭" : "开启"?>【<?= $v["task_title"];?>】吗？" data-link="<?= Yii::$app->urlManager->createUrl(['performance/operating', 'id' => $v["task_id"]])?>"><?= $v["status"] == 1 ? "关闭" : "开启"?></a>
                                      </td>
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
