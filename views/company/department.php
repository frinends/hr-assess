<?php
/* @var $this yii\web\View */
?>
<div class="row">
    <div class="col-xs-8">
        <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">部门列表</h3>
            </div>
            <div class="box-body">
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                <thead>
                                    <tr role="row" class="bg-light-blue">
                                        <th class="sorting text-center" >编号</th>
                                        <th class="sorting text-center" >单位名称</th>
                                        <th class="sorting text-center" >部门名称</th>
                                        <th class="sorting text-center" >当前状态</th>
                                        <th class="sorting text-center" ></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($list as $k => $v): ?>
                                    <tr role="row" class="odd">
                                      <td><?= $k+1;?></td>
                                      <td><?= $v->unit->unit_name;?></td>
                                      <td><?= $v->dep_name;?></td>
                                      <td><?= $v->dep_status == 1 ? "正常":"停用";?></td>
                                      <td>
                                          <a href="<?= Yii::$app->urlManager->createUrl(['company/department_detail','id'=>$v->dep_id])?>"> 详情 </a> 
                                          &nbsp;|&nbsp;
                                           <a class="btn-del" href="javascript:;" data-message="确认要操作【<?= $v->dep_name;?>】吗？" data-link="<?= Yii::$app->urlManager->createUrl(['company/department_del','id'=>$v->dep_id])?>"><?= $v->dep_status == 1 ? "停用" : "启用"?></a>
                                      </td>
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
    
    <div class="col-xs-4">
        <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">添加新部门</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="<?= Yii::$app->urlManager->createUrl('company/department_handle')?>" name="department">
                <div class="box-body">
                    <div class="form-group">
                        <label >单位</label>
                        <select class="form-control" name="unit_id">
                            <?php foreach ($units as $v):?>
                            <option value="<?= $v->unit_id?>"><?= $v->unit_name?></option>
                            <?php endforeach;?>
                        </select>
                        <div class="help-block"></div>
                    </div>
                </div>
              <div class="box-body">
                <div class="form-group">
                  <label >部门名称</label>
                  <input type="text" name="dep_name" class="form-control" id="" placeholder="部门名称">
                  <div class="help-block"></div>
                </div>
              </div>
              <input type="hidden" name="dep_status" value="1">
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-submit">提交</button>
                <span class="label label-success hide">操作成功</span>
              </div>
              
            </form>
            <div class="overlay hide">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
            
        </div>
        
    </div>
</div>