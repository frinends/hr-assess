<?php
/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
$request = Yii::$app->request->get();

?>



<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">绩效考核未评分人员</h3>
             
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                <thead>
                                    <tr role="row" class="bg-light-blue">
                                        <th class=" text-center">序号</th>
                                        <th class=" text-center">评分人员</th>
                                        <th class=" text-center">被评分人员</th>
                                        <th class=" text-center">部门</th>
                                        <th class=" text-center">职级</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($model as $k => $v):?>
                                    <tr role="row" class="odd">
                                      <td><?= $k+1;?></td>
                                      <td><?= $employee->name?></td>
                                      <td><?= $v->name?></td>
                                      <td><?= $v->department->dep_name?></td>
                                      <td><?= $v->rank->rank_name?></td>
                                     
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?=$pages?>
                </div>
            </div>
        </div>
    </div>
</div>
