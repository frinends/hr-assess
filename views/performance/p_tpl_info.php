<?php
/* @var $this yii\web\View */
?>
<div class="row">

    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-header with-border">
                <button type="button" title="返回" class="close btn-back" >
                    <span aria-hidden="true">×</span>
                </button>
                <h3 class="box-title">考核模版详情</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="">
                <div class="box-body">
                    <div class="form-group">
                        <label ><?= $model->title ?></label>
                        <span class="pull-right"></span>

                    </div>
                    <div class="form-group">
                        <label ><?= $model->type == 1 ? "分值型" : "选择型";?></label>
                        <span class="pull-right"></span>
                    </div>
                    <div class="form-group">
                        
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width: 50px">编号</th>
                                        <th>名称</th>
                                        <th>选项</th>
                                        <th>描述</th>
                                        <th>分值</th>
                                    </tr>
                                    <?php $totalCount= 0;?>
                                    <?php foreach ($model->tplOption as $k => $v):?>
                                    <tr>
                                      <td><?= $k+1?></td>
                                      <td><?= $v->title?></td>
                                      <td><?= $v->contents ?></td>
                                      <td style="max-width: 400px;"><p><?= $v->detail?></p></td>
                                      <td><span class="badge bg-green"><?= $v->score?></span></td>
                                    </tr>
                                    <?php $totalCount+= $v->score;?>
                                    <?php endforeach;?>
                                    <tr>
                                        <th colspan="5" >总分：<?= $totalCount?></th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                    
                </div>
                
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="button" class="btn btn-default btn-back pull-left">返回</button>
                    <button type="button" class="btn btn-danger pull-right btn-del" data-message="确认要删除本模版吗？" data-link="<?= Yii::$app->urlManager->createUrl(["performance/tpldel", "id"=>$model->model_id])?>">删除</button>
                    <span class="label label-success pull-right hide">操作成功</span>
                </div>
            </form>
            <div class="overlay hide">
                <i class="fa fa-refresh fa-spin"></i>
                <!--<span style="position: absolute;top: 70%;left: 45%;margin-left: -15px;margin-top: -15px;color: #000;">提交中……</span>-->
            </div>
        </div>
    </div>
</div>