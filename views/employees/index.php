<?php
/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
$request = Yii::$app->request->get();

?>

<div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">筛选条件</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <!--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>-->
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="display: block;">
            <?php $form = ActiveForm::begin(['action' => ['employees/index'],'method'=>'get',]);?>
            
            <div class="row">
              <div class="col-md-3">
              <div class="form-group">
                <label>名字/员工编号</label>
                <input type="text" class="form-control" value="<?= isset($request["employees"]) ? $request["employees"] : ""?>" name="employees" placeholder="请输入员工名字/员工编号">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>单位</label>
                <select class="form-control " name="unit" id="unit" style="width: 100%;" tabindex="-1" aria-hidden="true">
                    <option value="">请选择单位</option>
                    <?php foreach ($unit_list as $v):?>
                    <option value="<?= $v["id"]?>" <?= isset($request["unit"]) && $request["unit"] == $v["id"] ? "selected" : "";?>><?= $v["name"]?></option>
                    <?php endforeach;?>
                </select>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-md-3">
              <div class="form-group">
                <label>部门</label>
                <select class="form-control "  style="width: 100%;" name="department" id="department" tabindex="-1" aria-hidden="true">
                  <option value="">请选择部门</option>
                  
                </select>
              </div>
              
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>职级</label>
                <select class="form-control " style="width: 100%;" name="rank" tabindex="-1" aria-hidden="true">
                  <option value="">请选择职级</option>
                    <?php foreach ($rank_list as $v):?>
                  <option value="<?= $v["id"]?>" <?= isset($request["rank"]) && $request["rank"] == $v["id"] ? "selected" : "";?>><?= $v["name"]?></option>
                    <?php endforeach;?>
                </select>
              </div>
            </div>
          </div>
          
          <input type="hidden" id="department_url" value="<?= Yii::$app->urlManager->createUrl('ajaxapi/department')?>">
          <div class="row">
            <div class="col-md-3">
                <button type="button"  class="btn btn-success btn-reset">清除条件</button>
                <button type="submit" class="btn btn-primary pull-right">筛选</button>
            </div>
          </div>
       <?php ActiveForm::end(); ?>
        </div>
        <!-- /.box-body -->
        
      </div>

<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">员工列表</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                <thead>
                                    <tr role="row" class="bg-light-blue">
                                        <th class="sorting text-center"  >姓名</th>
                                        <th class="sorting text-center"  >工号</th>
                                        <th class="sorting text-center"  >单位</th>
                                        <th class="sorting text-center"  >部门</th>
                                        <th class="sorting text-center"  >职级</th>
                                        <th class="sorting text-center"  >手机号</th>
                                        <th class="sorting text-center"  >邮箱</th>
                                        <th class="sorting text-center"  ></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($model as $v):?>
                                    <tr role="row" class="odd">
                                      <td><?= $v->name;?></td>
                                      <td><?= $v->employee_number;?></td>
                                      <td><?= $v->unit->unit_name;?></td>
                                      <td><?= $v->department->dep_name;?></td>
                                      <td><?= $v->rank->rank_name;?></td>
                                      <td><?= $v->mobile;?></td>
                                      <td><?= $v->email;?></td>
                                      <td><a href="<?= Yii::$app->urlManager->createUrl(['employees/info','id' => $v->employee_id])?>">详情</a></td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?= $pages?>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
<script>
var unit = <?= isset($request["unit"])&& !empty($request["unit"]) ? $request["unit"] : 0?>,department = <?= isset($request["department"])&& !empty($request["department"]) ? $request["department"] : 0?>;
</script>