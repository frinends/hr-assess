<?php
/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
$parames = Yii::$app->request->get();
?>

<div class="box box-info  ">
        <div class="box-header with-border">
          <h3 class="box-title">筛选条件</h3>

          
        </div>
        <!-- /.box-header -->
        <div class="box-body" >
            <?php $form = ActiveForm::begin(['action' => ['salary/index'],'method'=>'get',]);?>
            
            <div class="row">
              <div class="col-md-3">
              <div class="form-group">
                <label>名字/员工编号</label>
                <input type="text" class="form-control" value="<?= isset($parames["employees"]) ? $parames["employees"] :""?>" name="employees" placeholder="请输入员工名字/员工编号">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>单位</label>
                <select class="form-control " name="unit" id="unit" style="width: 100%;" tabindex="-1" aria-hidden="true">
                    <option value="">请选择单位</option>
                    <?php foreach ($unit_list as $v):?>
                    <option value="<?= $v["id"]?>" <?= isset($parames["unit"]) && $parames["unit"]==$v["id"]?"selected":"" ?>><?= $v["name"]?></option>
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
                    <option value="<?= $v["id"]?>" <?= isset($parames["rank"]) && $parames["rank"]==$v["id"]?"selected":"" ?>><?= $v["name"]?></option>
                    <?php endforeach;?>
                </select>
              </div>
            </div>
          </div>
          
          <input type="hidden" id="department_url" value="<?= Yii::$app->urlManager->createUrl('ajaxapi/department')?>">
          <div class="row">
              <div class="col-md-3">
              <div class="form-group">
                <label>年份</label>
                <select class="form-control " name="year" style="width: 100%;" tabindex="-1" aria-hidden="true">
                    <option value="">请选择年份</option>
                    <?php for ($i = date("Y"); $i > 2012;$i--):?>
                    <option value="<?= $i?>" <?= isset($parames["year"]) && $parames["year"]==$i?"selected":"" ?> ><?= $i?></option>
                    <?php endfor;?>
                  </select>
              </div>
            </div>
              <div class="col-md-3">
              <div class="form-group">
                <label>月份</label>
                <select class="form-control " name="month" style="width: 100%;" tabindex="-1" aria-hidden="true">
                    <option value="">请选择年份</option>
                    <?php for ($i = 1; $i < 13;$i++):?>
                    <option value="<?= $i?>" <?= isset($parames["month"]) && $parames["month"]==$i?"selected":"" ?>><?= $i?></option>
                    <?php endfor;?>
                  </select>
              </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label></label>
                    <div>
                        <button type="button" class="btn  btn-success btn-reset" >清除条件</button>
                        <button type="submit" class="btn btn-primary pull-right">筛选</button>
                    </div>
                </div>
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
              <h3 class="box-title">工资列表</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
               
                    <div class="row">
                        <div class="col-sm-12" style="overflow: auto">
                            <table class="table table-bordered table-hover dataTable" >
                                <thead>
                                    <tr role="row" >
                                        <?php if(Yii::$app->user->getIdentity()->role == "admin"):?>
                                    <th class="sorting bg-light-blue" >操作</th>
                                    <?php endif;?>
                                    <?php foreach ($names as $name):?>
                                    <th class="sorting bg-light-blue" ><?= $name;?></th>
                                    <?php endforeach;?>
                                    
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(empty($model)):?>
                                    <tr role="row" >
                                        <td colspan="<?= count($names)?>">暂无数据</td>
                                    </tr>
                                    <?php else:?>
                                    <?php foreach ($model as $v):?>
                                   
                                    <tr role="row" >
                                        <?php if(Yii::$app->user->getIdentity()->role == "admin"):?>
                                        <th style="min-width: 70px;" >
                                            <button type="button" class="btn btn-danger btn-del" data-message="确认要删除本条工资记录吗？" data-link="<?= Yii::$app->urlManager->createUrl(['salary/del', 'id'=>$v->id])?>">删除</button>
                                        </th>
                                    <?php endif;?>
                                    <?php foreach ($names as $k => $name):?>
                                        <?php if($k=="department"):?>
                                        <th style="min-width: 110px;"><?= $v->employee->department->dep_name?></th>
                                        <?php else:?>
                                        <th style="min-width: 70px;"><?= $v[$k]?></th>
                                        <?php endif;?>
                                    <?php endforeach;?>
                                        
                                    </tr>
                                    <?php endforeach;?>
                                    <?php endif;?>
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
var department = <?= isset($parames["department"]) ? $parames["department"] : 0 ?>,unit = <?= isset($parames["unit"]) ? $parames["unit"] : 0 ?>
</script>