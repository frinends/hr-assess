<?php 
  $title = '修改密码';
?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1><?= $title?></h1>
</section>

<!-- Main content -->
<section class="content">
  <div class="databox">

    <div class="row">
      <div class="col-md-4">
       
     <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><?= $title?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="" method="post">
              <div class="box-body">
                <div class="form-group">
                  <label for="">旧密码</label>
                  <input type="text" class="form-control" name="old_pwd" id="old_pwd" placeholder="旧密码">
                  <div class="help-block">&nbsp;</div>
                </div>
                <div class="form-group">
                  <label for="">新密码</label>
                  <input type="text" class="form-control" name="new_pwd" id="new_pwd" placeholder="新密码">
                  <div class="help-block">&nbsp;</div>
                </div>
                <div class="form-group">
                  <label for="">确认新密码</label>
                  <input type="text" class="form-control" name="new_pwd_confirm" id="new_pwd_confirm" placeholder="确认新密码">
                  <div class="help-block">&nbsp;</div>
                </div>
                
              </div>
        
              <div class="box-footer">
                <button type="submit"  class="btn btn-submit btn-primary btn-block btn-flat">更改
                <span class="label label-success hide">操作成功</span>
                </button>
              </div>
            </form>
          </div>
        
    </div>

  </div>
</section>


