<?php
/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
$request = Yii::$app->request->get();

?>



<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">设置考核权重</h3>
             
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <form role="form" method="post" action="<?= Yii::$app->urlManager->createUrl(["performance/set_weight", "id"=>$_GET["id"] ])?>">
                            <table id="rank-weight" class="table table-bordered table-hover dataTable" >
                                <thead>
                                    <tr role="row" class="bg-light-blue">
                                        <th class=" text-center">权重</th>
                                        <th class=" text-center">考核人职级</th>
                                        <th class=" text-center">选择考核人职级</th>
                                        <th class=" text-center"  ></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(empty($task_weight)):?>
                                    <tr role="row" >
                                        <td class=" text-center">
                                            <div class="form-group">
                                                <input type="number" placeholder="请填写权重" class="form-control" value="" name="weight[0]">
                                                <div class="help-block"></div>
                                            </div>
                                        </td>
                                        <td class=" text-center">请在右侧选择职级（可以多选）</td>
                                        <td class=" text-center">
                                            <select data-k="0" class="form-control select-rank">
                                                <option>请选择职级</option>
                                                <?php foreach ($ranks as $rank):?>
                                                <option value="<?= $rank["id"]?>"><?= $rank["name"]?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </td>
                                        <td class=" text-center">
                                            <button type="button" data-toggle="tooltip" onclick="$(this).parents('tr').remove();" title="移除" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
                                        </td>
                                    </tr>
                                    <?php else:?>
                                    <?php foreach ($task_weight as $k => $v):?>
                                    <tr role="row" >
                                        <td class=" text-center">
                                            <div class="form-group">
                                                <input type="number" placeholder="请填写权重" class="form-control" value="<?= $v["weight"]?>" name="weight[<?= $k?>]">
                                                <div class="help-block"></div>
                                            </div>
                                        </td>
                                        <td class=" text-center">
                                            <?php foreach ($v["ranks"] as $r):?>
                                            <span class="pull-right-container rank_ddel" style="margin-left:3px;cursor: pointer;">
                                                <input type="hidden" value="<?= $r->rank_id?>" name="rank[<?= $k?>][]">
                                                <small class="label bg-green"><?= $r->rank_name?></small>
                                            </span>
                                            <?php endforeach;?>
                                            <?php if($v["is_other"] == 1):?>
                                            <span class="pull-right-container rank_ddel" style="margin-left:3px;cursor: pointer;">
                                                <input type="hidden" value="0" name="rank[<?= $k?>][]">
                                                <small class="label bg-green">指定人员</small>
                                            </span>
                                            <?php endif;?>
                                        </td>
                                        <td class=" text-center">
                                            <select data-k="<?= $k?>" class="form-control select-rank">
                                                <option>请选择职级</option>
                                                <?php foreach ($ranks as $rank):?>
                                                <option value="<?= $rank["id"]?>"><?= $rank["name"]?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </td>
                                        <td class=" text-center">
                                            <button type="button" data-toggle="tooltip" onclick="$(this).parents('tr').remove();" title="移除" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                    <?php endif;?>
                                </tbody>
                                <tfoot>
                                    <td colspan="3">
                                            <div class="form-group">
                                                <input type="hidden" class="form-control"  name="see_error">
                                                <div class="help-block"></div>
                                            </div>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" data-toggle="tooltip" data-original-title="添加权重" class="btn btn-primary add_weight_rank" ><i class="fa fa-plus-circle"></i></button>
                                    </td>
                                </tfoot>
                            </table>
                            
                            <div class="box-footer">
                                <button type="button" class="btn btn-default btn-back pull-left">返回</button>
                                <button type="button" class="btn btn-primary pull-right btn-submit">设置</button>
                            </div>
                            </form>
                        </div>
                    </div>
                  
                </div>
            </div>
        </div>
    </div>
</div>
<div class="hide rank-weight-hide">
    <table  >
                               
        <tbody>
            <tr role="row" >
                <td class=" text-center"><div class="form-group">
                                                <input type="number" placeholder="请填写权重" class="form-control" value="" name="weight[ran_num]">
                                                <div class="help-block"></div>
                                            </div>
                    
                </td>
                <td class=" text-center">请在右侧选择职级（可以多选）</td>
                <td class=" text-center">
                    <select data-k="ran_num" class="form-control select-rank">
                        <option>请选择职级</option>
                        <?php foreach ($ranks as $rank):?>
                        <option value="<?= $rank["id"]?>"><?= $rank["name"]?></option>
                        <?php endforeach;?>
                    </select>
                </td>
                <td class=" text-center">
                    <button type="button" data-toggle="tooltip" onclick="$(this).parents('tr').remove();" title="移除" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
                </td>
            </tr>
        </tbody>

    </table>
</div>
