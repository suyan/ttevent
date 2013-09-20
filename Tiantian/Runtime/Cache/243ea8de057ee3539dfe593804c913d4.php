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

  
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/datetimepicker.css">
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/bootstrap-tagmanager.css">

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
                    <?php if(is_array($item)): foreach($item as $key=>$li): ?><li class="<?php echo ($li[2]?'active':'disabled'); ?>"><a href="javascript:;"><?php echo ($li[0]); ?></a></li><?php endforeach; endif; endforeach; endif; ?>
                </ul>
              </div>
            
            
  <div class="span10">
    <div class="alert alert-error hide">
      <button type="button" class="close">&times;</button>
      <div id="error_info"></div>
    </div>
    <div class="row">
      <form class="form-horizontal" id="eventForm" action="<?php echo U('EventCreate/offlineEventInfoSave');?>" method="POST">
        <div class="control-group">
          <label class="control-label" for="name">*活动名称</label>
          <div class="controls">
            <input type="text" name="name" class="span6" id="name" value="<?php echo isset($event_name)?$event_name:'';?>">
          </div>
        </div><!-- 活动名称 -->
        <div class="control-group">
          <label class="control-label" for="pic">*活动分类</label>
          <div class="controls">
            <input type="hidden" name="category_select">
          </div>
        </div><!-- 活动分类 -->
        <div class="control-group">
          <label class="control-label" for="start_time">*活动时间</label>
          <div class="controls">
            <div class="input-append date form_datetime" id="start_time">
                <input type="text" name="start_time" class="span2" placeholder="开始时间" value="<?php echo isset($start_time)?$start_time:'';?>" readonly>
                <span class="add-on"><i class="icon-calendar"></i></span>
            </div>
            <div class="input-append date form_datetime" id="end_time">
                <input type="text" name="end_time" class="span2" placeholder="结束时间" value="<?php echo isset($end_time)?$end_time:'';?>" readonly>
                <span class="add-on"><i class="icon-calendar"></i></span>
            </div>
          </div>
        </div><!-- 活动时间 -->
        <div class="control-group" id="schedule">
          <label class="control-label" for="schedule_time">*日程安排</label>
          <?php if(isset($schedule)): if(is_array($schedule)): foreach($schedule as $key=>$value): ?><div class="controls">
                <div class="input-append">
                  <div class="input-append date form_datetime">
                    <input type="text" class="span2" placeholder="时间节点" readonly name="schedule_time[]" value="<?php echo date('Y-m-d G:i',$key);?>">
                    <span class="add-on"><i class="icon-calendar"></i></span>  
                  </div>
                  <input type="text" placeholder="安排" name="schedule_text[]" value="<?php echo ($value); ?>">
                  <a class="btn add_input"><i class="icon-plus"></i></a>
                  <a class="btn remove_input"><i class="icon-minus"></i></a>
                </div>
              </div><?php endforeach; endif; ?>  
          <?php else: ?>
            <div class="controls">
              <div class="input-append">
                <div class="input-append date form_datetime">
                  <input type="text" class="span2" placeholder="时间节点" readonly name="schedule_time[]" value="">
                  <span class="add-on"><i class="icon-calendar"></i></span>  
                </div>
                <input type="text" placeholder="安排" name="schedule_text[]" value="">
                <a class="btn add_input"><i class="icon-plus"></i></a>
                <a class="btn remove_input"><i class="icon-minus"></i></a>
              </div>
            </div><?php endif; ?>
        </div><!-- 日程安排 -->
        <div class="control-group">
          <label class="control-label" for="location">*活动地点</label>
          <div class="controls">
            <input type="hidden" name="location_select">
            <br><br>
            <input type="text" class="span7" name="location" value="<?php echo isset($location)?$location:'';?>" placeholder="详细地址">
          </div>
        </div><!-- 活动地点 -->
        <div class="control-group">
          <label class="control-label" for="description">*活动详情</label>
          <div class="controls">
            <textarea style="width:100%;height:200px;" id="description" name="description"><?php echo isset($description)?$description:'';?></textarea>
          </div>
        </div><!-- 活动描述 -->
        <div class="control-group">
          <label class="control-label" for="eventBilling">*活动费用</label>
          <div class="controls">
            <label class="radio inline">
              <input type="radio" name="eventBilling" value="0" checked>
              免费
            </label>
            <label class="radio inline disabled">
              <input type="radio" name="eventBilling" value="1" disabled>
              收费<span class="text-error">(赞不支持)</span>
            </label>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="joinType">*参加方式</label>
          <div class="controls">
            <label class="radio inline">
              <input type="radio" name="joinType" value="0" checked>
              所有人都可参加
            </label>
            <label class="radio inline disabled">
              <input type="radio" name="joinType" value="1">
              只能通过邀请参加
            </label>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="showType">*显示情况</label>
          <div class="controls">
            <label class="radio inline">
              <input type="radio" name="showType" value="0" checked>
              可见
            </label>
            <label class="radio inline">
              <input type="radio" name="showType" value="1">
              不可见
            </label>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="tags">活动标签</label>
          <div class="controls">
            <input name="tags" autocomplete="off" placeholder="回车添加标签" class="tagManager">
          </div>
        </div><!-- 活动标签 -->
        <div class="form-actions">
          <button type="submit" id="submit" class="btn btn-primary" data-loading-text="正在处理...">保存</button>
        </div>
      </form>
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

  
<script type="text/javascript" src="__PUBLIC__/js/kindeditor/kindeditor-min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.form.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/bootstrap-datetimepicker.zh-CN.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/bootstrap-tagmanager.js"></script>
<script src="__PUBLIC__/js/jquery.optionTree.js"></script>
<script type="text/javascript">
$(function () { 
  var category_select = {
    empty_value: 'null',
    indexed: true,
    on_each_change: '<?php echo U("Ajax/getCategory");?>',
    choose: function(level) {
      if(level==0) return '请选择分类';
      if(level==1) return '请选择子分类';
    },
    preselect: { 'category_select' : [ '<?php echo isset($event_category)?$event_category:"";?>' , '<?php echo isset($event_sub_category)?$event_sub_category:"";?>' ]},
    preselect_only_once: true, 
    loading_image:'__PUBLIC__/img/loading.gif',
    select_class:'span2',
    get_parent_value_if_empty: true,
  };
  $.getJSON('<?php echo U("Ajax/getCategory");?>', function(tree) {
    $('input[name=category_select]').optionTree(tree, category_select);
  });
  $(".form_datetime").datetimepicker({
    format: "yyyy-MM-dd hh:ii",
    autoclose: true,
    minuteStep: 10,
    language: 'zh-CN',
    todayBtn:true
  });
  var start_time;
  var end_time;
  $('#start_time').datetimepicker().on('changeDate',function(e){
    start_time = new Date(e.date.valueOf());
    $('#end_time').datetimepicker('setStartDate',start_time);
  });
  $('#end_time').datetimepicker().on('changeDate',function(e){
    end_time = new Date(e.date.valueOf());
    $('#start_time').datetimepicker('setEndDate',end_time);
  });
  $('.add_input').live('click',function(){
    $(this).parents('.controls').after('<div class="controls"><div class="input-append"><div class="input-append date form_datetime extra_date"><input type="text" class="span2" placeholder="时间节点" readonly name="schedule_time[]"><span class="add-on"><i class="icon-calendar"></i></span></div><input type="text" placeholder="安排" name="schedule_text[]"><a class="btn add_input"><i class="icon-plus"></i></a><a class="btn remove_input"><i class="icon-minus"></i></a></div></div>');
    $(".extra_date").datetimepicker({
      startDate:start_time,
      endDate:end_time,
      format: "yyyy-MM-dd hh:ii",
      autoclose: true,
      minuteStep: 10,
      language: 'zh-CN',
      todayBtn:true
    });
  });
  $('.remove_input').live('click',function(){
    if($('#schedule').children('.controls').length > 1)
      $(this).parents('.controls').remove();
    else
      $('.notifications').notify({message: { text: '唯一一条日程不可删除' }, type: 'error' }).show();
  });
  var location_options = {
    empty_value: 'null',
    indexed: true,
    on_each_change: '<?php echo U("Ajax/getRegion");?>',
    choose: function(level) {
      if(level==0) return '请选择省份';
      if(level==1) return '请选择城市';
      if(level==2) return '请选择区域';
    },
    preselect: { 'location_select' : [ '<?php echo isset($province)?$province:"";?>' , '<?php echo isset($city)?$city:"";?>' , '<?php echo isset($area)?$area:"";?>' ]},
    preselect_only_once: true, 
    loading_image:'__PUBLIC__/img/loading.gif',
    select_class:'span2',
    get_parent_value_if_empty: true,
  };
  $.getJSON('<?php echo U("Ajax/getRegion");?>', function(tree) {
    $('input[name=location_select]').optionTree(tree, location_options);
  });
  $('.tagManager').tagsManager({
    hiddenTagListName: 'tag',
    typeahead: true,
    typeaheadAjaxSource: '<?php echo U("Event/getEventTag");?>'+'/tag/',
    typeaheadAjaxPolling: true,
    <?php echo isset($tag)?'prefilled:"'.$tag.'",':''; ?>
  });
  var editor = KindEditor.create('#description',{
    resizeType : 1,
    allowPreviewEmoticons : false,
    allowImageUpload : false,
    items : [
      'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
      'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
      'insertunorderedlist', '|', 'emoticons', 'image', 'link']
  });
  var options = {
    beforeSubmit:validateForm,
    success:showResponse,
    clearForm:false
  }
  var submit = $("#submit");
  $('.alert .close').live("click", function(e) {
      $(this).parent().hide();
  });
  function show_error(txt){
    $('#error_info').html(txt).parent('div').show();
    scroll(0,0);
  }
  function check_schedule(){
    var schedule = true;
    $('#schedule .controls').each(function(){
      if(!$(this).find('[name="schedule_time[]"]').val() || !$(this).find('[name="schedule_text[]"]').val())
        schedule=false;
    });
    return schedule;
  }
  function validateForm(formData,jqForm,options){
    submit.button('loading');
    $('#description').html(editor.html());
    if(!$('#name').val()){
      show_error('请填写活动名称');
    }else if($('select[name=category_select_]').val() == 0){
      show_error('请选择分类');
    }else if($('select[name=category_select__]').val() == 0){
      show_error('请选择子分类');
    }else if(!$('input[name=start_time]').val() || !$('input[name=end_time]')){
      show_error('请选择活动时间');
    }else if($('select[name=location_select_]').val() == 0){
      show_error('请选择省份');
    }else if($('select[name=location_select__]').val() == 0){
      show_error('请选择城市');
    }else if($('select[name=location_select___]').val() == 0){
      show_error('请选择区域');
    }else if(!$('#description').html()){
      show_error('请填写活动详情');
    }else if(!check_schedule()){
      show_error('请完善活动日程安排');
    }else{
      return true;
    }
    submit.button('reset');
    return false;
  }
  function showResponse(ret,statusText){
    submit.button('reset');
    if(ret.status==0){
      $('#error_info').html(ret.info).parent('div').show();
      scroll(0,0);
    }else{
      window.location.href=ret.info
    }
  }
  $('#eventForm').ajaxForm(options);
}); 
</script>

</body>
</html>