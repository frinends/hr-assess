<?php
/* @var $this yii\web\View */
?>
<div class="row">
    <div class="col-xs-8">
        <form action="<?= Yii::$app->urlManager->createUrl('salary/changeweight')?>" method="post">
        <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">模版列表</h3>
              <div class="box-tools pull-right">
                  <button type="button" class="btn btn-success btn-submit">变更排序</button>
              </div>
            </div>
            <div class="box-body">
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                <thead>
                                    <tr role="row" class="bg-light-blue">
                                        <th class="text-center" >编号</th>
                                        <th class="text-center" >中文名称</th>
                                        <th class="text-center" >英文名称</th>
                                        <th class="text-center" >排序</th>
                                        <th class="text-center" >状态</th>
                                        <th class="text-center" ></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($list as $k => $v): ?>
                                    <tr role="row" class="odd">
                                      <td><?= $k+1;?></td>
                                      <td><?= $v->name;?></td>
                                      <td><?= $v->e_name?></td>
                                      <td class="form-group"><input type="number" name="weight[<?= $v->id?>]" value="<?= $v->weight?>" class="form-control"></td>
                                      <td><?= $v->status == 1 ? "正常":"停用";?></td>
                                      <td>
                                          
                                           <a class="btn-del" href="javascript:;" data-message="确认要停用【<?= $v->name;?>】吗？" data-link="<?= Yii::$app->urlManager->createUrl(['salary/handle','id'=>$v->id])?>"><?= $v->status == 1 ? "停用" : "启用"?></a>
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
        </form>
    </div>
    
    <div class="col-xs-4">
        <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">添加模版</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="<?= Yii::$app->urlManager->createUrl('salary/addmodel')?>" name="department">
                
              <div class="box-body">
                <div class="form-group">
                  <label >中文模版名称</label>
                  <input type="text" name="name" class="form-control"  placeholder="中文模版名称">
                  <div class="help-block"></div>
                </div>
              </div>
             <div class="box-body">
                <div class="form-group">
                    <label >英文模版名称  <small></small></label>
                  <input type="text" name="e_name" class="form-control" placeholder="英文模版名称">
                  <div class="help-block"></div>
                </div>
             </div>
             <div class="box-body">
                <div class="form-group">
                    <label >排序  <small></small></label>
                    <input type="number" name="weight" class="form-control" value="0" placeholder="排序">
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