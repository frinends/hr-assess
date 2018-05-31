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
              <h3 class="box-title">员工详情</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="<?= Yii::$app->urlManager->createUrl(['employees/info','id' => $model->employee_id])?>">
              <div class="box-body">
                <div class="form-group">
                  <label >员工姓名</label>
                  <input type="text" class="form-control " value="<?= $model->name?>" name="name">
                
                  
                </div>
                <div class="form-group">
                  <label >身份证号</label>
                  <input type="text" class="form-control " value="<?= $model->identity_card?>" maxlength="18" name="identity_card">
                
                </div>
                <div class="form-group">
                  <label >员工编号</label>
                  <input type="text" class="form-control " value="<?= $model->employee_number?>" name="employee_number">
              
                </div>
                <div class="form-group">
                  <label >职位</label>
                  <input type="text" class="form-control " value="<?= $model->position?>" name="position">
                </div>
                <div class="form-group">
                  <label >单位名称</label>
                  <select class="form-control " name="unit" id="unit" tabindex="-1" aria-hidden="true">
                    <option value="">请选择单位</option>
                    <?php foreach ($unit_list as $v):?>
                    <option value="<?= $v["id"]?>" <?= $v["id"]==$model->unit_id ? "selected" : ""?>><?= $v["name"]?></option>
                    <?php endforeach;?>
                  </select>
                </div>
                <div class="form-group">
                  <label >部门名称</label>
                  <select class="form-control " name="department" id="department" tabindex="-1" aria-hidden="true">
                    <option value="">请选择部门</option>
                    <?php foreach ($department_list as $v):?>
                    <option value="<?= $v["id"]?>" <?= $v["id"]==$model->dep_id ? "selected" : ""?>><?= $v["name"]?></option>
                    <?php endforeach;?>
                  </select>
                </div>
                
                <div class="form-group">
                  <label >职级</label>
                  <select class="form-control " name="rank" id="rank" tabindex="-1" aria-hidden="true">
                    <option value="">请选择职级</option>
                    <?php foreach ($rank_list as $v):?>
                    <option value="<?= $v["id"]?>" <?= $v["id"]==$model->rank_id ? "selected" : ""?>><?= $v["name"]?></option>
                    <?php endforeach;?>
                  </select>
                </div>
                <div class="form-group">
                  <label >性别</label>
                  <select class="form-control " name="sex" tabindex="-1" aria-hidden="true">
                    <option value="">请选择性别</option>
                    <option value="1" <?= 1==$model->sex ? "selected" : ""?>>男</option>
                    <option value="2" <?= 2==$model->sex ? "selected" : ""?>>女</option>
                  </select>
                  
                </div>
                <div class="form-group">
                  <label >政治面貌</label>
                  <input type="text" class="form-control " value="<?= $model->politics_status?>" name="politics_status">
                 
                </div>
                <div class="form-group">
                  <label >手机号</label>
                  <input type="text" class="form-control " maxlength="11" value="<?= $model->mobile?>" name="mobile">
                 
                </div>
                <div class="form-group">
                  <label >邮箱</label>
                  <input type="text" class="form-control " value="<?= $model->email?>" name="email">
                
                </div>
                  
                <div class="form-group">
                  <label >状态</label>
                  <select class="form-control " name="is_work" tabindex="-1" aria-hidden="true">
                    <option value="0" <?= $model->is_work == 0 ? "selected" : "";?>>在职</option>
                    <option value="1" <?= $model->is_work == 1 ? "selected" : "";?>>离职</option>
                  </select>
                </div>
                  
                <div class="form-group">
                  <label >是否初始化密码</label>
                  <select class="form-control " name="pwd_initialize" id="pwd_initialize" tabindex="-1" aria-hidden="true">
                    <option value="">否</option>
                    <option value="1">是</option>
                  </select>
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
                <!--<span style="position: absolute;top: 70%;left: 45%;margin-left: -15px;margin-top: -15px;color: #000;">提交中……</span>-->
            </div>
          </div>
    </div>
</div>