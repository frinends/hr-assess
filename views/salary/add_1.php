<?php
/* @var $this yii\web\View */
?>
<div class="row">
    
    <div class="col-xs-6">
        <div class="box box-success">
            <div class="box-header with-border">
                <button type="button" title="" class="close btn-back" >
                  <span aria-hidden="true">×</span>
                </button>
              <h3 class="box-title">上传薪资</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" enctype="multipart/form-data"  action="<?= Yii::$app->urlManager->createUrl(['salary/add'])?>">
              <div class="box-body">
<!--                <div class="form-group">
                  <label >年</label>
                  <select class="form-control " name="year" style="width: 100%;" tabindex="-1" aria-hidden="true">
                    <option value="">请选择年份</option>
                    <?php for ($i = date("Y"); $i > 2012;$i--):?>
                    <option value="<?= $i?>"><?= $i?></option>
                    <?php endfor;?>
                  </select>
                  <div class="help-block"></div>
                </div>
                <div class="form-group">
                  <label >月</label>
                  <select class="form-control " name="month" style="width: 100%;" tabindex="-1" aria-hidden="true">
                    <option value="">请选择月份</option>
                    <?php for ($i = 1; $i < 13;$i++):?>
                    <option value="<?= $i?>"><?= $i?></option>
                    <?php endfor;?>
                  </select>  
                  
                  <div class="help-block"></div>
                </div>-->
                
                <div class="form-group">
                  <label >薪资文件</label>
                  <input type="file" name="salary_file" >
                  <div class="help-block">请上传excel文件。</div>
                  
                </div>
              </div>
              
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="button" class="btn btn-default btn-back pull-left">返回</button>
                <button type="button" class="btn btn-primary pull-right btn-submit">新增</button>
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