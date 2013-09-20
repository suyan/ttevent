<?php 
class EventFeedAction extends CommonAction{

  public function feed(){
    $event_id = intval($this->_param('id'));
    $feeds = D('EventFeed')->getNewestFeeds($event_id,10);
    $this->event_id = $event_id;
    $this->data = array(
      'event'=>true,
      'feeds'=>$feeds
      );
    $this->display();
  }

  public function getFeed(){
    $feed_id = intval($this->_param('feed_id'));
    $event_id = intval($this->_param('event_id'));
    $feeds = D('EventFeed')->getFeedsById($event_id,$feed_id,10);
    $this->data = array(
      'event'=>true,
      'feeds'=>$feeds
      );
    if($feeds)
      $this->show('{:W("feed",$data)}');
    else
      $this->show("false");
  }

  public function addFeed(){
    $user_id = session(C('USER_AUTH_KEY'));
    $event_id = $this->_param('event_id','intval');
    $content = $this->_param('content');
    if(!$content){
      $this->error('请填写动态内容');
    }
    $content = json_encode(array('content'=>$content));
    if(D('EventFeed')->addFeed($user_id,$event_id,3,$content)){
      $this->success('发表成功');
    }
    $this->error('发表失败');
  }
}

