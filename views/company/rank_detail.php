<?php
/* @var $this yii\web\View */
?>
<div class="row">
    
    <div class="col-xs-4">
        <div class="box box-success">
            <div class="box-header with-border">
                <button type="button" title="删除" class="close btn-back" >
                  <span aria-hidden="true">×</span>
                </button>
              <h3 class="box-title">职级详情</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="<?= Yii::$app->urlManager->createUrl('company/rank_handle')?>">
              <div class="box-body">
                <div class="form-group">
                  <label >职级名称</label>
                  <input type="text" class="form-control" name="rank_name" value="<?= $info->rank_name?>" placeholder="职级名称">
                </div>
                <div class="form-group">
                  <label >职级状态</label>
                  <select class="form-control" name="rank_status">
                        <option value="1" <?= $info->rank_status == 1 ? "selected" : "";?>>正常</option>
                        <option value="2" <?= $info->rank_status == 2 ? "selected" : "";?>>停用</option>
                  </select>
                </div>
              </div>
                <input type="hidden" value="<?= $info->rank_id?>" name="rank_id">
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="button" class="btn btn-default btn-back pull-left">返回</button>
                <button type="button" class="btn btn-primary pull-right btn-submit">修改</button>
                <span class="label label-success pull-right hide">操作成功</span>
              </div>
            </form>
            <div class="overlay hide">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
          </div>
    </div>
</div>