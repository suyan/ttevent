<?php 
class FeedWidget extends Widget{
  public function render($data){
    if(isset($data['event']))
      return $this->renderFile('event_feed',array('feeds'=>$data['feeds']));
    else if(isset($data['user']))
      return $this->renderFile('user_feed',array('feeds'=>$data['feeds']));
  }
}