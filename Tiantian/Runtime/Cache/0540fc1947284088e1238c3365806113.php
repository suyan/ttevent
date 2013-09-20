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
    
      <?php if(session(C('USER_AUTH_KEY'))): ?>
<div class="navbar navbar-static-top">
  <div class="navbar-inner">
    <div class="container">
      <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="brand" href="<?php echo U('Public/index');?>"><?php echo C('SITE_NAME');?></a>
      <div class="nav-collapse collapse">
        <ul class="nav">
          <?php if(is_array($navbar)): foreach($navbar as $key=>$item): if($item[2]): ?><li class="active"><a href="<?php echo ($item[1]); ?>"><?php echo ($item[0]); ?></a><li>
            <?php else: ?>
              <li><a href="<?php echo ($item[1]); ?>"><?php echo ($item[0]); ?></a><li><?php endif; endforeach; endif; ?>
          <!-- <li class="divider-vertical"></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">城市 <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="#">北京</a></li>
            </ul>
          </li>
          <li class="divider-vertical"></li> -->
          <li style="margin-left:30px;margin-top:-5px">
            <form class="form-search navbar-search pull-right" action="<?php echo U('Main/search');?>">
              <div class="input-append">
                <input type="text" class="span3 search-query" name="q">
                <button type="submit" class="btn">搜索</button>
              </div>
            </form>
          </li>
        </ul>
        <ul class="nav pull-right">
          <li><a href=""><?php echo session('nickname');?></a></li>
          <?php $notification_count =D('UserNotification')->getNotificationsCount(session(C('USER_AUTH_KEY'))); ?>
          <li><a href="<?php echo U('User/myNotification');?>"><i class="icon-envelope"></i><span class="label label-warning" style="position:absolute;top:1px;z-index:1001;"><?php echo ($notification_count?$notification_count:''); ?></span></a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="icon-cog"></i>
            </a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo U('Setting/baseProfile');?>">帐号设置</a></li>
              <!-- <li class="divider"></li> -->
              <li><a href="<?php echo U('Public/logout');?>">退出</a></li> 
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
<?php else: ?>
<div class="navbar navbar-static-top">
  <div class="navbar-inner">
    <div class="container">
      <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="brand" href="<?php echo U('Public/index');?>"><?php echo C('SITE_NAME');?></a>
      <div class="nav-collapse collapse">
        <ul class="nav">
          <li><a href="javascript:;">随时随地参与活动</a><li>
          <li style="margin-left:30px;margin-top:-5px;margin-right:30px;">
            <form class="form-search navbar-search pull-right" action="">
              <div class="input-append">
                <input type="text" class="span3 search-query">
                <button type="submit" class="btn">搜索</button>
              </div>
            </form>    
          </li>
        </ul>
        <ul class="nav pull-right">
          <li><a href="<?php echo U('Public/login');?>#register">注册</a></li>
          <li><a href="<?php echo U('Public/login');?>">登录</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

    
    
<div class="container">
  <div class="span12">
    <div class="row">
      <br>
      <ul class="breadcrumb">
        <li><a href="<?php echo U('Public/index');?>">首页</a> <span class="divider">/</span></li>
        <li class="active">全部活动</li>
      </ul>
      <div class="row">
        <div class="span2">
          <ul class="well nav nav-list" id='category'>
            <li class="nav-header">活动分类</li>
            <?php if(is_array($categories)): $i = 0; $__LIST__ = $categories;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$category): $mod = ($i % 2 );++$i; if(($category['id'] == $category_id) AND ($category['parent_id'] == 0)): ?><li class="active"><a href="javascript:;" name="<?php echo ($category['id']); ?>"><?php echo ($category['name']); ?>(<?php echo ($category['count']); ?>)</a></li>
              <?php elseif(($category['parent_id'] == 0)): ?>
                <li><a href="javascript:;" name="<?php echo ($category['id']); ?>"><?php echo ($category['name']); ?>(<?php echo ($category['count']); ?>)</a></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
          </ul>
        </div>
        <div class="span10">
          <div class="row">
            <div class="span7">
              <div class="btn-group">
                <button class="btn btn-primary" id="show_time" name="<?php echo ($time); ?>">时间</button>
                <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                <ul class="dropdown-menu" id="time">
                  <li><a href="javascript:;" name="all">全部</a></li>
                  <li><a href="javascript:;" name="today">今天</a></li>
                  <li><a href="javascript:;" name="tomorrow">明天</a></li>
                  <li><a href="javascript:;" name="week">最近一周</a></li>
                </ul>
              </div>
              <hr>
              <?php echo W("Event",$data);?>
            </div>
            <div class="span3"></div>
          </div>  
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
  
<script>
  var url='__APP__/Main/events';
  function gotourl(){
    var category_id = $('#category li[class=active] a').attr('name');
    if(category_id)
      url += '/category_id/'+category_id;
    var time = $('#show_time').attr('name');
    if(time)
      url += '/time/'+time;
    window.location.href = url;
  }
  //设置时间显示
  show_time = $('#show_time').attr('name');
  if(show_time)
    $('#show_time').html($('#time a[name='+show_time+']').html());
  $(function(){
    $("#category a").click(function(e){
      e.preventDefault();
      var category = $(this);
      $('#category li[class=active]').removeClass('active');
      category.parent('li').addClass('active');
      gotourl();
    });
    $('#time a').click(function(e){
      e.preventDefault();
      var time = $(this);
      $('#show_time').attr('name',time.attr('name'));
      $('#show_time').html(time.html());
      gotourl();
    });
  });
</script>

</body>
</html>