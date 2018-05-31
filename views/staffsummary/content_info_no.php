
    <section class="content-header col-md-10">
      <h1>
        暂无工作内容
        <small>
            <?php if( isset($wmodel) && !empty($wmodel) && $wmodel->status == 1):?>
            <a class="btn btn-success" href="<?= Yii::$app->urlManager->createUrl(["staffsummary/add", "id" =>  Yii::$app->request->get("id")])?>">上传工作总结</a> &nbsp;&nbsp;&nbsp;
            <?php endif;?>
            <?php if(isset($tt) && $tt=="work"):?>
        <a  href="javascript:window.close();" class="btn btn-primary">关闭</a>
        <?php else:?>
        <a  href="<?= Yii::$app->urlManager->createUrl(["staffsummary"])?>" class="btn btn-primary">返回</a>
        <?php endif;?>
         
        </small>
      </h1>
      
    </section>
    <br><br><br><br>
   
