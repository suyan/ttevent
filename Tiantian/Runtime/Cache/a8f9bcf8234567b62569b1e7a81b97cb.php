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
    

    
<div class="container">
  <div class="row">
    <div class="span12">
      <hr>
      <h1 class="center"><?php echo ($event['name']); ?></h1>  
      <hr>
    </div>
    <div class="span4 offset1">
      <div class="row">
        <img src="<?php echo ($event['large_img']); ?>" alt="" class="span4">
      </div>
    </div>
    <div class="span6">
      <table class="table" style="font-size:20px">
        <tr>
          <td class="span1">时间</td><td><?php echo ($event['time']); ?></td>
        </tr>
        <tr>
          <td>地点</td><td><?php echo ($event['location']); ?></td>
        </tr>
        <tr>
          <td>主办</td><td><?php echo ($event['user']['nickname']); ?></td>
        </tr>
        <tr>
          <td>类型</td><td><?php echo ($event['category']); ?> <?php echo ($event['sub_category']); ?></td>
        </tr>
        <tr>
          <td>简介</td><td><?php echo ($event['short_description']); ?></td>
        </tr>
      </table>
    </div>
    <div class="span12">
      <hr>
      <h2 class="center">立即加入</h2>  
      <hr>
      <div class="row">
        <img src="__PUBLIC__/qrcode/<?php echo ($event['EventQrcode']['name']); ?>" alt="" class="span4 offset4">
      </div>
    </div>
  </div>
</div>

    <div id="push"></div>
  </div>
  
  <div class='notifications center'></div>
<script type="text/javascript" src="__PUBLIC__/js/bootstrap.js"></script>
<script src="__PUBLIC__/js/bootstrap-notify.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/base.js"></script>

  
</body>
</html>