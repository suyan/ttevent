<?php 
class EventFollowAction extends CommonAction{

  public function follow(){
    $user = $this->user;
    $user_id = $user['id'];
    $event_id = $this->_param('event_id','intval');
    if(!$event_id)
      $this->error(10005);
    $ef = D('Tiantian://EventFollow');
    if(D('Tiantian://Event')->isEventEnableFollow($event_id) && $ef->followEvent($user_id,$event_id)){
      $this->success(array());
    }else{
      $this->error(10000);  
    }
  }

  public function unfollow(){
    $user = $this->user;
    $user_id = $user['id'];
    $event_id = $this->_param('event_id','intval');
    if(!$event_id)
      $this->error(10005);
    $ef = D('Tiantian://EventFollow');
    if(D('Tiantian://Event')->isEventEnableFollow($event_id) && $ef->unfollowEvent($user_id,$event_id)){
      $this->success(array());
    }else{
      $this->error(10000); 
    }
  }

}