<div id="nav">
  <li><a href="#s1">禁用a的链接</a></li>
  <li><a href="#s2">清空file的内容</a></li>
  <li><a href="#s3">表单验证插件</a></li>
  <li><a href="#s4">选择父结点</a></li>
  <li><a href="#s5">多重操作</a></li>
</div>

<h2 id="s1">禁用a的链接</h2>

    href="return false;"或href="javascript;"
    $().live('click',function(e){
      e.preventDefault();
      });

<h2 id="s2">清空file的内容</h2>
  
    var cfile = $('#id').clone();
    $('#id').replaceWith(cfile);

<h2 id="s3">表单验证插件</h2>
    这两个脚本搭配在表单验证和提交是非常的好用,顺便增加了对bootstrap表单的支持
    $("#page_form").validate({
      highlight: function(element) {
        $(element).closest('.control-group').removeClass('success').addClass('error');
      },
      success: function(element) {
        element.text('OK!').addClass('valid').closest('.control-group').removeClass('error').addClass('success');
      },
      submitHandler:function(form) {
        $(form).ajaxSubmit(options);
    }});

<h2 id="s4">选择父节点</h2>
    使用$(this)来将dom对象转为jquery对象
    $(this).parents('tr');

<h2 id="s5">多重操作</h2>
    $(this).parents('tr').remove();
    因为jquery函数返回jquery节点