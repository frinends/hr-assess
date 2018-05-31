<?php
/* @var $this yii\web\View */
?>
<div class="row">
    <div class="col-xs-8">
        <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">职级列表</h3>
            </div>
            <div class="box-body">
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                <thead>
                                    <tr role="row" class="bg-light-blue">
                                        <th class="sorting text-center" >编号</th>
                                        <th class="sorting text-center" >职级名称</th>
                                        <th class="sorting text-center" >当前状态</th>
                                        <th class="sorting text-center" ></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($list as $k => $v): ?>
                                    <tr role="row" class="odd">
                                      <td><?= $k+1;?></td>
                                      <td><?= $v->rank_name;?></td>
                                      <td><?= $v->rank_status == 1 ? "正常":"停用";?></td>
                                      <td>
                                          <a href="<?= Yii::$app->urlManager->createUrl(['company/rank_detail','id'=>$v->rank_id])?>"> 详情 </a> 
                                          &nbsp;|&nbsp;
                                           <a class="btn-del" href="javascript:;" data-message="确认要操作【<?= $v->rank_name;?>】吗？" data-link="<?= Yii::$app->urlManager->createUrl(['company/rank_del','id'=>$v->rank_id])?>"><?= $v->rank_status == 1 ? "停用" : "启用"?></a>
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
              <h3 class="box-title">添加新职级</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="<?= Yii::$app->urlManager->createUrl('company/rank_handle')?>" name="department">
                
              <div class="box-body">
                <div class="form-group">
                  <label >职级名称</label>
                  <input type="text" name="rank_name" class="form-control" id="" placeholder="职级名称">
                  <div class="help-block"></div>
                </div>
              </div>
              <input type="hidden" name="rank_status" value="1">
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