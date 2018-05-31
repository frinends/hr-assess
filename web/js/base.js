"use strict"
    $('#drag-and-drop-zone').dmUploader({
        url: '/salary/add',
        dataType: 'json',
//        allowedTypes: 'excel/*',
        extFilter: 'xls;xlsx',
        onInit: function(){
//          $.danidemo.addLog('#demo-debug', 'default', 'Plugin initialized correctly');
        },
        onBeforeUpload: function(id){
          $.danidemo.addLog('#demo-debug', 'default', '开始上传文件 #' + id);

          $.danidemo.updateFileStatus(id, 'default', 'Uploading...');
        },
        onNewFile: function(id, file){
          $.danidemo.addFile('#demo-files', id, file);
        },
        onComplete: function(){
          //$.danidemo.addLog('#demo-debug', 'default', '开始上传文件');
        },
        onUploadProgress: function(id, percent){
          var percentStr = percent + '%';

          $.danidemo.updateFileProgress(id, percentStr);
        },
        onUploadSuccess: function(id, data){//上传成功
          $.danidemo.addLog('#demo-debug', 'success', '上传成功');

          $.danidemo.addLog('#demo-debug', 'info', 'Server Response for file #' + id + ': ' + JSON.stringify(data));

          $.danidemo.updateFileStatus(id, 'success', '上传成功');

          $.danidemo.updateFileProgress(id, '100%');
        },
        onUploadError: function(id, message){//上传中错误
          $.danidemo.updateFileStatus(id, 'error', message);

          $.danidemo.addLog('#demo-debug', 'error', '上传文件失败');
        },
//        onFileTypeError: function(file){//文件类型错误
//          $.danidemo.addLog('#demo-debug', 'error', '文件 \'' + file.name + '\' cannot be added: must be an image');
//        },
        onFileSizeError: function(file){//文件大小错误
          $.danidemo.addLog('#demo-debug', 'error', '文件 \'' + file.name + '\' cannot be added: size excess limit');
        },
        onFileExtError: function(file){
          $.danidemo.addLog('#demo-debug', 'error', '文件 \'' + file.name + '\' 的格式不正确');
        },
        onFallbackMode: function(message){
          $.danidemo.addLog('#demo-debug', 'info', 'Browser not supported(do something else here!): ' + message);
        }
    });
$(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
    //全选
    $('.selectall').on('ifChecked ifUnchecked', function(event){
        if (event.type == 'ifChecked') {
            $(this).parents(".form-group").find(".input-group label input[type=\"checkbox\"]").iCheck('check');
        }else{
            $(this).parents(".form-group").find(".input-group label input[type=\"checkbox\"]").iCheck('uncheck');
        }
    });
    
    $(".btn-s-h").click(function(){
        var n = $(this).attr("data-original-title");
        if(n == "竖排"){
            $(".h-show").addClass("hide");
            $(".s-show").removeClass("hide");
            $(this).attr("data-original-title", "横排");
        }else{
            $(".s-show").addClass("hide");
            $(".h-show").removeClass("hide");
            $(this).attr("data-original-title", "竖排");
        }
        return true;
    });
    
    
    $("#rank-weight").delegate(".select-rank", "change", function(){
        var n = $(this).attr("data-k");
        var text = '<span class="pull-right-container rank_ddel" style="margin-left:3px;cursor: pointer;"><input type="hidden" value="'+$(this).val()+'" name="rank['+n+'][]"><small class="label bg-green">'+$(this).find("option:selected").text()+'</small></span>';
        if($(this).parent().prev().html() == "请在右侧选择职级（可以多选）"){
            $(this).parent().prev().html("");
        }
        $(this).parent().prev().append(text);
    });
    $("#rank-weight").delegate(".rank_ddel", "click", function(){
        $(this).remove();
    });
    $(".add_weight_rank").click( function(){
        var txt = $(".rank-weight-hide table tbody").html();
        var n = $("#rank-weight tbody tr").length;
      
        txt = txt.replace(/ran_num/g, n);
        $("#rank-weight tbody").append(txt);
    });
  });

