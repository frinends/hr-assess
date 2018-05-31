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
              <h3 class="box-title">添加员工</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="<?= Yii::$app->urlManager->createUrl(['employees/add'])?>">
              <div class="box-body">
                <div class="form-group">
                  <label >员工姓名</label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="员工姓名">
                  <div class="help-block"></div>
                </div>
                <div class="form-group">
                  <label >身份证号</label>
                  <input type="text" class="form-control" name="identity_card" id="identity_card" placeholder="身份证号">
                  <div class="help-block"></div>
                </div>
                <div class="form-group">
                  <label >员工编号</label>
                  <input type="text" class="form-control" name="employee_number" id="employee_number" placeholder="员工编号">
                  <div class="help-block"></div>
                </div>
                <div class="form-group">
                  <label >职位</label>
                  <input type="text" class="form-control" name="position" placeholder="职位">
                  <div class="help-block"></div>
                </div>
                <div class="form-group">
                  <label >单位名称</label>
                  <select class="form-control " name="unit" id="unit" tabindex="-1" aria-hidden="true">
                    <option value="">请选择单位</option>
                    <?php foreach ($unit_list as $v):?>
                    <option value="<?= $v["id"]?>"><?= $v["name"]?></option>
                    <?php endforeach;?>
                  </select>
                  <div class="help-block"></div>
                </div>
                <div class="form-group">
                  <label >部门名称</label>
                  <select class="form-control " name="department" id="department" tabindex="-1" aria-hidden="true">
                    <option value="">请选择部门</option>
                  </select>
                  <div class="help-block"></div>
                </div>
                
                <div class="form-group">
                  <label >职级</label>
                  <select class="form-control " name="rank" id="rank" tabindex="-1" aria-hidden="true">
                    <option value="">请选择职级</option>
                    <?php foreach ($rank_list as $v):?>
                    <option value="<?= $v["id"]?>" ><?= $v["name"]?></option>
                    <?php endforeach;?>
                  </select>
                  <div class="help-block"></div>
                </div>
                <div class="form-group">
                  <label >性别</label>
                    <div class="radio">
                      <label>
                        <input type="radio" name="sex" id="sex" checked value="1" >
                        男
                      </label>
                        <label></label>
                      <label>
                        <input type="radio" name="sex" id="sex" value="2" >
                        女
                      </label>
                    </div>
                </div>
                <div class="form-group">
                  <label >政治面貌</label>
                  <input type="text" class="form-control" name="politics_status" placeholder="政治面貌">
                </div>
                <div class="form-group">
                  <label >手机号</label>
                  <input type="text" class="form-control" name="mobile" id="mobile" placeholder="手机号">
                  <div class="help-block"></div>
                </div>
                <div class="form-group">
                  <label >邮箱</label>
                  <input type="email" class="form-control" name="email" id="email" placeholder="邮箱">
                  <div class="help-block"></div>
                </div>
                
              </div>
                <input type="hidden" id="department_url" value="<?= Yii::$app->urlManager->createUrl('ajaxapi/department')?>">
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="button" class="btn btn-default btn-back pull-left">返回</button>
                <button type="button" class="btn btn-primary pull-right btn-submit">添加</button>
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