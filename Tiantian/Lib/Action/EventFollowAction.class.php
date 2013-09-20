<?php 
class EventFollowAction extends CommonAction{
  public function followEvent(){
    $user_id = session(C('USER_AUTH_KEY'));
    $event_id = $this->_param('id','intval');
    if(!$user_id){
      $this->error('请先登录');
    }
    $ef = D('EventFollow');
    if(D('Event')->isEventEnableFollow($event_id) && $ef->followEvent($user_id,$event_id)){
        $this->success('关注成功');
    }else{
      $this->error("关注失败");  
    }
    
  }
  public function unfollowEvent(){
    $user_id = session(C('USER_AUTH_KEY'));
    $event_id = $this->_param('id','intval');
    if(!$user_id){
      $this->error('请先登录');
    }
    $ef = D('EventFollow');
    if(D('Event')->isEventEnableFollow($event_id) && $ef->unfollowEvent($user_id,$event_id)){
      $this->success('取消关注成功');
    }else{
      $this->error("取消关注失败"); 
    }
  }
}