/**
 * 确认/返回
 */
 $(function () {
     
    $(".btn-people").click(function(){
        $("#modal-image").css("display", "block");
    });
     //关闭图片
    $(".close").bind("click", function(){
        $("#modal-image").css("display", "none");
    });
     
    $(".btn-confirm").click(function () {
      var msg = $(this).attr("confirm-msg");
      if (!msg) {
        msg = "确定要执行此操作吗？";
      }
      return confirm(msg);
    });
    
    $(".btn-back").click(function () {
        window.history.go(-1);
    });
    
    $(".btn-reset").click(function(){
        var url = "";
        if(typeof(url = $(this).attr("data-link")) == "undefined"){
            url = $(this).parents("form").attr("action");
        }
        location.href = url;
    });
    
    $("table").delegate('.btn-remove', 'click', function(){
        $('#'+$(this).attr('aria-describedby')).remove();
        $('#'+$(this).attr("remove-id")).remove();
    });

 });
 
 
 /**
 * 时间插件
 */
 $(function () {
    $('#examine_t').daterangepicker();
   
    $('#datepicker').datepicker({autoclose: true});
    

 });

/**
 * 表单提交
 */
var formSubmit = function() {
    // 阻止回车自动提交
    $("form input").keypress(function(event) {
      if (event.which == 13) {
        event.preventDefault();
        return false;
      }
    });

    $(".btn-submit").click(function() {
    if (!$(this).is(":disabled")) {
       
        // btn-submit-confirm
        var form = $(this).parents('form'),
            action = form.attr("action"),
            method = form.attr("method"),
            btn = $(this);
       
        // prevent multiple clicks
        btn.prop("disabled", true);

        var formData = new FormData(form[0]);
        $(form).find("input, select, img, radio, textarea").each(function() {
          if($(this).prop("type").toLowerCase()=='file') {
              formData.append(name, $(this)[0]);
          }
        });

      // Ajax submit function
      var ajaxSubmit = function(dialog) {

        var settings = {
          method: method,
          url: action,
          dataType: "json",
          processData: false,
          contentType: false,
          data: formData
        };

        $.ajax(settings).done(function(resp) {
            
          // 请求 - 返回成功
          if (resp.code == 0) {
            var msg = "操作成功！";
            if(resp.msg){
                msg = resp.msg;
            }
            dialog.find('.bootbox-body').html(msg);
            
            setTimeout(function () {
                btn.prop("disabled", false);
                //处理
                if (typeof(resp.data.href) != "undefined") {
                    window.location.href = resp.data.href;
                } else if (typeof(resp.data.reload) != "undefined") {
                    window.location.reload();
                }
                
            }, 800);
          } else {
            setTimeout(function () {
                dialog.modal("hide");
                btn.prop("disabled", false);
                // 显示错误信息
                for (var k in resp.data.errors) {
                    var formGroup = form.find("[name='"+k+"']").parents(".form-group");
                    displayError(formGroup, resp.data.errors[k]['err_msg']);
                }
            }, 500);
          }

          (typeof(afterSubmit) != 'undefined' && afterSubmit != null) && afterSubmit(resp);

        }).fail(function(jqXHR, textStatus) {
          btn.prop("disabled", false);
          (typeof(afterSubmit) != 'undefined' && afterSubmit != null) && afterSubmit(resp);
        });
      };

        // execute beforeSubmit
        var dialog = bootbox.dialog({
            size: 'small',
            closeButton:false,
            message: '<p style="text-align:center;margin: auto"><i class="fa fa-spin fa-spinner"></i> 操作中...</p>'
        });
        dialog.init(function(){
            setTimeout(function(){
                ajaxSubmit(dialog);
            }, 1000);
        });
      
     
          
    }
  });

  // remove error message when the input focus
  $("form input,form select,form textarea").focus(function() {
    hideError($(this));
  });

  $("select").change(function() {
    hideError($(this));
  });
};

/**
 * 显示/隐藏表单错误提示
 */
var displayError = function (formGroup, msg) {
  formGroup.addClass("has-error");
  formGroup.find(".help-block").text(msg);
},
hideError = function ($subEle) {
  $subEle.parents(".form-group.has-error").find(".help-block").html("&nbsp;");
  $subEle.parents(".form-group.has-error").removeClass("has-error");
};


