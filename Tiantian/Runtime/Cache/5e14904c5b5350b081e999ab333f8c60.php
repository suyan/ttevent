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
  <div class="row">
    <div class="span10">
      <a class="btn btn-primary" href="<?php echo U('eventManage/modifyEventInfo',array('id'=>$event['id']));?>"><i class="icon-edit icon-white"></i>修改活动</a>
      <a class="btn btn-primary" href="<?php echo U('Main/eventPrint',array('id'=>$event['id']));?>"><i class="icon-print icon-white"></i>打印宣传单</a>
      <button class="btn btn-danger pull-right" id="delete"><i class="icon-remove icon-white"></i>删除活动</button>
    </div>
    <div class="span10"><hr></div>
    <div class="span5">
      <table class="table table-bordered">
        <h3 class="text-center">活动参与情况</h3>
        <thead><tr><th>项目</th><th>内容</th></tr></thead>
        <tbody>
          <tr><td>关注用户数</td><td><?php echo ($event['follow_count']); ?></td></tr>
          <tr><td>参与用户数</td><td><?php echo ($event['join_count']); ?></td></tr>
          <tr><td>活动评论数</td><td><?php echo ($event['comment_count']); ?></td></tr>
        </tbody>
      </table>
    </div>
    <div class="span5">
      <table class="table table-bordered">
        <h3  class="text-center">活动时间</h3>
        <thead><tr><th>项目</th><th>内容</th></tr></thead>
        <tbody>
          <tr><td>创建时间</td><td><?php echo ($event['create_time']); ?></td></tr>
          <tr><td>开始时间</td><td><?php echo ($event['start_time']); ?></td></tr>
          <tr><td>结束时间</td><td><?php echo ($event['end_time']); ?></td></tr>
          <tr><td>最后更新时间</td><td><?php echo ($event['update_time']); ?></td></tr>
        </tbody>
      </table>
    </div>
    <div class="span10">
      <table class="table table-bordered">
        <h3 class="text-center">活动基本资料</h3>
        <thead><tr><th>项目</th><th>内容</th></tr></thead>
        <tbody>
          <tr><td class="span2">活动名称</td><td><?php echo ($event['name']); ?></td></tr>
          <tr><td>活动海报</td><td><img src="<?php echo ($event['middle_img']); ?>"></td></tr>
          <tr><td>当前状态</td><td><?php echo ($event['show_status']); ?></td></tr>
          <tr><td>创建人</td><td><?php echo ($event['user']['nickname']); ?></td></tr>
          <tr><td>活动地点</td><td><?php echo ($event['location']); ?></td></tr>
          <tr><td>活动分类</td><td><?php echo ($event['category']); ?>  <?php echo ($event['sub_category']); ?></td></tr>
          <tr><td>活动标签</td>
            <td>
              <?php if(is_array($event['EventTag'])): foreach($event['EventTag'] as $key=>$tag): ?><span class="label label-info"><?php echo ($tag['name']); ?></span><?php endforeach; endif; ?>
            </td>
          </tr>
          <tr><td>活动详情</td><td><?php echo ($event['description']); ?></td></tr>
        </tbody>
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
$(function(){
  $('#delete').bind('click',function(){
    option = {
      title:'系统提示',
      body:'<p class="text-error">是否确定删除此活动(不可恢复)!</p>',
      onok:function(){
        $.get("<?php echo U('Event/deleteEvent',array('id'=>$event['id']));?>",function(data){
          if(data.status == 1){
            $('.notifications').notify({
              type:'success',
              message: { text: '删除成功，正在跳转!' }
            }).show();  
            var url = "<?php echo U('Event/myEvent');?>";
            setTimeout(function(){window.location.href = url;},2000);
            close_pop_box();
          }else{
            close_pop_box();
            $('.notifications').notify({
              type:'error',
              message: { text: '删除失败!' }
            }).show();  
          }
        });
      }
    };
    show_pop_box(option);
  });
});
</script>

</body>
</html>