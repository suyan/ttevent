<?php
class UserAction extends CommonAction {

  protected function _initialize(){
    parent::_initialize();
    $this->bread = array(
      array('首页',U('Public/index'),0),
      array('个人',U('User/feed'),0),
      array('个人动态',U('User/feed'),0)
      );
    $this->nav_list = array(
      '个人'=>array(
        array('动态',U('User/feed'),0),
        // array('页面',U('User/userPage',array('id'=>session(C('USER_AUTH_KEY')))),0),
        array('消息',U('User/myNotification'),0),
        ),
      '活动'=>array(
        array('活动',U('User/myEvent'),0),
        ),
      );
    $this->navbar[1][2] = true;
  }

  public function index(){
    $this->redirect('feed');
  }

  public function myNotification(){
    $this->title = "消息";
    $this->bread[2] = array('消息',U('User/myNotification'),1);
    $this->nav_list['个人'][1][2] = 1;
    $this->assign(array('navbar'=>$this->navbar,'bread'=>$this->bread,'nav_list'=>$this->nav_list));
    D('UserNotification')->readAllNotifications(session(C('USER_AUTH_KEY')));
    $this->display();
  }

  public function feed(){
    $this->title = "动态";
    $this->bread[2][2] = 1;
    $this->nav_list['个人'][0][2] = 1;
    $this->assign(array('navbar'=>$this->navbar,'bread'=>$this->bread,'nav_list'=>$this->nav_list));
    $user_id = session(C('USER_AUTH_KEY'));
    $feeds = D('UserFeed')->getNewestFeeds($user_id,10);
    $this->data = array(
      'user'=>true,
      'feeds'=>$feeds
      );
    $this->display();
  }

  public function getFeed(){
    $feed_id = intval($this->_param('id'));
    $user_id = session(C('USER_AUTH_KEY'));
    $feeds = D('UserFeed')->getFeedsById($user_id,$feed_id,10);
    $this->data = array(
      'user'=>true,
      'feeds'=>$feeds
      );
    if($feeds)
      $this->show('{:W("feed",$data)}');
    else
      $this->show("false");
  }

  public function userPage(){
    $this->title = "个人首页";
    $id = $this->_param('id','intval');
    $User = D('User');
    $user = $User->wrapUserInfo($User->getUserInfo($id));
    if(!$user){
      $this->error('此用户不存在');
    }
    $this->bread[2] = array($user['nickname'],'',1);
    $this->assign(array('navbar'=>$this->navbar,'bread'=>$this->bread,'nav_list'=>$this->nav_list));
    $this->user_id = session(C('USER_AUTH_KEY'));
    if($this->user_id != $user['id']){
      $this->enable_follow = true;
      $user['is_followed'] = D('UserFollow')->isFollowed($this->user_id,$id);
    }else{
      $this->enable_follow = false;
    }
    $this->user = $user;
    $this->display();
  }

  public function myEvent(){
    $this->bread[2] = array('活动',U('User/myEvent'),1);
    $this->nav_list['活动'][0][2] = 1;
    $this->assign(array('navbar'=>$this->navbar,'bread'=>$this->bread,'nav_list'=>$this->nav_list));
    $this->title = "我的活动";
    $this->display();
  }
}