$(document).ready(function() {
  formSubmit();
});

/**
 * ajax delete
 */
$(function(){
   
        $(".btn-del").click(function() {
            var href = $(this).attr("data-link");
            var ajaxDel = function(dialog) {
                var settings = {
                  method: "GET",
                  url: href,
                  dataType: "json",
                  processData: false,
                  contentType: false
                };
                $.ajax(settings).done(function(resp) {
                    if(typeof resp.data.msg != "undefined"){
                        var msg = resp.data.msg;
                    }else{
                        var msg = resp.code == 0 ? "操作成功" : "操作失败";
                    }
                    dialog.find('.bootbox-body').html(msg);
                    setTimeout(function () {
                        //处理
                        if (typeof(resp.data.href) != "undefined") {
                            window.location.href = resp.data.href;
                        } else {
                            window.location.reload();
                        }
                    }, 700);
                    
                });
            };
            
            bootbox.confirm({
                size: 'small',
                message: $(this).attr("data-message"),
                buttons: {
                    cancel: {
                        label: '<i class="fa fa-times"></i> 取消'
                    },
                    confirm: {
                        label: '<i class="fa fa-check"></i> 确认'
                    }
                },
                callback: function (result) {
                    if(result){
                        var dialog = bootbox.dialog({
                            size: 'small',
                            closeButton:false,
                            message: '<p><i class="fa fa-spin fa-spinner"></i> 操作中...</p>'
                        });
                        dialog.init(function(){
                            setTimeout(function(){
                                ajaxDel(dialog);
                            }, 400);
                        });
                    }
                }
            });
      });
   
});

$(function(){
    $("#unit").on("change", function(){
        if(typeof($("#department_url").val()) == "undefined")
            return false;
        var unit_id = $(this).val(),url = $("#department_url").val();
        
        getdepartment(url+"?id="+unit_id, 0);
    });
    
    if(unit && unit > 0 ){

        if(typeof($("#department_url").val()) == "undefined")
            return false;
        var unit_id = unit,url = $("#department_url").val();
   
        var dep = typeof(department) == "undefined" ? 0 : department;
       
        getdepartment(url+"?id="+unit_id, dep);
    }
});


function getdepartment(url, dep){
    
    var settings = {
          method: "GET",
          url: url,
          dataType: "json",
          processData: false,
          contentType: false
        };
    $.ajax(settings).done(function(resp) {
        if(resp.code == 1){
            var list = resp.result.list, htm = "<option value=\"\">请选择部门</option>";
            for (var i=0;i<list.length;i++){
                var selected = (dep == list[i].id) ? "selected" : "";
                htm+= "<option value=\""+list[i].id+"\" "+selected+" >"+list[i].name+"</option>";
            }
            $("#department").html(htm);
        }
    });
}

$(function(){
    $("#modal-image .modal-body select").change(function(){
        var  id = $(this).attr("id");
        if(id != "people"){
            var is_of = id.indexOf("1")
            if( is_of > 0){
                var unit = $("#modal-image #unit1").val();
                var department = $("#modal-image #department1").val();
                var rank = $("#modal-image #rank1").val();
            }else{
                var unit = $("#modal-image #unit").val();
                var department = $("#modal-image #department").val();
                var rank = $("#modal-image #rank").val();
            }
            var settings = {
                method: "post",
                url: "/performance/employee",
                data: {unit:unit,department:department,rank:rank}
            };

            $.ajax(settings).done(function(resp) {
                if( is_of > 0){
                    $("#modal-image #people1").html(resp);
                }else{
                    $("#modal-image #people").html(resp);
                }
            });
        }
    });
    
    $("#modal-image #people").change(function(){
        var v = $(this).val();
        var h = $('#modal-image #people option:selected').text();
        if(v > 0 )
            $("#modal-image #people_show").append('<li class="badge bg-green" data-v="'+v+'">'+h+'<span class="select2-selection__choice__remove" role="presentation">×</span></li>');
    });
    
    $("#modal-image #people1").change(function(){
        var v = $(this).val();
        var h = $('#modal-image #people1 option:selected').text();
        if(v > 0 )
            $("#modal-image #people_show1").append('<li class="badge bg-green" data-v="'+v+'">'+h+'<span class="select2-selection__choice__remove" role="presentation">×</span></li>');
    });
    
    $("#people_show,#people_show1").delegate("li .select2-selection__choice__remove", "click", function(){
        $(this).parent().remove();
    });
});


