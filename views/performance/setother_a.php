<?php
/* @var $this yii\web\View */
?>
<div class="row">
    
    <div class="col-xs-4">
        <div class="box box-success">
            <div class="box-header with-border">
                <button type="button" title="" class="close btn-back" >
                  <span aria-hidden="true">×</span>
                </button>
              <h3 class="box-title">设置不考核名单</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="<?= Yii::$app->urlManager->createUrl(['performance/editother', "id" => $task_other->task_id])?>">
              <div class="box-body">
                <div class="form-group">
                  <label >考核任务</label>
                  <div ><?= $task_other->task->task_title?></div>
 
                  <div class="help-block"></div>
                </div>
                <div class="form-group">
                  <label >不参与考核人</label>
                  <select class="form-control select2 select-people" name="e_p" tabindex="-1" aria-hidden="true">
                    <option value="">请输入不参与考核人员名称</option>
                  </select>
                  <div class="input-group" style="margin-top: 15px;">
                      <?php foreach ($employees as $v):?>
                      <a class="label bg-green" style="white-space:pre;margin:3px 3px;display: block;"><input type="hidden" value="<?= $v->employee_id?>" name="employees[]"><?= $v->name?> x</a>
                      <?php endforeach;?>
                  </div>
                  
                  <div class="help-block"></div>
                </div>
                  
              </div>
               
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="button" class="btn btn-default btn-back pull-left">返回</button>
                <button type="button" class="btn btn-primary pull-right btn-submit">确认</button>
              </div>
            </form>
            <div class="overlay hide">
                <i class="fa fa-refresh fa-spin"></i>
               
            </div>
          </div>
    </div>
</div>