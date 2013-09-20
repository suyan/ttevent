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
  <div class="row">
    <br>
    <div class="span12">
      <div class="row">
        <div class="span9">
          <legend>
            正在进行/即将进行
            <ul class="nav nav-pills pull-right">
              <li><a class="pull-right" href="#myCarousel" data-slide="prev"><i class="icon-chevron-left"></i></a></li>
              <li><a class="pull-right" href="#myCarousel" data-slide="next"><i class="icon-chevron-right"></i></a></li>
            </ul>
          </legend>
          <div id="myCarousel" class="carousel slide" >
            <div class="carousel-inner">
              <?php if(isset($events[0])): ?><div class="item active">
                  <ul class="thumbnails">
                    <?php if(is_array($events)): $i = 0; $__LIST__ = array_slice($events,0,3,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$event): $mod = ($i % 2 );++$i;?><li class="span3">
                        <a href="<?php echo ($event['url']); ?>" class="thumbnail" title="<?php echo ($event['name']); ?>">
                          <img src="<?php echo ($event['middle_img']); ?>" alt="<?php echo ($event['name']); ?>" style="width:100%">
                          <div class="center" style="word-break:break-all"><h5><?php echo ($event['short_name']); ?></h5></div>
                        </a>
                      </li><?php endforeach; endif; else: echo "" ;endif; ?>
                  </ul>
                </div><?php endif; ?>
              <?php if(isset($events[3])): ?><div class="item">
                  <ul class="thumbnails">
                    <?php if(is_array($events)): $i = 0; $__LIST__ = array_slice($events,3,3,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$event): $mod = ($i % 2 );++$i;?><li class="span3">
                        <a href="<?php echo ($event['url']); ?>" class="thumbnail" title="<?php echo ($event['name']); ?>">
                          <img src="<?php echo ($event['middle_img']); ?>" alt="<?php echo ($event['name']); ?>" style="width:100%">
                          <div class="center" style="word-break:break-all"><h5><?php echo ($event['short_name']); ?></h5></div>
                        </a>
                      </li><?php endforeach; endif; else: echo "" ;endif; ?>
                  </ul>
                </div><?php endif; ?>
              <?php if(isset($events[6])): ?><div class="item">
                  <ul class="thumbnails">
                    <?php if(is_array($events)): $i = 0; $__LIST__ = array_slice($events,6,3,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$event): $mod = ($i % 2 );++$i;?><li class="span3">
                        <a href="<?php echo ($event['url']); ?>" class="thumbnail" title="<?php echo ($event['name']); ?>">
                          <img src="<?php echo ($event['middle_img']); ?>" alt="<?php echo ($event['name']); ?>" style="width:100%">
                          <div class="center" style="word-break:break-all"><h5><?php echo ($event['short_name']); ?></h5></div>
                        </a>
                      </li><?php endforeach; endif; else: echo "" ;endif; ?>
                  </ul>
                </div><?php endif; ?>
            </div>
          </div>
          <legend>
            热门推荐
            <ul class="nav nav-pills pull-right">
              <li><a href="<?php echo U('Main/events');?>"><small>更多>></small></a></li>
            </ul>
          </legend>
          <div class="row">
            <div class="span9">
              <div class="row">
                <div class="tabbable tabs-left span1">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab1" data-toggle="tab" style="min-width: 35px;">全部</a></li>
                  </ul>  
                </div>
                <div class="tab-content">
                  <div class="tab-pane active" id="tab1">
                    <div class="span4">
                      <table class="table table-condensed">
                        <?php if(is_array($hotest_events)): $i = 0; $__LIST__ = array_slice($hotest_events,0,2,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$event): $mod = ($i % 2 );++$i;?><tr>
                            <td style="width:100px;"><a href="<?php echo ($event['url']); ?>" title="<?php echo ($event['name']); ?>">
                                  <img class="media-object" src="<?php echo ($event['middle_img']); ?>" style="width:80px;height:120px;">
                                </a></td>
                            <td>
                              <h5 class="media-heading"><a href="<?php echo ($event['url']); ?>" title="<?php echo ($event['name']); ?>"><?php echo ($event['short_name']); ?></a></h5>
                              <div>
                                <small><strong>时间：</strong><?php echo ($event['time']); ?></small><br>
                                <small><strong>地点：</strong><?php echo ($event['location']); ?></small><br>
                                <small><strong>发起：</strong><?php echo ($event['user']['nickname']); ?></small>
                                <p class="text-right"><small><strong><?php echo ($event['join_count']); ?></strong>人参加 <strong><?php echo ($event['follow_count']); ?></strong>人关注</small></p>
                              </div>
                            </td>
                          </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                      </table>  
                    </div> 
                    <div class="span4">
                      <table class="table table-condensed">
                        <?php if(is_array($hotest_events)): $i = 0; $__LIST__ = array_slice($hotest_events,2,2,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$event): $mod = ($i % 2 );++$i;?><tr>
                            <td style="width:100px;"><a href="<?php echo ($event['url']); ?>" title="<?php echo ($event['name']); ?>">
                                  <img class="media-object" src="<?php echo ($event['middle_img']); ?>" style="width:80px;height:120px;">
                                </a></td>
                            <td>
                              <h5 class="media-heading"><a href="<?php echo ($event['url']); ?>" title="<?php echo ($event['name']); ?>"><?php echo ($event['short_name']); ?></a></h5>
                              <div>
                                <small><strong>时间：</strong><?php echo ($event['time']); ?></small><br>
                                <small><strong>地点：</strong><?php echo ($event['location']); ?></small><br>
                                <small><strong>发起：</strong><?php echo ($event['user']['nickname']); ?></small>
                                <p class="text-right"><small><strong><?php echo ($event['join_count']); ?></strong>人参加 <strong><?php echo ($event['follow_count']); ?></strong>人关注</small></p>
                              </div>
                            </td>
                          </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                      </table>  
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="span3">
          <?php if(session(C('USER_AUTH_KEY'))): ?>
              <a class="btn btn-large btn-primary btn-block" href="<?php echo U('EventCreate/eventType');?>">发起活动</a>
          <?php endif; ?>
          <h4>热门举办方</h4>
          <div class="row">
            <div class="span3">
              <table class="table table-condensed">
                <?php if(is_array($hotest_creater)): foreach($hotest_creater as $key=>$user): ?><tr>
                    <td style="width:50px;"><a href="<?php echo U('User/userPage',array('id'=>$user['id']));?>"><img class="middle_avatar" src="<?php echo ($user['middle_img']); ?>"></a></td>
                    <td>
                      <h4 class="media-heading"><a href="<?php echo U('User/userPage',array('id'=>$user['id']));?>"><?php echo ($user['short_nickname']); ?></a></h4>
                      <div>举办：<?php echo ($user['event_count']); ?></div>
                    </td>
                  </tr><?php endforeach; endif; ?>  
              </table>
            </div>
          </div>
          <h4>热门用户</h4>
          <div class="row">
            <div class="span3">
              <table class="table table-condensed">
                <?php if(is_array($hotest_follower)): foreach($hotest_follower as $key=>$user): ?><tr>
                    <td style="width:50px;"><a href="<?php echo U('User/userPage',array('id'=>$user['id']));?>"><img class="middle_avatar" src="<?php echo ($user['middle_img']); ?>"></a></td>
                    <td>
                      <h4 class="media-heading"><a href="<?php echo U('User/userPage',array('id'=>$user['id']));?>"><?php echo ($user['short_nickname']); ?></a></h4>
                      <div>关注：<?php echo ($user['event_follow']); ?></div>
                      <div>参加：<?php echo ($user['event_join']); ?></div>
                    </td>
                  </tr><?php endforeach; endif; ?>  
              </table>
            </div>
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
  
</body>
</html>