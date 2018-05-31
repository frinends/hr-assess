<?php
/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
?>



<div class="row">
    <div class="col-xs-10">
        <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">考核对象</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered table-hover dataTable" >
                                <thead>
                                    <tr role="row" class="bg-light-blue">
                                        <th class="sorting text-center">编号</th>
                                        <th class="sorting text-center">考核对象</th>
                                        <th class="sorting text-center">操作</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                    <?php foreach ($list as $k => $v):?>
                                    <tr role="row" class="odd">
                                      <td><?= $k+1;?></td>
                                      <td><?= $v["name"];?></td>
                                      <td><a href="<?= Yii::$app->urlManager->createUrl(["ptask/score", "id" => $v["id"], "type"=>$v["type"]])?>"><?= $v["text"]?></a></td>
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