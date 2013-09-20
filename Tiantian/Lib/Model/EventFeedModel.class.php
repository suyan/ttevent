<?php 
class EventFeedModel extends Model{

  /**
   * 增加活动的动态，在活动状态变化时增加
   * @param type {1:'创建',2:'更新',3:'普通动态'}
   */
  public function addFeed($user_id,$event_id,$type,$content){
    return $this->add(array(
      'user_id'=>$user_id,
      'event_id'=>$event_id,
      'type'=>$type,
      'content'=>$content,
      'status'=>1,
      'create_time'=>NOW_TIME
      ));
  }

  public function deleteEventFeeds($event_id){
    $feed = array('status'=>0);
    return $this->where(array('event_id'=>$event_id))->save($feed);
  }

  public function getFeedsById($event_id,$feed_id,$count=10){
    $feeds = $this->where(array('event_id'=>$event_id,'id'=>array('lt',$feed_id)))->order('create_time desc')->limit($count)->select();
    foreach($feeds as $key=>$feed){
      //获得user相关信息
      $User = D('User');
      $from_user = $User->wrapUserInfo($User->getUserInfo($feed['user_id']));
      //内容筛选一下
      $feeds[$key]['user'] = $from_user;
      $feeds[$key]['show_create_time'] = date('m-d G:i',$feed['create_time']);
    }
    return $feeds;
  }

  public function getNewestFeeds($event_id,$count=10){
    $feeds = $this->where(array('event_id'=>$event_id))->order('create_time desc')->limit($count)->select();
    foreach($feeds as $key=>$feed){
      //获得user相关信息
      $User = D('User');
      $from_user = $User->wrapUserInfo($User->getUserInfo($feed['user_id']));
      //内容筛选一下
      $feeds[$key]['user'] = $from_user;
      $feeds[$key]['show_create_time'] = date('m-d G:i',$feed['create_time']);
    }
    return $feeds;
  }

}
