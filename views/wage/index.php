<?php
/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
$request = Yii::$app->request->get();

?>

<div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">日期</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="display: block;">
            <?php $form = ActiveForm::begin(['action' => ['wage/index'], 'method'=>'get',]);?>
            
            <div class="row">
                
                <div class="col-md-1">
                    <div class="form-group">
                        <label>年</label>
                        <select name="year" class="form-control ">
                            <?php for($i = date("Y"); $i > 2011; $i--):?>
                            <option value="<?= $i?>" <?= isset($_GET["year"]) && $_GET["year"]== $i ?"selected" : ""?>><?= $i?></option>
                            <?php endfor;?>
                        </select>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <label>月</label>
                        <select name="month"  class="form-control ">
                            <?php for($i = 1; $i < 13; $i++):?>
                            <option value="<?= $i?>" <?= (isset($_GET["month"]) && $_GET["month"]==$i) || date("m")-1 ==$i ?"selected" : ""?>><?= $i?></option>
                            <?php endfor;?>
                        </select>
                    </div>
                </div>
                    
                <div class="col-md-1">
                    <div class="form-group">
                        <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                      <button type="submit" class="btn btn-primary">查询</button>
                    </div>
                </div>
            </div>
            
       <?php ActiveForm::end(); ?>
        </div>
    
        
      </div>

<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">工资详情</h3>
                <a href="javascript:;" class="btn btn-warning btn-s-h" data-toggle="tooltip" data-original-title="竖排">
                        <i class="fa fa-bars"></i>
                </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div >
                    <?php $num = count($list);?>
                    <div class="row">
                        <div class="col-sm-12" style="overflow: auto">
                            <table class="table table-bordered table-hover dataTable h-show" >
                                <thead>
                                    <tr role="row" >
                                    <?php foreach ($names as $name):?>
                                    <th class="sorting bg-light-blue" ><?= $name;?></th>
                                    <?php endforeach;?>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <?php  if(!empty($list)):?>
                                    <?php foreach ($list as $v):?>
                                    <tr role="row" >
                                        
                                    <?php foreach ($names as $k => $name):?>
                                        <?php if($k=="department"):?>
                                        <th style="min-width: 110px;"><?= $v->department?></th>
                                        <?php else:?>
                                        <th style="min-width: 70px;"><?=$v->$k?$v->$k:"-"?></th>
                                        <?php endif;?>
                                    <?php endforeach;?>
                                    </tr>
                                    <?php endforeach;?>
                                    <?php endif;?>
                                </tbody>
                            </table>
                            
                            <table class="table table-bordered table-hover s-show hide" >
                                <thead>
                                    <tr role="row" >
                                        <th class="sorting bg-light-blue" style="width: 240px;">项目</th>
                                        <th class="sorting bg-light-blue" colspan="<?= $num?>">金额</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($list)):?>
                                    
                                    <?php foreach ($names as $k => $name):?>
                                    <tr>
                                        <td class="bg-gray" ><?= $name;?></td>
                                        <?php for ($i = 0; $i < $num; $i++):?>
                                        <td class=""><?= $list[$i][$k]?$list[$i][$k]:"-"?></td>
                                        <?php endfor;?>
                                    </tr>
                              
                                    <?php endforeach;?>
                                    <?php else:?>
                                    <tr>
                                        <td class="bg-gray" colspan="2">暂无记录</td>
                                    </tr>
                                    <?php endif;?>
                                    
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                 
                </div>
            </div>
        </div>
    </div>
</div>
