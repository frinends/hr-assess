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
                  <span class="pull-right"><?= $model->name?></span>
                  
                </div>
                <div class="form-group">
                  <label >身份证号</label>
                  <span class="pull-right"><?= $model->identity_card?></span>
                </div>
                <div class="form-group">
                  <label >员工编号</label>
                  <span class="pull-right"><?= $model->employee_number?></span>
                </div>
                <div class="form-group">
                  <label >职位</label>
                  <span class="pull-right"><?= $model->position?></span>
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
                  <span class="pull-right"><?= $model->sex == 1 ? "男" : "女"?></span>
                </div>
                <div class="form-group">
                  <label >政治面貌</label>
                  <span class="pull-right"><?= $model->politics_status?></span>
                </div>
                <div class="form-group">
                  <label >手机号</label>
                  <span class="pull-right"><?= $model->mobile?></span>
                </div>
                <div class="form-group">
                  <label >邮箱</label>
                  <span class="pull-right"><?= $model->email?></span>
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