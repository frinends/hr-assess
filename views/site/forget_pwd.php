<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = '忘记密码';

?>
<div class="login-box">


    <div class="login-box-body">
        
            <div class="text-center">
                <h4 class="bold">忘记密码</h4>
            </div>
            <form id="login-form" action="" method="post" role="form">
            <div class="form-group">
                <input type="hidden" name="error_msg" >
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="employee_number" placeholder="员工编号">
                <p class="help-block"></p>
            </div>
                
            <div class="form-group">
                <input type="text" class="form-control" name="identity_card" id="identity_card" placeholder="身份证号">
                <p class="help-block"></p>
            </div>
            
            <div class="form-group">
                <input type="email" class="form-control" name="email" id="email" placeholder="邮箱">
                <p class="help-block"></p>
            </div>
            
            <div class="form-group">
                <input type="text" class="form-control" name="mobile" id="mobile" placeholder="手机号">
                <p class="help-block"></p>
            </div>
                
           
                
            <div class="row">
                <div class="col-xs-8">
                    <a href="/" class="btn btn-default btn-back ">返回</a>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="button" class="btn btn-primary btn-block btn-flat btn-submit" name="login-button">确认</button>            
                </div>
                <!-- /.col -->
            </div>

        </form>
    </div>
</div>

<!--    <div class="col-xs-12">
        <div class="login-logo">
            <a href="javascript:;"><img style="max-width: 360px;" src="/img/logo.png"</a>
        </div>
        <div class="box box-primary ">
            <form role="form" method="post" action="">
                <div class="box-header">
                    <h3 class="box-title">忘记密码</h3>
                    <div class="form-group">
                        <input type="hidden" class="form-control" name="error_msg">
                        <div class="help-block"></div>
                    </div>
                </div>
             /.box-header 
                <div class="box-body ">
                    <div class="form-group">
                      <label>员工编号</label>
                      <input type="text" class="form-control" name="employee_number" id="employee_number" placeholder="员工编号">
                      <div class="help-block"></div>
                    </div>
                  
                    <div class="form-group">
                      <label >身份证号</label>
                      <input type="text" class="form-control" name="identity_card" id="identity_card" placeholder="身份证号">
                      <div class="help-block"></div>
                    </div>
                    <div class="form-group">
                      <label >邮箱</label>
                      <input type="email" class="form-control" name="email" id="email" placeholder="邮箱">
                      <div class="help-block"></div>
                    </div>
                  
                    <div class="form-group">
                      <label >手机号</label>
                      <input type="text" class="form-control" name="mobile" id="mobile" placeholder="手机号">
                      <div class="help-block"></div>
                    </div>
                </div>
                
               /.box-body 
                <div class="box-footer">
                    <button type="button" onclick="history.go(-1)" class="btn btn-default btn-back ">返回</button>
                    <button type="button" class="btn btn-primary  btn-submit">提交</button>
                </div>
            </form>
        </div>
    </div>-->