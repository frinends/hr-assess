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
                  <div class="container demo-wrapper">
      
                    <div class="row demo-columns">
                      <div class="col-md-6">

                        <div id="drag-and-drop-zone" class="uploader">

                          <div class="browser">
                            <label>
                              <span>选择薪资文件</span>
                              <input type="file" name="files[]" multiple="multiple" title='选择薪资文件'>
                            </label>
                          </div>
                        </div>
                        
                        <div class="panel panel-default">
                            <div class="panel-heading">
                              <h3 class="panel-title">状态</h3>
                            </div>
                            <div class="panel-body demo-panel-debug">
                              <ul id="demo-debug">
                              </ul>
                            </div>
                        </div>

                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <h3 class="panel-title">进度</h3>
                          </div>
                          <div class="panel-body demo-panel-files" id='demo-files'>
                            <span class="demo-note">未选择任何文件</span>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
              </div>
              
              <!-- /.box-body -->
<!--              <div class="box-footer">
                <button type="button" class="btn btn-default btn-back pull-left">返回</button>
                <button type="button" class="btn btn-primary pull-right btn-submit">新增</button>
                <span class="label label-success pull-right hide">操作成功</span>
              </div>-->
            </form>
            
          </div>
    </div>
</div>