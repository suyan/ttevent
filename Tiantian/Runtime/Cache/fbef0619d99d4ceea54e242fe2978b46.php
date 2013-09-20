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
          <li class="divider-vertical"></li>
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
          <li class="divider-vertical"></li>
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
          <li class="divider-vertical"></li>
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
          <li class="divider-vertical"></li>
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
    <li><a href="<?php echo U('Public/index');?>">首页</a> <span class="divider">/</span></li>
    <li class="active"><?php echo ($event['name']); ?></li>
  </ul><!-- 上部提示 -->
  <div class="row">
    <div class="span12">
      <div class="row">
        <div class="span2">
          <div class="row">
            <img src="<?php echo ($event['middle_img']); ?>" class="img-polaroid span2">
          </div>
          <div class="row">
            <div class="span2">
              <small><strong>时间：</strong><?php echo ($event['time']); ?></small><br>
              <small><strong>地点：</strong><?php echo ($event['location']); ?></small><br>
              <small><strong>发起：</strong><?php echo ($event['user']['nickname']); ?></small><br>
              <small><strong>状态：</strong><?php echo ($event['show_status']); ?></small> 
            </div>
          </div>
          <br>
          <?php if($user_id): ?><div class="well well-small">
              <div id="show_follow" class="text-center">
                <?php if(!$event['is_followed']): ?><a id="follow_event" class="btn btn-primary btn-block" href="<?php echo U('EventFollow/followEvent');?>/id/<?php echo ($event['id']); ?>"><i class="icon-star-empty icon-white"></i>关注(<?php echo ($event['follow_count']); ?>)</a>
                <?php else: ?>
                  <div class="btn-group btn-block">
                    <a class="btn btn-success btn-block dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-star icon-white"></i>已关注(<?php echo ($event['follow_count']); ?>)<span class="caret"></span></a>  
                    <ul class="dropdown-menu">
                      <li class="text-left"><a id="unfollow_event" href="<?php echo U('EventFollow/unfollowEvent');?>/id/<?php echo ($event['id']); ?>">取消关注</a></li>
                    </ul>
                  </div><?php endif; ?>
                </div>
                <div id="show_join" class="text-center">
                <?php if(!$event['is_joined']): ?><a id="join_event" class="btn btn-primary btn-block" href="<?php echo U('EventJoin/joinEvent');?>/id/<?php echo ($event['id']); ?>"><i class="icon-heart-empty icon-white"></i>参加(<?php echo ($event['join_count']); ?>)</a>  
                <?php else: ?>
                  <div class="btn-group btn-block">
                    <a class="btn btn-success btn-block dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-heart icon-white"></i>已参加(<?php echo ($event['join_count']); ?>)<span class="caret"></span></a>  
                    <ul class="dropdown-menu">
                      <li class="text-left"><a id="unjoin_event" href="<?php echo U('EventJoin/unjoinEvent');?>/id/<?php echo ($event['id']); ?>">取消参加</a></li>
                    </ul>
                  </div><?php endif; ?>
              </div>
            </div><?php endif; ?>
        </div>
        <div class="span7">
          <div class="tabbable"> 
            <ul class="nav nav-tabs">
              <li class="active"><a href="#eventDescription" data-toggle="tab">活动详情</a></li>
              <li><a id="getEventFeed" href="#eventFeed" data-toggle="tab">活动动态</a></li>
              <li><a id="getEventComment" href="#eventComment" data-toggle="tab">活动评论</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="eventDescription">
                <h4>活动详情</h4>
                <?php echo ($event['description']); ?>
                <h4>日程安排</h4>
                <?php if($event['schedule']): ?><table class="table">
                    <tr><th class="span2">时间</th><th>安排</th></tr>
                    <?php if(is_array($event['schedule'])): foreach($event['schedule'] as $key=>$value): ?><tr><td><?php echo date('Y-m-d G:i',$key);?></td><td><?php echo ($value); ?></td></tr><?php endforeach; endif; ?>
                  </table>
                <?php else: ?>
                  本活动还没有日程安排<?php endif; ?>
              </div>
              <div class="tab-pane" id="eventFeed"></div>
              <div class="tab-pane" id="eventComment"></div>
            </div>
          </div>
        </div>
        <div class="span3">
          <h4>活动举办方</h4>
          <table class="table table-condensed">
            <tr>
              <td style="width:50px;"><a href="<?php echo U('User/userPage',array('id'=>$event['user']['id']));?>"><img class="media-object middle_avatar" src="<?php echo ($event['user']['middle_img']); ?>"></a></td>
              <td>
                <h4 class="media-heading"><a href="<?php echo U('User/userPage',array('id'=>$event['user']['id']));?>"><?php echo ($event['user']['nickname']); ?></a></h4>
                <p>举办：<?php echo ($event['user']['event_count']); ?></p>  
              </td>
            </tr>  
          </table>
          <h4>手机扫描加入</h4>
          <div class="center">
            <img src="__PUBLIC__/qrcode/<?php echo ($event['EventQrcode']['name']); ?>" alt="">
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
  
