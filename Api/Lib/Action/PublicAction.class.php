<?php 
class PublicAction extends ApiAction{

  public function login(){
    $key = $this->_param('key');
    if(!$key)//确保key存在
      $this->error(10001);
    $key = explode(':',base64_decode($key));

    if(!isset($key[0]) || !isset($key[1]) || !$key[0] || !$key[1])//确保账号密码提交
      $this->error(10001);

    $User = D('Tiantian://User');//验证用户
    $user_data = $User->checkUser($key[0],md5($key[1]),true);
    if(!$user_data){
      $this->error(10001);
    }
    $user_data = $User->wrapUserInfoForMobile($user_data);
    $user_id = $user_data['id'];
    $user_token = $User->userLogin($user_id);
    if($user_token)
      $this->success(array('token'=>$user_token,'user'=>$user_data));
    $this->error(10000);
  }

  public function getHotestEvents(){
    $count = $this->_param('count','intval',10);
    $Event = D('Tiantian://Event');
    $events = $Event->getHotestEventIds($count);
    foreach($events as $key=>$value){
      $events[$key] = $Event->wrapEventInfoForMobile($Event->getEventInfo($value['id']));
    }
    $this->success(array('events'=>$events));
  }

  public function getEventInfo(){
    $event_id = $this->_param('id');
    if(!$event_id) $this->error(10005);
    $token = $this->_param('token','',0);
    $Event = D('Tiantian://Event');
    $ret = $Event->wrapEventInfoForMobile($Event->getEventInfo($event_id));
    if($token && $user = D('Tiantian://User')->checkUserByToken($token)){//查看用户
      $ret['is_joined'] = D('Tiantian://EventJoin')->isJoined($user['id'],$event_id);
      $ret['is_follow'] = D('Tiantian://EventFollow')->isFollowed($user['id'],$event_id);
    }
    $this->success(array('event'=>$ret));
  }

}