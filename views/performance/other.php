<?php
/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
$request = Yii::$app->request->get();

?>



<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">不参与考核任务人员列表</h3>
              <div class="pull-right box-tools">
                  <button type="button" onclick="location.href='<?= Yii::$app->urlManager->createUrl(["performance/setother"])?>'" class="btn btn-block btn-success " >
                  设置不考核名单
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
                                        <th class="sorting text-center"  >考核任务名称</th>
                                        <th class="sorting text-center"  >不参与人员</th>
                                        <th class="sorting"  ></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($result as $k => $v):?>
                                    <tr role="row" class="odd">
                                      <td><?= $k+1;?></td>
                                      <td><?= $v["task"]->task->task_title;?></td>
                                      <td>
                                          <?php foreach ($v["employees"] as $e):?>
                                            <?= $e->name."&nbsp;&nbsp;&nbsp;"?>
                                          <?php endforeach;?>
                                      </td>
                                     
                                      <td>
                                          <a class="btn btn-primary" href="<?= Yii::$app->urlManager->createUrl(['performance/editother', 'id' => $v["task"]->task_id])?>">编辑</a>
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
