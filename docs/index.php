<!DOCTYPE html>
<html>
<head>
  <title>天天文档</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="./core/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="./core/css/docs.css">
</head>
<body data-spy="scroll" date-target="#main">
  <div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
      <div class="container">
        <a class="brand" href="<?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; ?>">天天文档</a>
        <div class="nav-collapse collapse">
          <ul id='top_nav' class="nav">
            <?php 
              //选择md文件位置
              $topic = isset($_GET['topic'])?$_GET['topic']:'';
              $mdfile = isset($_GET['mdfile'])?$_GET['mdfile']:'';
              //检查现有文件
              $current = opendir(dirname(__FILE__));
              $files = array();//获得所有的md文件
              //获得所有目录
              
              while(($dir = readdir($current)) !== false){
                if( is_dir($dir) && $dir != '..' && $dir != '.' && $dir != 'core' && $dir != 'uploads'){
                  echo "<li class='dropdown'>";
                  $files[$dir] = array();
                  $item = opendir($dir);
                  $show_dir = iconv('','UTF-8//IGNORE',$dir);
                  if($show_dir != $dir) $show_dir = $dir;
                  echo "<a href='#' class='dropdown-toggle' data-toggle='dropdown'>$show_dir<b class='caret'></b></a>";
                  echo "<ul class='dropdown-menu'>";
                  while(($file = readdir($item))!== false){
                    if(preg_match('/(.*)\.md$/i',$file,$name)){
                      $files[$dir][$name[1]] = $name[0];
                      $show_name = iconv('','UTF-8',$name[1]);
                      if($show_name != $name[1]) $show_name = $name[1];
                      $show_topic = urlencode($dir);
                      $show_file = urlencode($name[0]);
                      echo "<li><a href='?topic=$show_topic&mdfile=$show_file'>$show_name</a></li>";
                    }   
                  }
                  closedir($item);
                  echo '</ul>';
                  echo '</li>';
                }
              }
              closedir($current);
            ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row" >
      <div class="span3" id="main">
        <ul id="dst_nav" class="nav nav-pills nav-stacked span3" data-spy="affix" data-offset-top="40">
        </ul>
      </div>
      <div class="span9">
        <?php 
          include './core/php/markdown.php';
          if($topic && $mdfile)
            echo Markdown(file_get_contents($topic.'/'.$mdfile));
          else
            echo Markdown(file_get_contents('example.md'));
        ?>
      </div>  
    </div>
  </div>
  <script type="text/javascript" src="./core/js/jquery.js"></script>
  <script type="text/javascript" src="./core/js/bootstrap.js"></script>
  <script type="text/javascript">
    //从中导出nav
    $(function(){
      var nav = $('#nav').html();
      $('#nav').html('');
      $('#dst_nav').html(nav);
    });
  </script>
</body>
</html>
