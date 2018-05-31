<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'daterangepicker/daterangepicker.css',
        'datepicker/datepicker3.css',
        'select2/select2.min.css',
        'css/uploader.css',
        'iCheck/all.css',
        'css/site.css',
        'css/demo.css',
    ];
    public $js = [
        'js/app.min.js',
        'daterangepicker/moment.js', 
        'daterangepicker/daterangepicker.js',
        'datepicker/bootstrap-datepicker.js',
        'select2/select2.min.js',
        'iCheck/icheck.min.js',
        'js/bootbox.js',
        'js/dmuploader.js',
        'js/demo.js',
        'js/base.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
