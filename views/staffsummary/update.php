<?php
/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
?>
<div class="row">
    <div class="col-md-10">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">
                    <?= $model->work_title?>
                </h3>
                <!-- tools box -->
                <div class="pull-right box-tools">
                    <button type="button" class="btn btn-info btn-sm btn-back" data-widget="返回" data-toggle="tooltip" title="返回">
                        返回
                    </button>
                    <button type="button" onclick="$('#work').submit();" class="btn btn-info btn-sm" data-widget="提交" data-toggle="tooltip" title="提交">
                        提交
                    </button>
                </div>
                <!-- /. tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body pad">
                <form action="" method="post" id="work">
                    <?php 
                        use \kucha\ueditor\UEditor;
                        echo UEditor::widget([
                            "name" => "work_content",
                            
                            "clientOptions" => [
                                "id"=>"work_content",
                                "name"=>"work_content",
                                "initialContent" => $content->content,
                                'lang' =>'zh-cn',
                                'toolbars' => [
                                    [
                                        'bold', 'italic', 'underline', '|',
                                        'fontborder', 'strikethrough', 'superscript', 'subscript', 'blockquote',  '|', 
                                        'forecolor',  'insertorderedlist', 'insertunorderedlist', '|',
//                                        'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
                                        'fontfamily', 'fontsize', '|',
                                        'indent', '|',
//                                        'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 
                                        'link', 'unlink', '|', 
                                        'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
                                        'simpleupload', 'insertimage', 'attachment', '|',
                                        'horizontal', 'spechars', '|',
                                        'inserttable', 'deletetable',  'charts', '|',
                                        'help'
                                    ],
                                ]
                            ]
                        ]);
                    ?>
                </form>
            </div>
        </div>
          <!-- /.box -->
    </div>
</div>