<script type="text/javascript">
function show_unjoin_event(){
  $('#show_join').html('<div class="btn-group btn-block"><a class="btn btn-success btn-block dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-heart icon-white"></i>已参加(<?php echo ($event["join_count"]+1); ?>)<span class="caret"></span></a><ul class="dropdown-menu"><li class="text-left"><a id="unjoin_event" href="<?php echo U("EventJoin/unjoinEvent");?>/id/<?php echo ($event["id"]); ?>">取消参加</a></li></ul></div>');
}
$(function(){
  $('#getEventComment').on('show',function(e){
    if($('#eventComment').html() == ''){
      $('#eventComment').html('<div class="center"><img src="__PUBLIC__/img/loading.gif"></div>');
      $.get('<?php echo U("EventComment/showEventComments",array("id"=>$event['id']));?>',function(data){
        if(data.status == 0)
          $('#eventComment').html("<center>请先<a href='<?php echo U('Public/login');?>'>登录</a></center>");
        else  
          $('#eventComment').html(data);
      });
      $(this).tab('show');  
    }
  });
  // $('#getEventComment').tab('show');
  $('#getEventFeed').on('show',function(e){
    if($('#eventFeed').html() == ''){
      $('#eventFeed').html('<div class="center"><img src="__PUBLIC__/img/loading.gif"></div>');
      $.get('<?php echo U("EventFeed/feed",array("id"=>$event['id']));?>',function(data){
        if(data.status == 0)
          $('#eventFeed').html("<center>请先<a href='<?php echo U('Public/login');?>'>登录</a></center>");
        else  
          $('#eventFeed').html(data);
      });
      $(this).tab('show');  
    }
  });
  $('.pagination a').live('click',function(event){
    event.preventDefault();
    $('#eventComment').html('<div class="center"><img src="__PUBLIC__/img/loading.gif"></div>');
    $.get($(this).attr('href'),function(data){
      if(data.status == 0)
        $('#eventComment').html("<center>请先登录</center>");
      else  
        $('#eventComment').html(data);
    });
  });
  $('#follow_event').live('click',function(e){
    event.preventDefault();
    $.get($(this).attr('href'),function(data){
      if(data.status == 0)
        alert(data.info);
      else
        $('#show_follow').html('<div class="btn-group btn-block"><a class="btn btn-success btn-block dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-star icon-white"></i>已关注(<?php echo ($event["follow_count"]+1); ?>)<span class="caret"></span></a>  <ul class="dropdown-menu"><li class="text-left"><a id="unfollow_event" href="<?php echo U("EventFollow/unfollowEvent");?>/id/<?php echo ($event["id"]); ?>">取消关注</a></li></ul></div>');
    });
  });
  $('#unfollow_event').live('click',function(e){
    event.preventDefault();
    $.get($(this).attr('href'),function(data){
      if(data.status == 0)
        alert(data.info);
      else  
        $('#show_follow').html('<a id="follow_event" class="btn btn-primary btn-block" href="<?php echo U("EventFollow/followEvent");?>/id/<?php echo ($event['id']); ?>"><i class="icon-star-empty icon-white"></i>关注(<?php echo ($event["follow_count"]); ?>)</a>');
    });
  });
  $('#join_event').live('click',function(e){
    event.preventDefault();
    show_pop_box_url("<?php echo U('EventJoin/showUserInfoForm/',array('id'=>$event['id']));?>");
  });
  $('#unjoin_event').live('click',function(e){
    event.preventDefault();
    $.get($(this).attr('href'),function(data){
      if(data.status == 0)
        alert(data.info);
      else  
        $('#show_join').html('<a id="join_event" class="btn btn-primary btn-block" href="<?php echo U("EventJoin/joinEvent");?>/id/<?php echo ($event["id"]); ?>"><i class="icon-heart-empty icon-white"></i>参加(<?php echo ($event["join_count"]); ?>)</a>');
    });
  });
  var status = <?php echo ($event['status']); ?>;
  if(3 == status)
    $('#getEventFeed').tab('show');
});
</script>

</body>
</html>