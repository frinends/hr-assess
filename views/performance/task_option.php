<?php
/* @var $this yii\web\View */
?>
<div class="row">

    <div class="col-xs-8">
        <div class="box box-success">
            <div class="box-header with-border">
                <button type="button" title="返回" class="close btn-back" >
                    <span aria-hidden="true">×</span>
                </button>
                <h3 class="box-title">考核模版详情</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="<?= Yii::$app->urlManager->createUrl(["performance/settaskoption", "id"=>$model->task_id, "ranks"=> $ranks ])?>">
                <div class="box-body">
                    <div class="form-group">
                        <label >考核名称：<?= $model->task_title ?></label>
                        <span class="pull-right"></span>
                    </div>
                    <input type="hidden" name="id" value="<?= $model->task_id?>">
                    <div class="form-group">
                        <label >考核时间：<?= $model->start_time . " — " . $model->end_time; ?></label>
                        <span class="pull-right"></span>
                    </div>
                    <?php foreach ($rank_list_examine as $k => $v):?>
                    <div class="">
                        <h4 >被考核人：<?= $v["name"]?></h4>
                        <div class="box-body">
                            <table class="table table-bordered table-<?= $v["id"]?>">
                                
                                    <thead class="bg-light-blue color-palette" >
                                        <th>考核人</th>
                                        <!--<th>权重</th>-->
                                        <th>模版</th>
                                        <th></th>
                                    </thead>
                                    <tbody>
                                        <tr id="tbody-<?= $v["id"]?>0">
                                            <td>
                                                <select class="form-control" name="rank[<?= $v["id"]?>][]" id="rank" >
                                                    <?php foreach ($rank_list as $rank):?>
                                                    <option value="<?= $rank['id']?>" ><?= $rank["name"]?>_所有</option>
                                                    <option value="<?= $rank['id']?>_1" ><?= $rank["name"]?>_本部门</option>
                                                    <?php endforeach;?>
                                                   
                                                </select>
                                            </td>
                                            <input type="hidden" name="users[<?= $v["id"]?>][]" value="">
<!--                                            <td>
                                                <input type="number" class="form-control" name="weight[<?= $v["id"]?>][]" placeholder="权重">
                                            </td>-->
                                            <td>
                                                <select class="form-control" name="task_model[<?= $v["id"]?>][]" id="rank" >
                                                    <?php foreach ($model_list as $model):?>
                                                    <option value="<?= $model['model_id']?>" ><?= $model["title"]?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </td>
                                            <td>
                                                <button type="button" remove-id="tbody-<?= $v["id"]?>0" data-toggle="tooltip" title="移除" class="btn btn-danger btn-remove"><i class="fa fa-minus-circle"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <td>
                                            <div class="form-group">
                                                <input type="hidden" value="" name="rank_error[<?= $v["id"]?>][]">
                                                <div class="help-block"></div>
                                                </div>
                                        </td>
<!--                                        <td>
                                            <div class="form-group">
                                            <input type="hidden" value="" name="weight_error[<?= $v["id"]?>][]">
                                            <div class="help-block"></div>
                                            </div>
                                        </td>-->
                                        <td></td>
                                        <td class="text-left">
                                            <button type="button" onclick="addGeoZone(<?= $v["id"]?>)" table-class="table-<?= $v["id"]?>" data-toggle="tooltip" data-original-title="添加被考核人" class="btn btn-primary" ><i class="fa fa-plus-circle"></i></button>
                                        </td>
                                    </tfoot>
                                         
                            </table>
                        </div>
                    </div>
                    <?php endforeach;?>
                </div>
                
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="button" class="btn btn-default btn-back pull-left">返回</button>
                    <button type="button" class="btn btn-primary pull-right btn-submit">添加</button>
                    <span class="label label-success pull-right hide">操作成功</span>
                </div>
            </form>
            <div class="overlay hide">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </div>
</div>
<script>
    
var k = 1;
function addGeoZone(id) {
        var html = "";
	html += '<tr id="tbody-'+id+k+'">';
        html +='    <td>';
        html +='        <select class="form-control" name="rank['+id+'][]" id="rank" >';
        html +='            <?php foreach ($rank_list as $v):?>';
        html +='            <option value="<?= $v['id']?>" ><?= $v["name"]?>_所有</option>';
        html +='            <option value="<?= $v['id']?>_1" ><?= $v["name"]?>_本部门</option>';
        html +='            <?php endforeach;?>';
        html +='        </select>';
        html +='    </td>';
//        html +='    <td>';
//        html +='        <input type="number" class="form-control" name="weight['+id+'][]" placeholder="权重">';
//        html +='    </td>';
        html +='    <td>';
        html +='        <select class="form-control" name="task_model['+id+'][]" id="rank" >';
        html +='            <?php foreach ($model_list as $v):?>';
        html +='            <option value="<?= $v['model_id']?>" ><?= $v["title"]?></option>';
        html +='            <?php endforeach;?>';
        html +='        </select>';
        html +='    </td>';
        html +='    <td>';
        html +='        <button type="button" remove-id="tbody-'+id+k+'" data-toggle="tooltip" title="移除" class="btn btn-danger btn-remove"><i class="fa fa-minus-circle"></i></button>';
        html +='    </td>';
        html +='</tr>';
	
	$('.table-'+id+' tbody').append(html);
	k++;
}


</script>