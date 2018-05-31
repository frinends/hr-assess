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
              <h3 class="box-title">工作总结任务详情</h3>
            </div>
            <!-- /.box-header -->
            <?php 
                $disabled = date("Y-m-d") > $model->start_time ? "disabled" : "";
            ?>
            <!-- form start -->
            <form role="form" method="post" action="<?= Yii::$app->urlManager->createUrl(['worksummary/info', 'id' => $model->work_id])?>">
              <div class="box-body">
                <div class="form-group">
                  <label >工作总结名称</label>
                  <input <?= $disabled?> type="text" class="form-control" name="name" value="<?= $model->work_title?>" id="name" placeholder="工作总结名称">
                  <div class="help-block"></div>
                </div>
                <div class="form-group">
                  <label >开始时间 - 结束时间</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                      <input type="text" <?= $disabled?> name="examine_t" value="<?= $model->start_time?> - <?= $model->end_time?>" id="examine_t" class="form-control pull-right" >
                  </div>
                  <div class="help-block"></div>
                </div>
                <?php $ranks = explode(",", $model->ranks); $departments = explode(",", $model->departments);?>
                <div class="form-group">
                  <label >职级</label>
                  <div> <input class="selectall" type="checkbox">全选</div>
                  <br>
                  <div class="input-group">
                  <?php foreach ($rank_list as $v):?>
                      <label><input name="rank[]" class="icheck" <?= in_array($v['id'], $ranks) ? "checked" : ""; ?> type="checkbox" value="<?= $v["id"]?>">&nbsp;&nbsp; <?= $v["name"]?> &nbsp;&nbsp;</label>
                    <?php endforeach;?>
                  </div>

                  <div class="help-block"></div>
                </div>
                  
                  <div class="form-group">
                  <label >部门</label>
                  <div> <input class="selectall" type="checkbox">全选</div>
                  <br>
                  <div class="input-group">
                  <?php foreach ($department_list as $v):?>
                      <label><input name="department[]" class="icheck" <?= in_array($v['id'], $departments) ? "checked" : ""; ?> type="checkbox" value="<?= $v["id"]?>">&nbsp;&nbsp; <?= $v["name"]?> &nbsp;&nbsp;</label><br>
                    <?php endforeach;?>
                  </div>
<!--                  <select <?= $disabled?> class="form-control " style="height:200px" multiple name="department[]" id="department" tabindex="-1" aria-hidden="true">
                    <option value="0">--所有部门--</option>
                    <?php foreach ($department_list as $v):?>
                    <option value="<?= $v['id']?>" <?= (in_array($v['id'], $departments) || $model->departments == 0) ? "selected" : ""; ?>><?= $v["name"]?></option>
                    <?php endforeach;?>
                  </select>-->
                  <div class="help-block"></div>
                </div>
                                
              </div>
                <input type="hidden" id="department_url" value="<?= Yii::$app->urlManager->createUrl('ajaxapi/department')?>">
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
<script>
var s_e = "20153214";
</script>