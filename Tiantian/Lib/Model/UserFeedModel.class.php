<?php 
class UserFeedModel extends Model{

  /**
   * 添加用户动态 
   * @param  type {1:活动更新}
   */
  public function addFeed($event_id,$from_id,$to_id,$type,$content){
    $this->add(array(
      'event_id'=>$event_id,
      'from_id'=>$from_id,
      'to_id'=>$to_id,
      'type'=>$type,
      'content'=>$content,
      'create_time'=>NOW_TIME
      ));
  }

  public function getFeedsById($to_id,$feed_id,$count=10){
    $feeds = $this->where(array('to_id'=>$to_id,'id'=>array('lt',$feed_id)))->order('create_time desc')->limit($count)->select();
    foreach($feeds as $key=>$feed){
      //获得event相关信息
      $Event = D('Event');
      $event = $Event->wrapEventInfo($Event->getEventInfo($feed['event_id']));
      //获得user相关信息
      $User = D('User');
      $from_user = $User->wrapUserInfo($User->getUserInfo($feed['user_id']));
      //内容筛选一下
      $feeds[$key]['event'] = $event;
      $feeds[$key]['user'] = $from_user;
      $feeds[$key]['create_time'] = date('m-d G:i',$feed['create_time']);
      unset($feeds[$key]['content']);
    }
    return $feeds;
  }

  public function getNewestFeeds($to_id,$count=10){
    $feeds = $this->where(array('to_id'=>$to_id))->order('create_time desc')->limit($count)->select();
    if($feeds){
      foreach($feeds as $key=>$feed){
        //获得event相关信息
        $Event = D('Event');
        $event = $Event->wrapEventInfo($Event->getEventInfo($feed['event_id']));
        //获得user相关信息
        $User = D('User');
        $from_user = $User->wrapUserInfo($User->getUserInfo($feed['user_id']));
        //内容筛选一下
        $feeds[$key]['event'] = $event;
        $feeds[$key]['user'] = $from_user;
        $feeds[$key]['create_time'] = date('m-d G:i',$feed['create_time']);
        unset($feeds[$key]['content']);
      }  
    }
    return $feeds;
  }

}

