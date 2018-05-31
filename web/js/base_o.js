"use strict"

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
            dialog.find('.bootbox-body').html("操作成功！");
            
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
