    <section class="content-header col-md-10">
      <h1>
        工作总结内容
        <small><?= $model->employee->name?></small>
      </h1>
      <ol class="breadcrumb">
       
        <?php if( isset($wmodel) && !empty($wmodel) && $wmodel->status == 1):?>
          <a type="button" href="<?= Yii::$app->urlManager->createUrl(["staffsummary/update", "id"=>$model->summary->work_id])?>" class="btn btn-success ">修改</a>
        <?php endif;?>
          <?php if(isset($tt) && $tt=="work"):?>
        <a  href="javascript:window.close();" class="btn btn-primary">关闭</a>
        <?php else:?>
        <a  href="<?= Yii::$app->urlManager->createUrl(["staffsummary"])?>" class="btn btn-primary">返回</a>
        <?php endif;?>
      </ol>
    </section>
    <br><br><br><br>
    <div class="row">
        <div class="col-md-10">
            <div class="nav-tabs-custom">
                <div class="tab-content">
                    <div class="tab-pane active" >
                        <?= $model->content?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
var s_e = "20153214";
</script>