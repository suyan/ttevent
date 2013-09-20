<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
  <title>天天测试</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="__PUBLIC__/css/bootstrap.css">
  <link rel="stylesheet" href="__PUBLIC__/css/base.css">
  <script type="text/javascript" src="__PUBLIC__/js/jquery.js"></script>
  <style type="text/css">
    body{
      margin-top:50px;
    }
    table{
      table-layout: fixed;
      word-wrap:break-word;
    }
  </style>
</head>
<body data-spy="scroll" date-target="#main">
  <div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
      <div class="container">
        <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="brand" href="">天天测试</a>
        <div class="nav-collapse collapse">
          <ul id='top_nav' class="nav">
            <?php if(is_array($navs)): foreach($navs as $key=>$nav): ?><li class= <?php echo ($key == $topic)?'active':'' ?>><a href="__APP__/Index/index/topic/<?php echo ($key); ?>"><?php echo ($nav); ?></a></li><?php endforeach; endif; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row" >
      <div class="span2" id="main">
        <ul id="dst_nav" class="nav nav-pills nav-stacked span2" data-spy="affix" data-offset-top="40">
          <?php if(is_array($lists)): foreach($lists as $key=>$value): ?><li><a href="<?php echo ($value); ?>"><?php echo ($key); ?></a></li><?php endforeach; endif; ?>
        </ul>
      </div>
      <div class="span10">
        <table class="table table-bordered table-condensed">
          <tr><th class="span2">来源</th><th class="span8">信息</th></tr>
          <?php echo ($content); ?>
        </table>
      </div>
    </div>
  </div>
  <script type="text/javascript" src="__PUBLIC__/js/bootstrap.js"></script>
  <script type="text/javascript" src="__PUBLIC__/js/base.js"></script>
</body>
</html>