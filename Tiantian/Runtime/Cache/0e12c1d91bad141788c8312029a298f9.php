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
</style>

</head>
<body>
	<div id="wrap">
		
<div class="navbar navbar-static-top">
  <div class="navbar-inner">
    <div class="container">
      <a class="brand" href="<?php echo U('Public/index');?>"><?php echo C('SITE_NAME');?></a>
      <ul class="nav">
        <li><a href="javascript:;">随时随地参与活动</a><li>
      </ul>
      <ul class="nav pull-right">
        <li><a href="<?php echo U('Public/register');?>">注册</a></li>
        <li><a href="<?php echo U('Public/login');?>">登录</a></li>
      </ul>
    </div>
  </div>
</div>

		
<div class="container">
  <br>
  <ul class="breadcrumb">
    <li><a href="">首页</a> <span class="divider">/</span></li>
    <li class="active">注册</li>
  </ul>
  <div class="span12">
    <div class="row">
      <div class="span6">
        <?php echo W("Form",$data);?>
      </div>
      <div class="span4 offset1">
        <br>
        <h4>第三方帐号登录</h4>
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
      <div class="offset12" style="position:fixed;bottom:30px;">
        <a href="javascript:scroll(0,0)" title="回到顶部"><i class="icon-arrow-up icon-2x"></i></a>
      </div>
    </div>
</div>
	
	<div class='notifications center'></div>
<script type="text/javascript" src="__PUBLIC__/js/bootstrap.js"></script>
<script src="__PUBLIC__/js/bootstrap-notify.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/base.js"></script>

	
</body>
</html>