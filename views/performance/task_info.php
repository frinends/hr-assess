<?php
/* @var $this yii\web\View */
?>
<div class="row">

    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-header with-border">
                <button type="button" title="返回" class="close btn-back" >
                    <span aria-hidden="true">×</span>
                </button>
                <h3 class="box-title">考核任务详情</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
                <div class="box-body">
                    <div class="form-group">
                        <label >考核名称：<?= $model->task_title ?></label>
                        <span class="pull-right"></span>
                    </div>
                    
                    <div class="form-group">
                        <label >考核时间：<?= $model->start_time . " — " . $model->end_time; ?></label>
                        <span class="pull-right"></span>
                    </div>
                    <?php foreach ($taskOption as $k => $v):?>
                    <div class="">
                        <h4 >被考核人：<?= $v["name"]?></h4>
                        <div class="box-body">
                            <table class="table table-bordered ">
                                    <thead class="bg-light-blue color-palette" >
                                        <th style="width: 30%">考核人</th>
<!--                                        <th style="width: 20%">权重</th>-->
                                        <th style="width: 50%">模版</th>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($v["option"] as $option):?>
                                        <tr>
                                            <td>
                                                <?= $option["examine_people"]?>
                                            </td>
<!--                                            <td>
                                                <?= $option["weight"]?>
                                            </td>-->
                                            <td>
                                                <?= $option["model_name"]?>
                                            </td>
                                        </tr>
                                        <?php endforeach;?>
                                    </tbody>
                            </table>
                        </div>
                    </div>
                    <?php endforeach;?>
                </div>
                <div class="box-footer">
                   <button type="button" class="btn btn-primary pull-left btn-people">添加指定人员</button>
                    <button type="button" class="btn btn-primary pull-right btn-back">返回</button>
                    <span class="label label-success pull-right hide">操作成功</span>
                </div>
        </div>
    </div>
</div>

<div id="modal-image" class="modal in" style="display: none;">
    <div id="filemanager" class="modal-dialog modal-lg">
        <div class="modal-content" >
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title">添加特殊考核人员</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="department_url" value="<?= Yii::$app->urlManager->createUrl('ajaxapi/department')?>">
                <input type="hidden" id="id" value="<?= $model->task_id?>">
                <div class="row" >
                    <div class="col-sm-12">
                      <label>&nbsp;考&nbsp;&nbsp;核&nbsp;&nbsp;人：</label>
                      <select  name="unit" id="unit" tabindex="-1" aria-hidden="true">
                        <option value="">请选择单位</option>
                        <?php foreach ($unit_list as $v):?>
                        <option value="<?= $v["id"]?>"><?= $v["name"]?></option>
                        <?php endforeach;?>
                      </select>
                      &nbsp;&nbsp;
                      <select  name="department" id="department" tabindex="-1" aria-hidden="true">
                        <option value="">请选择部门</option>
                      </select>
                      &nbsp;&nbsp;
                      <select name="rank" id="rank" tabindex="-1" aria-hidden="true">
                        <option value="">请选择职级</option>
                        <?php foreach ($rank_list as $v):?>
                        <option value="<?= $v["id"]?>" ><?= $v["name"]?></option>
                        <?php endforeach;?>
                      </select>
                      &nbsp;&nbsp;
                      <select id="people">
                          <option value="">请选择考核人员</option>
                      </select>
                    </div>
                    <div class="col-sm-12">
                        <label >人&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;员：</label>
                        <ul id="people_show">
                        </ul>
                    </div>
                </div>
                <div class="row" >
                  <div class="col-sm-12">
                    <label >被考核人：</label>
                    <select  name="unit" id="unit1" tabindex="-1" aria-hidden="true">
                      <option value="">请选择单位</option>
                      <?php foreach ($unit_list as $v):?>
                      <option value="<?= $v["id"]?>"><?= $v["name"]?></option>
                      <?php endforeach;?>
                    </select>
                    &nbsp;&nbsp;
                    <select  name="department" id="department1" tabindex="-1" aria-hidden="true">
                      <option value="">请选择部门</option>
                    </select>
                    &nbsp;&nbsp;
                    <select name="rank" id="rank1" tabindex="-1" aria-hidden="true">
                      <option value="">请选择职级</option>
                      <?php foreach ($rank_list as $v):?>
                      <option value="<?= $v["id"]?>" ><?= $v["name"]?></option>
                      <?php endforeach;?>
                    </select>
                    &nbsp;&nbsp;
                    <select id="people1">
                        <option value="">请选择考核人员</option>
                    </select>
                  </div>
                  <div class="col-sm-12">
                      <label >人&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;员：</label>
                      <ul id="people_show1">
                      </ul>
                  </div>
                </div>
                <div >
                    <div class="col-sm-12">
                        <label>权&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;重：</label>
                        <select id="task_model">
                            <option value="0">请选择考核模版</option>
                            <?php foreach ($model_list as $model ):?>
                            <option value="<?= $model->model_id?>"><?= $model->title?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
<!--                <div >
                    <div class="col-sm-12">
                        <label>权&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;重：</label>
                        <input type="number" class="form-group-sm weight"  value="" placeholder="权重" >
                    </div>
                </div>-->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary add-other">确定</button>
            </div>
  </div>
</div>
</div>
