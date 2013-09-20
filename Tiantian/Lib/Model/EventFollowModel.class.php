<?php 
class EventFollowModel extends Model{
  public function isFollowed($user_id,$event_id){
    $follow = $this->where(array(
      'user_id'=>$user_id,
      'event_id'=>$event_id
      ))->find();
    if(!$follow || $follow['status']==0)
      return false;
    return true;
  }

  /**
   * status 
   * 0:未关注
   * 1:已关注
   */
  public function followEvent($user_id,$event_id){
    $follow = $this->where(array('user_id'=>$user_id,'event_id'=>$event_id))->find();
    if($follow){//已有此人数据
      if($follow['status']!=0)
        return false;
      $follow['create_time']=NOW_TIME;
      $follow['status'] = 1;
      $id = $this->save($follow);
    }else{//第一次加入
      $id = $this->add(array(
        'user_id'=>$user_id,
        'event_id'=>$event_id,
        'create_time'=>NOW_TIME,
        'status'=>1
        ));
    }
    if($id){
      D('Event')->save(array(
        'id'=>$event_id,
        'follow_count'=>array('exp','follow_count+1'),
        ));
      D('User')->save(array(
        'id'=>$user_id,
        'event_follow'=>array('exp','event_follow+1'),
        ));
    }
    return $id;
  }

  public function unfollowEvent($user_id,$event_id){
    $id = $this->where(array(
      'user_id'=>$user_id,
      'event_id'=>$event_id
      ))->save(array(
        'status'=>0
      ));
    if($id){
      D('Event')->save(array(
        'id'=>$event_id,
        'follow_count'=>array('exp','follow_count-1'),
        ));
      D('User')->save(array(
        'id'=>$user_id,
        'event_follow'=>array('exp','event_follow-1'),
        ));
    }
    return $id;
  }

  public function getEventFollows($event_id){
    return $this->where(array('event_id'=>$event_id,'status'=>array('gt',0)))->select();
  }

  public function getUserFollowEventsCount($user_id){
    return $this->where(array('user_id'=>$user_id,'status'=>array('gt',0)))->count();
  }

  public function getUserFollowEventIds($user_id,$limit=0,$count=10){
    return $this->where(array('user_id'=>$user_id,'status'=>array('gt',0)))->field('event_id')->limit($limit,$count)->select();
  }

  public function getUserFollowEventIdsByTime($user_id,$count=10,$create_time=99999999999){
    return $this->where(array('user_id'=>$user_id,'create_time'=>array('lt',$create_time),'status'=>array('gt',0)))->field('event_id')->limit($count)->select();
  }

  public function deleteEventFollows($event_id){
    $follows = $this->getEventFollows($event_id);
    if($follows)
      foreach($follows as $follow){
        $this->unfollowEvent($follow['user_id'],$event_id);
      }
    return true;
  }
}
