<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>提示</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="__PUBLIC__/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }
      .notice {
        max-width: 400px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="notice">
        <legend class="text-center">天天提示</legend>
        <?php if(isset($message)): ?><h1 class="text-success">：) </h1>
          <h2 class="text-success"><?php echo ($message); ?></h2>
        <?php else: ?>
          <h1 class="text-error">：( </h1>
          <h2 class="text-error"><?php echo ($error); ?></h2><?php endif; ?>
        页面自动 <a id="href" href="<?php echo ($jumpUrl); ?>">跳转</a> 等待时间： <b id="wait"><?php echo ($waitSecond); ?></b>
      </div>
    </div>
    <script type="text/javascript">
      (function(){
      var wait = document.getElementById('wait'),href = document.getElementById('href').href;
      var interval = setInterval(function(){
        var time = --wait.innerHTML;
        if(time <= 0) {
          location.href = href;
          clearInterval(interval);
        };
      }, 1000);
      })();
    </script>
  </body>
</html>