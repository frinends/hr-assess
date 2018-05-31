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
                <h3 class="box-title">添加考核模版</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="<?= Yii::$app->urlManager->createUrl(["performance/tpladd"])?>">
                <div class="box-body">
                    <div class="form-group">
                        <label >标题</label>
                        <input type="text" class="form-control" name="title" placeholder="模版标题">
                        <div class="help-block"></div>
                    </div>
                    <div class="form-group">
                        <label >类型</label>
                        <select class="form-control " name="type" tabindex="-1" aria-hidden="true">
                            <option value="">请选择类型</option>
                            <option value="1">分值型</option>
                            <option value="2">选择型</option>
                        </select>
                        <div class="help-block"></div>
                    </div>
                    <div >
                        
                        <div class="box-body">
                            <table class="table table-bordered">
                                <thead>
                                    <th>名称</th>
                                    <th>选项</th>
                                    <th>描述</th>
                                    <th style="width:100px;">分值</th>
                                    <th style="width:100px;" >排序</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    <tr id="tbody-0">
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="name[0]" placeholder="名称">
                                                <div class="help-block"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <div id="option-0">
                                                    <input type="text" class="form-control" name="option[0][]" placeholder="选项">
                                                </div>
                                                <div class="help-block"></div>
                                            </div>
                                            <button type="button" style="margin-top:5px;" onclick="addOption(0)" data-toggle="tooltip" title="添加选项" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button>
                                        </td>
                                        
                                        <td>
                                            <textarea class="form-control" name="meta[0]" rows="2" placeholder="描述"></textarea>
                                        </td>
                                        
                                        <td>
                                            <div class="form-group">
                                                <input type="number" class="form-control" name="score[0]" placeholder="分值">
                                                <div class="help-block"></div>
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <input type="number" data-toggle="tooltip" title="数值越大越靠后" class="form-control" name="weight[0]" placeholder="排序">
                                        </td>
                                        
                                        <td>
                                            <button type="button" remove-id="tbody-0" data-toggle="tooltip" title="移除" class="btn btn-danger btn-remove"><i class="fa fa-minus-circle"></i></button>
                                        </td>
                                    </tr>
                                                                       
                                </tbody>
                                
                                <tfoot>
                                <td colspan="5">
                                    <div class="form-group">
                                        <input type="hidden" name="msg">
                                        <div class="help-block"></div>
                                    </div>
                                </td>
                                    
                                    <td class="text-left">
                                        <button type="button" onclick="addGeoZone()" data-toggle="tooltip" data-original-title="添加考核模版选项" class="btn btn-primary" ><i class="fa fa-plus-circle"></i></button>
                                    </td>
                                </tfoot>
                            </table>
                        </div>
                        
                    </div>
                    
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
    function addGeoZone() {
        var html = '<tr id="tbody-'+k+'">\n\
                        <td>\n\
                            <div class="form-group">\n\
                                <input type="text" class="form-control" name="name['+k+']" placeholder="名称">\n\
                                <div class="help-block"></div>\n\
                            </div>\n\
                        </td>';
                                        
            html += '<td>\n\
                        <div class="form-group">\n\
                            <div id="option-'+k+'">\n\
                                <input type="text" class="form-control" name="option['+k+'][0]" placeholder="选项">\n\
                            </div>\n\
                            <div class="help-block"></div>\n\
                        </div>\n\
                        <button type="button" style="margin-top:5px;" onclick="addOption('+k+')" data-toggle="tooltip" title="添加选项" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button>\n\
                    </td>';
                                        
            html += '<td><textarea class="form-control" name="meta['+k+']" rows="2" placeholder="描述"></textarea></td>';

            html += '<td>\n\
                        <div class="form-group">\n\
                            <input type="number" class="form-control" name="score['+k+']" placeholder="分值">\n\
                            <div class="help-block"></div>\n\
                        </div>\n\
                    </td>';

            html += '<td><input type="number" data-toggle="tooltip" title="数值越大越靠后" class="form-control" name="weight['+k+']" placeholder="排序"></td>';

            html += '<td><button type="button" remove-id="tbody-'+k+'" data-toggle="tooltip" title="移除" class="btn btn-danger btn-remove"><i class="fa fa-minus-circle"></i></button></td>';
            html += '</tr>';
            
        $('.table tbody').append(html);
	k++;
    }
    
    function addOption(l){
        var html = '<input type="text" class="form-control" name="option[0][]" placeholder="选项">';
        
        $("#option-"+l).append(html);
    }
</script>