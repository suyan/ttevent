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
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">城市 <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li class="nav-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>
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
  <img class="large_avatar" src="<?php echo ($user['middle_img']); ?>" alt="">
  <h3 class="center"><?php echo ($user['nickname']); ?></h3>
  <table class="table">
    <tr><td>创建</td><td>参加</td><td>关注</td></tr>
    <tr><td><?php echo ($user["event_count"]); ?></td><td><?php echo ($user["event_join"]); ?></td><td><?php echo ($user["event_follow"]); ?></td></tr>
  </table>
  <?php if($enable_follow): ?><div class="well well-small">
      <div id="show_follow" class="text-center">
        <?php if(!$user['is_followed']): ?><a id="follow_user" class="btn btn-primary btn-block" href="<?php echo U('UserFollow/followUser');?>/id/<?php echo ($user['id']); ?>"><i class="icon-star-empty icon-white"></i>关注(<?php echo ($user['follow_count']); ?>)</a>
        <?php else: ?>
          <div class="btn-group btn-block">
            <a class="btn btn-success btn-block dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-star icon-white"></i>已关注(<?php echo ($user['follow_count']); ?>)<span class="caret"></span></a>  
            <ul class="dropdown-menu">
              <li class="text-left"><a id="unfollow_user" href="<?php echo U('UserFollow/unfollowUser');?>/id/<?php echo ($user['id']); ?>">取消关注</a></li>
            </ul>
          </div><?php endif; ?>
      </div>
    </div><?php endif; ?>
</div>
<div class="span7">
  <div>
    <ul id="myTab" class="nav nav-tabs">
      <li><a href="#showJoinEvent" data-toggle="tab">Ta参与的活动</a></li>
      <li><a href="#showFollowEvent" data-toggle="tab">Ta关注的活动</a></li>
      <li class="active"><a href="#showManageEvent" data-toggle="tab">Ta管理的活动</a></li>
    </ul>
  </div>
  <div id="myTabContent" class="tab-content">
    <div class="tab-pane fade" id="showJoinEvent"></div>
    <div class="tab-pane fade" id="showFollowEvent"></div>
    <div class="tab-pane fade in active" id="showManageEvent"></div>
  </div>
</div>
<div class="span3">
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
  
<script type="text/javascript">
function getEventData(id){
  $('#'+id).html('<div class="center"><img src="__PUBLIC__/img/loading.gif"></div>');
  $.ajax({
    type:"GET",
    url:'<?php echo U("Event/'+id+'");?>'+'/user_id/<?php echo ($user["id"]); ?>',
    success:function(data){
      $('#'+id).html(data);
    },
    error:function(data){
      $('#'+id).html("获取超时");
    }});
}

function reGetEventData(href){
  $('#myTabContent .active').html('<div class="center"><img src="__PUBLIC__/img/loading.gif"></div>');
  $.ajax({
    type:"GET",
    url:href,
    success:function(data){
      $('#myTabContent .active').html(data);
    },
    error:function(data){
      $('#myTabContent .active').html('获取超时');
    }}); 
}

$(function(){
  getEventData('showManageEvent');
  $('#myTab a').click(function(e){
    e.preventDefault();
    if($($(this).attr('href')).html() == ''){
      getEventData($(this).attr('href').substr(1));
      $(this).tab('show');  
    }
  });
  $('.pagination a').live('click',function(event){
    event.preventDefault();
    reGetEventData($(this).attr('href'));
  });
  $('#follow_user').live('click',function(e){
    event.preventDefault();
    $.get($(this).attr('href'),function(data){
      if(data.status == 0)
        alert(data.info);
      else
        $('#show_follow').html('<div class="btn-group btn-block"><a class="btn btn-success btn-block dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-star icon-white"></i>已关注(<?php echo ($user["follow_count"]+1); ?>)<span class="caret"></span></a>  <ul class="dropdown-menu"><li class="text-left"><a id="unfollow_user" href="<?php echo U("UserFollow/unfollowUser");?>/id/<?php echo ($user["id"]); ?>">取消关注</a></li></ul></div>');
    });
  });
  $('#unfollow_user').live('click',function(e){
    event.preventDefault();
    $.get($(this).attr('href'),function(data){
      if(data.status == 0)
        alert(data.info);
      else  
        $('#show_follow').html('<a id="follow_user" class="btn btn-primary btn-block" href="<?php echo U("UserFollow/followUser");?>/id/<?php echo ($user['id']); ?>"><i class="icon-star-empty icon-white"></i>关注(<?php echo ($user["follow_count"]); ?>)</a>');
    });
  });
});
</script>

</body>
</html>