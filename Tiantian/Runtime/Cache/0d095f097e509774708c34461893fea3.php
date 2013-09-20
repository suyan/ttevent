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

  
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/jquery.Jcrop.css">
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
      <div class="span5">
        <form id="avatarForm" action="<?php echo U('Setting/uploadImage');?>" method="POST">
          <p class="text-info">请选择头像文件</p>
          <input type="file" name="pic" id="fileupload">
          <div class="progress hide">
            <div class="bar"><div class="precent"></div></div>
          </div>
          <div class="row">
            <div id="src_img" class="span6">
              <img id="src" src="">
            </div>
            <div id="submit_field" class="span6 hide">
              <a id="submit_coords" class="btn btn-primary" href="javascript:;" data-loading-text="裁剪中...">确认裁剪</a>
            </div>
          </div>
          <div id="coords" class="hide">0,0,0,0</div>
        </form><!-- 图片上传部分 -->
      </div>
      <div class="span5">
        <h4>预览</h4>
        <table class="table">
          <tr><td>大图</td><td><div id="large_div" style="width: 140px;height: 140px;overflow: hidden;"><img id="large_img" class="jcrop-preview" src="<?php echo !empty($avatar['large_img'])?$avatar['large_img']:'';?>" style="width:140px;height:140px;"></div></td></tr><tr>
          <td>中图</td><td><div id="middle_div" style="width: 50px;height: 50px;overflow: hidden;"><img id="middle_img" class="jcrop-preview" src="<?php echo !empty($avatar['middle_img'])?$avatar['middle_img']:'';?>" style="width:50px;height:50px;"></div></td></tr><tr>
          <td>小图</td><td><div id="small_div" style="width: 30px;height: 30px;overflow: hidden;"><img id="small_img" class="jcrop-preview" src="<?php echo !empty($avatar['small_img'])?$avatar['small_img']:'';?>" style="width:30px;height:30px;"></div></td></tr>
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
<script type="text/javascript" src="__PUBLIC__/js/jquery.Jcrop.js"></script>
<script type="text/javascript">
$(function () { 
  //裁剪部分
  var ret_width,ret_height;
  var bar = $('.bar'); 
  var percent = $('.precent'); 
  var progress = $(".progress");
  var submit_field = $('#submit_field');
  var jcrop_api,boundx,boundy;
  function updatePreview(c){
    if(parseInt(c.w)>0){
      var rx=100/c.w;
      var ry=100/c.h;
      $("#preview").css({
        width:Math.round(rx*boundx)+"px",
        height:Math.round(ry*boundy)+"px",
        marginLeft:"-"+Math.round(rx*c.x)+"px",
        marginTop:"-"+Math.round(ry*c.y)+"px"
      });
      var rx=180/c.w;
      var ry=180/c.h;
      $("#large_img").css({
        width:Math.round(rx*boundx)+"px",
        height:Math.round(ry*boundy)+"px",
        marginLeft:"-"+Math.round(rx*c.x)+"px",
        marginTop:"-"+Math.round(ry*c.y)+"px"
      });
      var rx=50/c.w;
      var ry=50/c.h;
      $("#middle_img").css({
        width:Math.round(rx*boundx)+"px",
        height:Math.round(ry*boundy)+"px",
        marginLeft:"-"+Math.round(rx*c.x)+"px",
        marginTop:"-"+Math.round(ry*c.y)+"px"
      });
      var rx=30/c.w;
      var ry=30/c.h;
      $("#small_img").css({
        width:Math.round(rx*boundx)+"px",
        height:Math.round(ry*boundy)+"px",
        marginLeft:"-"+Math.round(rx*c.x)+"px",
        marginTop:"-"+Math.round(ry*c.y)+"px"
      });
    };
  }
  function updateCoords(c){
    var width = $('#src').width();
    var ratio = ret_width/width;
    c.x = parseInt(ratio*c.x);
    c.y = parseInt(ratio*c.y);
    c.w = parseInt(ratio*c.w);
    c.h = parseInt(ratio*c.h);
    $("#coords").html(''+c.x+','+c.y+','+c.w+','+c.h);
  }
  $("#fileupload").change(function(){ 
    $("#avatarForm").ajaxSubmit({ 
      dataType:  'json', 
      beforeSend: function() { 
        $('#showsrc').empty();
        submit_field.hide();
        var percentVal = '0%'; 
        bar.width(percentVal); 
        percent.html(percentVal); 
        progress.show();
      }, 
      uploadProgress: function(event, position, total, percentComplete) { 
        var percentVal = percentComplete + '%'; 
        bar.width(percentVal); 
        percent.html(percentVal); 
      }, 
      success: function(data) {
        progress.hide();
        if(0 == data.status){
          submit_field.hide();
          alert(data.info);
        }
        submit_field.show();
        ret_width = data.width;
        ret_height = data.height;
        $('#src_img').html('<img id="src" src="'+data.url+'">');
        $('#large_img').attr('src',data.url);
        $('#middle_img').attr('src',data.url);
        $('#small_img').attr('src',data.url);
        $("#src").Jcrop({
          onSelect:updateCoords,
          onChange:updatePreview,
          setSelect:[0, 0, 100,100],
          aspectRatio:1/1,
        },function(){
          var bounds=this.getBounds();
          boundx=bounds[0];
          boundy=bounds[1];
          jcrop_api=this;
        });
      }, 
      error:function(xhr){ 
        bar.width('0'); 
      } 
    }); 
  }); 
  $('#submit_coords').click(function(){
    if($('#coords').html()=='0,0,0,0')
      return false;
    $('#submit_coords').button('loading');
    $.ajax({
      type:"GET",
      url:'<?php echo U("Setting/cropImage");?>'+'/coords/'+$('#coords').html(),
      success:function(data){
        data = JSON.parse(data);
        $('#large_div').html('<img id="large_img" class="jcrop-preview" src="'+data.large_img+'">');
        $('#middle_div').html('<img id="middle_img" class="jcrop-preview" src="'+data.middle_img+'">');
        $('#small_div').html('<img id="small_img" class="jcrop-preview" src="'+data.small_img+'">');
        $('#submit_coords').button('reset');
        $('#src_img').html('');
        submit_field.hide();
        alert('修改成功');
      },
      error:function(data){
        alert(data);
        submit_field.hide();
      }});
  });
}); 
</script>

</body>
</html>