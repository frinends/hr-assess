<?php
/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
$request = Yii::$app->request->get();

?>


<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">不了解人员</h3>
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
                                        <th class="sorting text-center"  >单位</th>
                                        <th class="sorting text-center"  >部门</th>
                                        
                                        <th class="sorting text-center"  ></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($employees as $v):?>
                                    <tr role="row" class="odd">
                                      <td><?= $v->name;?></td>
                                      
                                      <td><?= $v->unit->unit_name;?></td>
                                      <td><?= $v->department->dep_name;?></td>
                                      
                                      <td><a href="javascript:;" data-link="<?= Yii::$app->urlManager->createUrl(["ptask/unshield",["employee_id"=>$v->employee_id,"task_id"=>$task_id]])?>" class="shield">找回</a></td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                   
                    
                </div>
            </div>
        </div>
    </div>
</div>
<script>
var unit = <?= isset($request["unit"])&& !empty($request["unit"]) ? $request["unit"] : 0?>,department = <?= isset($request["department"])&& !empty($request["department"]) ? $request["department"] : 0?>;
</script>