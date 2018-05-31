<?php
/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
$request = Yii::$app->request->get();

?>



<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">绩效考核模版列表</h3>
              <div class="pull-right box-tools">
                  <button type="button" onclick="location.href='<?= Yii::$app->urlManager->createUrl(["performance/tpladd"])?>'" class="btn btn-block btn-success " data-toggle="tooltip" title="" data-original-title="添加考核模版">
                  添加
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
                                        <th class="sorting"  >序号</th>
                                        <th class="sorting"  >名称</th>
                                        <th class="sorting"  >类型</th>
                                        
                                        <th class="sorting"  ></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($list as $k => $v):?>
                                    <tr role="row" class="odd">
                                      <td><?= $k+1;?></td>
                                      <td><?= $v->title;?></td>
                                      <td><?= $v->type == 1 ? "分值型" : "选择型";?></td>
                                      <td><a href="<?= Yii::$app->urlManager->createUrl(['performance/tplinfo','id' => $v->model_id])?>">详情</a></td>
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
