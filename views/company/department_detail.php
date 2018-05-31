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
              <h3 class="box-title">部门详情</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="<?= Yii::$app->urlManager->createUrl('company/department_handle')?>">
              <div class="box-body">
                  <div class="form-group">
                  <label >单位名称</label>
                  <select class="form-control" name="unit_id">
                      <option value="" <?= $info->dep_status == 2 ? "selected" : "";?>>请选择单位</option>
                      <?php foreach ($units as $v):?>
                        <option value="<?= $v->unit_id;?>" <?= $info->unit_id == $v->unit_id ? "selected" : "";?>><?= $v->unit_name?></option>
                      <?php endforeach;?>
                  </select>
                </div>
                <div class="form-group">
                  <label >部门名称</label>
                  <input type="text" class="form-control" name="dep_name" value="<?= $info->dep_name?>" placeholder="单位名称">
                </div>
                <div class="form-group">
                  <label >部门状态</label>
                  <select class="form-control" name="dep_status">
                        <option value="1" <?= $info->dep_status == 1 ? "selected" : "";?>>正常</option>
                        <option value="2" <?= $info->dep_status == 2 ? "selected" : "";?>>停用</option>
                  </select>
                </div>
              </div>
                <input type="hidden" value="<?= $info->dep_id?>" name="dep_id">
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