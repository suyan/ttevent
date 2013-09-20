<?php 
class EventCommentAction extends CommonAction{
  public function commentEvent(){
    $user_id = session(C('USER_AUTH_KEY'));
    $event_id = $this->_param('event_id','intval');
    $content = $this->_param('content');
    if(!$content){
      $this->error('请填写评论内容');
    }
    if(D('Event')->isEventEnableComment($event_id) && D('EventComment')->commentEvent($user_id,$event_id,$content)){
      $this->success('评论成功');
    }else{
      $this->error("评论失败"); 
    }
  }

  public function showEventComments(){
    $this->data =array(
      'event_id'=>$this->_param('id'),
      ); 
    $this->show('{:W("Comment",$data)}');
  }

}