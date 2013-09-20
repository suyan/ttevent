<?php 
//定义项目名称
define('APP_NAME', 'Api');
//开启DEBUG
define('APP_DEBUG',TRUE);
//定义项目路径，必须以/结束
define('APP_PATH', './Api/');
//导入入口文件
define('ENGINE_NAME','cluster');
require './ThinkPHP/ThinkPHP.php';