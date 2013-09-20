<?php
return array(
  'DEFAULT_MODULE'      => 'Public', //默认模块
  'URL_MODEL'           => '2', //URL模式
  'DEFAULT_APP'         => 'Tiantian',
  
  //数据库配置
  'DB_TYPE'             => 'mysql', // 数据库类型
  'DB_HOST'             => 'localhost', // 服务器地址
  'DB_NAME'             => 'tiantian', // 数据库名
  'DB_USER'             => 'root', // 用户名
  'DB_PWD'              => '', // 密码
  'DB_PORT'             => 3306, // 端口
  'DB_PREFIX'           => 'tt_', // 数据库表前缀
  
  //导入额外配置
  'LOAD_EXT_CONFIG' => array(
    'ERROR'=>'error_msg'
    ),

  'SITE_NAME'=>"天天活动",
  );
?>