<?php 
class EventJoinAction extends CommonAction{
  public function join(){
    $user = $this->user;
    $user_id = $user['id'];
    $event_id = $this->_param('event_id','intval');
    $real_name = $this->_param('real_name');
    $event_email = $this->_param('event_email');
    $mobile = $this->_param('mobile');
    if(!$event_id || !$real_name || !$event_email || !$mobile)
      $this->error(10005);
    $data = array(
      'user_id' => $user_id,
      'event_id' => $event_id,
      'real_name' => $real_name,
      'event_email' => $event_email,
      'mobile' => $mobile
      );
    $ret = D('Tiantian://EventJoin')->joinEvent($data);
    if($ret)
      $this->success(array());
    else
      $this->error(10000);
  }

  public function unjoin(){
    $user = $this->user;
    $user_id = $user['id'];
    $event_id = $this->_param('event_id','intval');
    if(!$event_id)
      $this->error(10005);
    $ej = D('Tiantian://EventJoin');
    if(D('Tiantian://Event')->isEventEnableJoin($event_id) && $ej->unjoinEvent($user_id,$event_id)){
      $this->success(array());
    }else{
      $this->error(10000); 
    }
  }
}