$(function(){
    $("#unit1").on("change", function(){
        if(typeof($("#department_url").val()) == "undefined")
            return false;
        var unit_id = $(this).val(),url = $("#department_url").val();
        
        getdepartment_a(url+"?id="+unit_id);
    });
    
    $(".add-other").click(function(){
        var dialog = bootbox.dialog({
            size: 'small',
            closeButton:false,
            message: '<p style="text-align:center;margin: auto"><i class="fa fa-spin fa-spinner"></i> 操作中...</p>'
        });
        dialog.init();
        
        var people_1 = [],people_2 = [];
        //考核ID
        var id = $("#id").val();
        //权重
//        var weight = $(".weight").val();
        //考核人
        $("#people_show li").each(function(){
            people_1.push($(this).attr("data-v"));
        });
        //被考核人
        $("#people_show1 li").each(function(){
            people_2.push($(this).attr("data-v"));
        });
        
//        if(!(weight > 0)){
//            dialog.find('.bootbox-body').html("请填写正规的权重！");
//            setTimeout(function () {
//                dialog.modal("hide");
//            }, 1000);
//            return false;
//        }
        if(people_1.length == 0 || people_2.length == 0){
            dialog.find('.bootbox-body').html("请填写考核人与被考核人！");
            setTimeout(function () {
                dialog.modal("hide");
            }, 1000);
           
            return false;
        }
        //模版
        var task_model = $("#task_model").val();
        if(!(task_model > 0)){
            dialog.find('.bootbox-body').html("请选择考核模版！");
            setTimeout(function () {
                dialog.modal("hide");
            }, 1000);
            return false;
        }
        var settings = {
          method: "POST",
          url: '/performance/set_other_task',
          dataType: "json",
          data:{id:id, weight:weight, people_1:people_1, people_2:people_2, task_model:task_model}
        };
        $.ajax(settings).done(function(resp) {
            if (resp.code == 0) {
                dialog.find('.bootbox-body').html("操作成功！");
                setTimeout(function () {
                    //处理
                    if (typeof(resp.data.href) != "undefined") {
                        window.location.href = resp.data.href;
                    } else if (typeof(resp.data.reload) != "undefined") {
                        window.location.reload();
                    }

                }, 1000);
            } else {
                setTimeout(function () {
                    dialog.modal("hide");
                  
                    // 显示错误信息
                    for (var k in resp.data.errors) {
                        var formGroup = form.find("[name='"+k+"']").parents(".form-group");
                        displayError(formGroup, resp.data.errors[k]['err_msg']);
                    }
                }, 1000);
            }
        });
        
    });
});


function getdepartment_a(url){
    var settings = {
          method: "GET",
          url: url,
          dataType: "json",
          processData: false,
          contentType: false
        };
    $.ajax(settings).done(function(resp) {
        if(resp.code == 1){
            var list = resp.result.list, htm = "<option value=\"\">请选择部门</option>";
            for (var i=0;i<list.length;i++){
                htm+= "<option value=\""+list[i].id+"\" >"+list[i].name+"</option>";
            }
            $("#department1").html(htm);
        }
    });
}

