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
          <li style="margin-left:30px;margin-top:-5px">
            <form class="form-search navbar-search pull-right" action="">
              <div class="input-append">
                <input type="text" class="span3 search-query">
                <button type="submit" class="btn">搜索</button>
              </div>
            </form>    
          </li>
        </ul>
        <ul class="nav pull-right">
          <li><a href="<?php echo U('Public/register');?>">注册</a></li>
          <li><a href="<?php echo U('Public/login');?>">登录</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

    
    <div class="container">
      <br>
      
        <ul class="breadcrumb">
  <?php if(is_array($bread)): foreach($bread as $key=>$item): ?><li>
      <?php if($item[2]): echo ($item[0]); ?>
      <?php else: ?>
        <a href="<?php echo ($item[1]); ?>"><?php echo ($item[0]); ?></a><span class="divider">/</span><?php endif; ?>
    </li><?php endforeach; endif; ?>
</ul><!-- 上部提示 -->

      
      <div class="row">
        <div class="span12">
          <div class="row">
            
              <div class="span2">
  <ul class="nav nav-pills nav-stacked">
    <?php if(is_array($nav_list)): foreach($nav_list as $key=>$item): ?><li class="nav-header"><?php echo ($key); ?></li>
      <?php if(is_array($item)): foreach($item as $key=>$li): ?><li class="<?php echo ($li[2]?'active':''); ?>"><a href="<?php echo ($li[1]); ?>"><?php echo ($li[0]); ?></a></li><?php endforeach; endif; endforeach; endif; ?>
  </ul>
</div>

            
            
<div class="span10">
  <table class="table table-bordered">
    <thead>
      <tr><th>序号</th><th>姓名</th><th>邮箱</th><th>手机</th><th>参加时间</th><th>状态</th></tr>
    </thead>
    <tbody>
      <?php if(is_array($joins)): $i = 0; $__LIST__ = $joins;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$join): $mod = ($i % 2 );++$i;?><tr><td class="hide"><?php echo ($join['id']); ?></td><td><?php echo ($key+1); ?></td><td><?php echo ($join['real_name']); ?></td><td><?php echo ($join['event_email']); ?></td><td><?php echo ($join['mobile']); ?></td><td><?php echo date('Y-m-d G:i',$join['create_time']);?></td><td>已参加</td></tr><?php endforeach; endif; else: echo "" ;endif; ?>
    </tbody>
  </table>
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
      <div class="offset12" style="position:fixed;bottom:30px;">
        <a href="javascript:scroll(0,0)" title="回到顶部"><i class="icon-arrow-up icon-2x"></i></a>
      </div>
    </div>
</div>
  
  <div class='notifications center'></div>
<script type="text/javascript" src="__PUBLIC__/js/bootstrap.js"></script>
<script src="__PUBLIC__/js/bootstrap-notify.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/base.js"></script>

  
<script type="text/javascript" src="__PUBLIC__/js/jquery.form.js"></script>
<script type="text/javascript">
</script>

</body>
</html>