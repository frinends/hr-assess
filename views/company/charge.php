<?php
/* @var $this yii\web\View */
?>
<div class="row">
    <div class="col-xs-8">
        <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">分管关系</h3>
            </div>
            <div class="box-body">
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                <thead>
                                    <tr role="row" class="bg-light-blue">
                                        <th class="sorting text-center" >编号</th>
                                        <th class="sorting text-center" >管理人</th>
                                        <th class="sorting text-center" >部门</th>
                                        <th class="sorting text-center" ></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($list as $k => $v): ?>
                                    <tr role="row" class="odd">
                                      <td><?= $k+1;?></td>
                                      <td><?= $v->employee->name;?></td>
                                      <td><?= $v->department->dep_name ?></td>
                                      <td>
                                        <a class="btn-del" href="javascript:;" data-message="确认要删除吗？" data-link="<?= Yii::$app->urlManager->createUrl(['company/charge_del','id'=>$v->charge_id])?>">删除</a>
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
              <h3 class="box-title">添加分管关系</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="<?= Yii::$app->urlManager->createUrl('company/charge_add')?>" name="department">
                
              <div class="box-body">
                  <div class="form-group">
                  <label >管理人</label>
                  <input type="text" name="manage_people" class="form-control" placeholder="请输入管理人名称或工号">
                  <div class="help-block"></div>
                </div>
                <div class="form-group">
                  <label >部门</label>
                  <select name="dep" class="form-control">
                      <option value="">请选择部门</option>
                      <?php foreach ($dep_list as $dep):?>
                      <option value="<?= $dep["dep_id"]?>"><?= $dep["dep_name"]?></option>
                      <?php endforeach;?>
                  </select>
                  <div class="help-block"></div>
                </div>
              </div>
            
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