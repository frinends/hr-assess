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
              <h3 class="box-title">发布考核任务</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="<?= Yii::$app->urlManager->createUrl(['performance/pub'])?>">
              <div class="box-body">
                <div class="form-group">
                  <label >考核名称</label>
                  <input type="text" class="form-control" name="title" placeholder="考核名称">
                  <div class="help-block"></div>
                </div>
                <div class="form-group">
                  <label >考核时间</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                      <input type="text" name="examine_t" class="form-control pull-right" id="examine_t">
                  </div>
                  <div class="help-block"></div>
                </div>
                  
                <div class="form-group">
                  <label >对应工作总结</label>
                  <select name="work" class="form-control" >
                        <option value="0">请选择工作总结</option>
                        <?php foreach ($work_summary as $work):?>
                        <option value="<?= $work->work_id?>"><?= $work->work_title?></option>
                        <?php endforeach;?>
                    </select>
                  <div class="help-block"></div>
                </div>
                
                <div class="form-group">
                  <label >被考核人</label>
                  <div> <input class="selectall" type="checkbox">全选</div>
                  <br>
                  <div class="input-group">
                  <?php foreach ($rank_list as $v):?>
                      <label><input name="rank[]" class="icheck" type="checkbox" value="<?= $v["id"]?>">&nbsp;&nbsp; <?= $v["name"]?> &nbsp;&nbsp;</label><br>
                    <?php endforeach;?>
                  </div>
                  <div class="help-block"></div>
                </div>
                  
                <div class="form-group">
                  <label >参与部门</label>
                  <div> <input class="selectall" type="checkbox">全选</div>
                  <br>
                  <div class="input-group">
                  <?php foreach ($department_list as $v):?>
                      <label><input name="department[]" class="icheck" type="checkbox" value="<?= $v["id"]?>">&nbsp;&nbsp; <?= $v["name"]?> &nbsp;&nbsp;</label><br>
                    <?php endforeach;?>
                  </div>
                  <div class="help-block"></div>
                </div>
                                  
                
              </div>
                <input type="hidden" id="department_url" value="<?= Yii::$app->urlManager->createUrl('ajaxapi/department')?>">
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="button" class="btn btn-default btn-back pull-left">返回</button>
                <button type="button" class="btn btn-primary pull-right btn-submit">下一步</button>
                <span class="label label-success pull-right hide">操作成功</span>
              </div>
            </form>
            <div class="overlay hide">
                <i class="fa fa-refresh fa-spin"></i>
               
            </div>
          </div>
    </div>
</div>