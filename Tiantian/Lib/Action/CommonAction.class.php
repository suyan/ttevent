<?php
class CommonAction extends Action {

  protected $navbar = array();
  protected $bread = array();
  protected $nav_list = array();

  protected function _initialize() {
    //navbar 
    $this->navbar = array(
      array('首页',U('Public/index'),0),
      array('个人',U('User/index'),0),
      array('活动',U('Main/events'),0),
      );
    trace($_SESSION,'session');//DEBUG
    Vendor('ChromePhp.ChromePhp');//DEBUG
    if (!($user_id = session(C('USER_AUTH_KEY')))) {
      if(IS_AJAX) $this->error('请先登录');
      $this->redirect(C('USER_AUTH_GATEWAY'));
    }else{
      $data['id']=$user_id;
      $data['update_time']=NOW_TIME;
      D('User')->save($data);
    }
  }

  function _empty(){ 
    header("HTTP/1.0 404 Not Found");//使HTTP返回404状态码 
    $this->show("木有页面啦"); 
  } 
}