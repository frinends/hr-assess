<?php
/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
$request = Yii::$app->request->get();

?>

<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">绩效考核分数</h3>
                <div class="box-tools pull-right">
                     <a class="btn btn-success btn-del" href="javascript:;" data-message="确认要生成考核成绩吗？" data-link="<?= Yii::$app->urlManager->createUrl(['performance/gender_score', "id" => $id])?>">生成考核成绩</a>
                    <a class="btn btn-success" href="<?= Yii::$app->urlManager->createUrl(['performance/gender_excel', "id" => $id])?>" >导出EXCEL</a>
              
                </div>
            </div>

            <!-- /.box-header -->
            <div class="box-body">
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                <thead>
                                    <tr role="row" class="bg-light-blue">
                                        <th class="sorting text-center">序号</th>
                                        <th class="sorting text-center">人员</th>
                                        <th class="sorting text-center">部门</th>
                                        <th class="sorting text-center">职级</th>
                                        <th class="sorting text-center">分数详情</th>
                                        <th class="sorting text-center">总分</th>
                                     
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(empty($list)){
                                        echo '<tr role="row" class="odd"><td colspan=4>暂无员得分情况</td></tr>';
                                    }else{?>
                                    <?php foreach ($list as $k => $v):?>
                                    <tr role="row" class="odd">
                                      <td><?= $k+1;?></td>
                                      <!--<td><a href="<?= Yii::$app->urlManager->createUrl(['performance/scoreinfo',"id" => $v["employee_id"], "task_id" => $id])?>" ><?= $v["name"]?></a></td>-->
                                      <td><?= $v["name"]?></td>
                                      <td><?= $v["dep_name"]?></td>
                                      <td><?= $v["rank_name"]?></td>
                                      <td><?= $v["content"]?></td>
                                      <td><?= $v["score"]?></td>
                                    </tr>
                                    <?php endforeach;?>
                                    <?php }?>
                                </tbody>
                            </table>
                            <?= $pages?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
