<?php
use backend\assets\AppAsset;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

dmstr\web\AdminLteAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <script src="/js/jquery-1.11.3.min.js"></script>

     <script>
    $(function(){
    var theUA = window.navigator.userAgent.toLowerCase();
    if ((theUA.match(/msie\s\d+/) && theUA.match(/msie\s\d+/)[0]) || (theUA.match(/trident\s?\d+/) && theUA.match(/trident\s?\d+/)[0])) {
        var ieVersion = theUA.match(/msie\s\d+/)[0].match(/\d+/)[0] || theUA.match(/trident\s?\d+/)[0];
        if (ieVersion < 10) {
            var str = "你的浏览器版本太低了,请升级您的浏览器";
            var str2 = "<h2 style='font-weight:900;padding:10px 0;'>推荐使用：<a href='https://www.baidu.com/s?ie=UTF-8&wd=%E8%B0%B7%E6%AD%8C%E6%B5%8F%E8%A7%88%E5%99%A8' target='_blank' style='color:#ffffff;'>谷歌浏览器</a>"
                + "</h2>";
            document.writeln("<pre style='font-size:25px;text-align:center;color:#fff;background-color:#0cc; height:100%;border:0;position:fixed;top:0;left:0;width:100%;z-index:1234'>" +
                "<h2 style='padding-top:200px;margin:0'><strong>" + str + "<br/></strong></h2><h2>" +
                str2 + "</h2><h2 style='margin:0'><strong>如果您的使用的是360、搜狗、QQ等双核浏览器，请在最顶部切换到极速模式访问<br/></strong></h2>" +
                "<h2 style='margin:0'><strong>切换浏览器方法请参考：<a href='https://jingyan.baidu.com/article/d169e186a3dd27436611d829.html' target='_blank' style='color:#ffffff;'>切换浏览器到极速模式</a><br/></strong></h2></pre>");
            //document.execCommand("Stop");
        }
    }

    });
    </script>


    <script src="/js/bootstrap.js"></script>
    <script src="/js/bootbox.js"></script>
    <script src="/js/base_o.js"></script>
    <?php $this->head() ?>
</head>
<style type="text/css">  
   
    .placeholder {  
        color: #ccc;  
    }  
</style>  
<body class="login-page">

<?php $this->beginBody() ?>

    <?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
