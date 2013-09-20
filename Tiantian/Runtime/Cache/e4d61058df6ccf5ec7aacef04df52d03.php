<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
<title><?php echo ($title); ?> | 天天活动</title>
<link rel="shortcut icon" href="__PUBLIC__/img/favicon.ico" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="__PUBLIC__/css/bootstrap.css">
<link rel="stylesheet" href="__PUBLIC__/css/bootstrap-notify.css">
<link rel="stylesheet" href="__PUBLIC__/css/font-awesome.css">
<!--[if IE 7]>
<link rel="stylesheet" href="__PUBLIC__/css/font-awesome-ie7.min.css">
<![endif]-->
<?php if(isset($mobile)): ?><link rel="stylesheet" href="__PUBLIC__/css/bootstrap-responsive.css"><?php endif; ?>
<link rel="stylesheet" href="__PUBLIC__/css/base.css">
<script type="text/javascript" src="__PUBLIC__/js/jquery.js"></script>

	
<style type="text/css">
.box{
    float: right;
    box-shadow: 0 0 5px 0 rgb(238, 238, 238);
    background: white;
    border:1px solid #DFDFDF;
    border-radius: 5px;
    width: 90%;
    padding: 35px 0 30px;
    margin-bottom:30px;
}
</style>

</head>
<body>
	<div id="wrap">
		
<div class="navbar navbar-static-top">
  <div class="navbar-inner">
    <div class="container">
      <a class="brand" href="<?php echo U('Public/index');?>"><?php echo C('SITE_NAME');?></a>
      <ul class="nav">
        <li id="login"><a href="javascript:;">随时随地参与活动</a><li>
      </ul>
      <ul class="nav pull-right">
        <li><a href="<?php echo U('Public/login');?>#register">注册</a></li>
        <li><a href="<?php echo U('Public/login');?>">登录</a></li>
      </ul>
    </div>
  </div>
</div>

		
  <header class="jumbotron" id="overview">
    <div class="container">
      <br><br><br> 
      <h1 class="text-center" style="color:white;">登录到<?php echo C('SITE_NAME');?></h1>
      <p class="lead text-center" style="color:white;">随时随地参与和管理活动</p>
      <div class="row">
        <div class="span10 offset2">
          <form action="<?php echo U('Public/checkLogin');?>" id="loginForm" class="form-inline" method="POST">
            <div class="control-group inline">
              <input type="text" name="email" class='span4' placeholder="邮箱" style="height:30px;">
            </div>
            <div class="control-group inline">
              <input type="password" name="password" class='span4' placeholder="密码" style="height:30px;">
            </div>
            <button type="submit" class="btn btn-primary btn-large">登录</button>
          </form>    
        </div>
        <div class="span10 offset2">
          <p style="color:white;">还没有帐号？<a href="#register">注册</a></p>
        </div>
      </div>
      <br><br><br>
    </div>
  </header>
<div class="container">
  <div class="span12">
    <div class="row">
      <br><br><br> 
      <div class="span12">
        <legend id="register">注册</legend>
      </div>
      <div class="span6">
      </div>
      <div class="span6">
        <div class="box text-center">
          <form action="<?php echo U('Public/addUser');?>" id="registerForm" class="form-horizontal" method="POST">
            <div class="control-group"><input type="text" name="email" class='span4' placeholder="邮箱" style="height:30px;"></div>
            <div class="control-group"><input type="password" id="registerPassword" name="password" class='span4' placeholder="密码" style="height:30px;"></div>
            <div class="control-group"><input type="password" name="confirm_password" class='span4' placeholder="确认密码" style="height:30px;"></div>
            <div class="control-group"><input type="text" name="nickname" class='span4' placeholder="昵称" style="height:30px;"></div>
            <p>已有帐号？<a href="#login">登录</a></p>
            <p><button type="submit" class="btn btn-primary btn-large" data-loading-text="注册中...">注册</button></p>
          </form>
        </div>
      </div>
    </div>
  </div>
</div> 

		<div id="push"></div>
	</div>
	
		<div id="footer">
    <div class="container">
      <div class="row">
        <div class="span3">
          <h4>天天活动</h4>
          <p>WEB</p>
          <p>Android</p>
          <p>iPhone</p>
        </div>
        <div class="span3">
          <h4>关于我们</h4>
          <p>官方网站</p>
          <p>微博</p>
          <p>博客</p>
        </div>
        <div class="span3">
          <h4>联系我们</h4>
          <p>反馈bug</p>
          <p>联系邮箱</p>
        </div>
        <div class="span3 text-right">
          <h2>天天活动</h2>
          <p>Copyright &copy; 2013-2013 ttevent</p>
          <p>All Rights Reserved</p>
        </div>
      </div>
    </div>
</div>
	
	<div class='notifications center'></div>
<script type="text/javascript" src="__PUBLIC__/js/bootstrap.js"></script>
<script src="__PUBLIC__/js/bootstrap-notify.js"></script>
<script src="__PUBLIC__/js/jquery.scrollUp.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/base.js"></script>
<script>$(function(){$.scrollUp({scrollImg: { active: true}});});</script>
	
<script type="text/javascript" src="__PUBLIC__/js/jquery.form.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.validate.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/messages_zh.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.validate.bootstrap.js"></script>
<script>
$(document).ready(function(){
  var submit;
  var options = {
    beforeSubmit:validateForm,
    success:showResponse,
    clearForm:false
  }
  function validateForm(formData,jqForm,options){
    submit.button('loading');
    return true;
  }
  function showResponse(ret,statusText){
    submit.button('reset');
    if(ret.status==0){
      $('.notifications').notify({message: { text:ret.info }}).show();
    }else{
      $('.notifications').notify({message: { text:ret.info }}).show();
      setTimeout(function(){history.go(0);},2000);
    }
  }
  //增加表单验证
  $("#registerForm").validate({
    rules:{
      email:{required:true,email:true,remote:"<?php echo U('Public/checkEmail'); ?>"},password:{required:true,minlength:6},confirm_password:{required:true,minlength:6,equalTo:"#registerPassword"},nickname:{required:true,minlength:2},
    },
    messages:{
      email:{required:"请输入邮箱",email:"请输入正确的邮箱",remote:"邮箱已存在"},password:{required:"请输入密码",minlength:"密码最短为六位"},confirm_password:{required:"请输入密码",minlength:"密码最短为六位",equalTo:"密码输入不一致"},nickname:{required:"请输入昵称",minlength:"昵称最少为两个字"},    
    },
    submitHandler:function(form) {
      submit = $(form).find('button');
      $(form).ajaxSubmit(options);
  }});
  $('#loginForm').validate({
      rules:{email:{required:true,email:true},password:{required:true,minlength:6}},
      messages:{email:{required:"请输入邮箱",email:"请输入正确的邮箱"},password:{required:"请输入密码",minlength:"密码最短为六位"}},
      submitHandler:function(form) {
        submit = $(form).find('button');
        $(form).ajaxSubmit(options);
    }
  });
});
</script>

</body>
</html>