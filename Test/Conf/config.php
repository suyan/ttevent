<?php
return array(
  'DEFAULT_MODULE'      => 'Index', //默认模块
  'URL_MODEL'           => '1', //URL模式
  'DEFAULT_APP'         => 'Tiantian',
  
  //数据库配置
  'DB_TYPE'             => 'mysql', // 数据库类型
  'DB_HOST'             => 'localhost', // 服务器地址
  'DB_NAME'             => 'tt_test', // 数据库名
  'DB_USER'             => 'root', // 用户名
  'DB_PWD'              => '', // 密码
  'DB_PORT'             => 3306, // 端口
  'DB_PREFIX'           => 'tt_', // 数据库表前缀
  
  //RBAC配置
  'USER_AUTH_ON'        =>  true,
  'USER_AUTH_TYPE'      =>  2,
  'USER_AUTH_KEY'       =>  'authId',
  'REQUIRE_AUTH_MODULE' =>  '',     // 默认需要认证模块
  'NOT_AUTH_ACTION'     =>  '',     // 默认无需认证操作
  'REQUIRE_AUTH_ACTION' =>  '',     // 默认需要认证操作
  'USER_AUTH_GATEWAY'   =>  'Public/login',
  'RBAC_ROLE_TABLE'     =>  'tt_role',
  'RBAC_USER_TABLE'     =>  'tt_role_user',
  'RBAC_ACCESS_TABLE'   =>  'tt_access',
  'RBAC_NODE_TABLE'     =>  'tt_node',
  
  'SHOW_PAGE_TRACE'     =>  true,

  'SESSION_OPTIONS'     => array(
             'name' => 'tiantian',
             'expire' => 90*24*60*60,
             ),
  'SESSION_TYPE'       => 'db',
  'SESSION_AUTO_START' => true, //是否开启session

  'SITE_NAME'=>"天天活动"
  );
?>
