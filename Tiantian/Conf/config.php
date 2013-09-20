<?php
return array(
  'DEFAULT_MODULE'      => 'Main', //默认模块
  'URL_MODEL'           => '2', //URL模式
  
  //数据库配置
  'DB_TYPE'             => 'mysql', // 数据库类型
  'DB_HOST'             => 'localhost', // 服务器地址
  'DB_NAME'             => 'tiantian', // 数据库名
  'DB_USER'             => 'root', // 用户名
  'DB_PWD'              => '', // 密码
  'DB_PORT'             => 3306, // 端口
  'DB_PREFIX'           => 'tt_', // 数据库表前缀
  
  'USER_AUTH_KEY'       =>  'uid',
  'USER_AUTH_GATEWAY'   =>  'Public/login',
  
  'SHOW_PAGE_TRACE'     =>  true,

  'SESSION_OPTIONS'     => array(
             'name' => 'tiantian',
             'expire' => 90*24*60*60,
             ),
  'SESSION_TYPE'       => 'db',
  'SESSION_AUTO_START' => true, //是否开启session

  'SITE_NAME'=>"天天活动",

  'TMPL_ACTION_ERROR' => 'Public:jump',
  'TMPL_ACTION_SUCCESS' => 'Public:jump',
  'PUBLIC_PATH'=>'./Public',
  'UPLOAD_PATH'=>'./Public/upload',
  'TEMP_PATH'=>'./Public/temp',
  'AVATAR_PATH'=>'./Public/avatar',
  'QRCODE_PATH'=>'./Public/qrcode',
  'IMAGE_PATH'=>'./Public/image',

  'DEFAULT_FILTER'=>'htmlspecialchars,strip_tags',
  'URL_HTML_SUFFIX'=>''
  );
?>