$(function(){
    $(".shield").click(function(){
        var t = $(this);
        var url = t.attr("data-link");
        var settings = {
          method: "GET",
          url: url,
          dataType: "json",
          processData: false,
          contentType: false
        };
        $.ajax(settings).done(function(resp) {
            if(resp.code == 0){
                t.parent().parent().remove();
            }
        });
    });
    
    $(".btn-score").click(function(){

        var text = $(this).text(), is_s = true, dat = {};
        
        var m_score = 0;
        $(".score tbody tr").each(function(a){
            var options = {},d = {};
            var ss = 0;
            $(this).find("select").each(function(e){
                var tt = {};
                tt.id = $(this).attr("data-tpl-id"),tt.val = $(this).val();
                options[e] = tt; 
                if($(this).val() < 0){
                    is_s = false;
                    $(this).addClass("has-error");
                }
                ss = ss+parseInt($(this).val());
            });
            
            if(ss == 100){
                m_score+=1;
            }
            d.info_id = $(this).attr("data-info");
            d.employee_id =  $(this).attr("data-employee");
            d.content =  options;
            d.p = $(this).attr("data-p");
            d.task_id = $(this).attr("data-task");
            d.text = text;
            d.type = $(this).attr("data-type");
            dat[a] = d;
        });
        
        if(!is_s){
            var dialog = bootbox.dialog({
                size: 'small',
                closeButton:false,
                message: '<p style="text-align:center;margin: auto"><i class="fa fa-spin fa-spinner"></i> 操作中...</p>'
            });
            dialog.init();
            setTimeout(function () {
                dialog.find('.bootbox-body').html("请进行评分");
                setTimeout(function () {
                    dialog.modal("hide");
                }, 1300);
            }, 800);
            return false;
        }
        
        if(m_score>0){
            bootbox.confirm({
                size: 'small',
                message: "您评分的人员有满分的，确认要这么评分吗？",
                buttons: {
                    cancel: {label: '<i class="fa fa-times"></i> 取消'},
                    confirm: {label: '<i class="fa fa-check"></i> 确认'}
                },
                callback: function (result) {
                    if(result){
                        var dialog = bootbox.dialog({size: 'small',closeButton:false,message: '<p><i class="fa fa-spin fa-spinner"></i> 操作中...</p>'});
                        dialog.init(function(){
                            setTimeout(function(){ajaxpos(dialog);}, 400);
                        });
                    }
                }
            });
        }else{
            var dialog = bootbox.dialog({
                size: 'small',
                closeButton:false,
                message: '<p style="text-align:center;margin: auto"><i class="fa fa-spin fa-spinner"></i> 操作中...</p>'
            });
            dialog.init(function(){
                            setTimeout(function(){ajaxpos(dialog);}, 400);
                        });
        }

        var settings = {
          method: "POST",
          url: "/ptask/record_scores",
          dataType: "json",
          data: {content:JSON.stringify(dat)}
        };
        
        var ajaxpos = function(dialog) { 
            $.ajax(settings).done(function(resp) {
                if (resp.code == 0) {
                    dialog.find('.bootbox-body').html("操作成功！");
                    setTimeout(function () {
                        //处理
                        if (typeof(resp.data.href) != "undefined") {
                            window.location.href = resp.data.href;
                        } else if (typeof(resp.data.reload) != "undefined") {
                            window.location.reload();
                        }
                    }, 1000);
                } else {
                    dialog.find('.bootbox-body').html(resp.data.msg);
                    setTimeout(function () {
                        dialog.modal("hide");
                    }, 1000);
              }
            });
        };
        
    });
    
    
    $(".select-people").select2({
    ajax: {
      url: "/employees/search",
      dataType: 'json',
      delay: 250,
      method: "post",
      data: function (params) {
        return {
          name: params.term
        };
      },
      processResults: function (data, params) {
        var result = [];
        
        if (data.code == 0 && data.data.employees.length > 0) {
            var employees = data.data.employees;
            for(var i = 0; i < employees.length; i++) {
              var id = employees[i]['id'],text = employees[i]['name']+"（"+employees[i]['dep_name']+"）";

              result.push({"id": id, "text": text});
            }
        }
        return {
          results: result
        };
      },
      cache: true
    },
    minimumInputLength: 1,
    language: 'zh-CN'
  });
  $(".select-people").change(function () {
        var text = $(this).find("option:selected").text(),
            id   = $(this).val();
        var html = '<a class="label bg-green" style="white-space:pre;margin:3px 3px;display: block;"><input type="hidden" value="'+id+'" name="employees[]">'+text+' x</a>';
        $(".input-group").append(html);
  });
  $(".input-group").delegate("a", "click", function(){
      $(this).remove();
  });
});