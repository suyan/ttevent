<?php 
class EventJoinModel extends Model{

  /**
   * status 
   * 0: 活动已经被删除
   * 1: 活动还未创建完成
   * 2: 活动快要开始
   * 3: 活动正在进行
   * 4: 活动已经完成
   */
  public function isJoined($user_id,$event_id){
    $join = $this->where(array(
      'user_id'=>$user_id,
      'event_id'=>$event_id
      ))->find();
    if(!$join)
      return false;
    if($join['status']==1 || $join['status'] == 3 || $join['status'] == 4)
      return true;
    return false;
  }

  /**
   * status 
   * 0:未加入
   * 1:已经加入
   * 2:申请加入
   * 3:被拒绝加入
   */
  public function joinEvent($data){
    $join = $this->where(array('user_id'=>$data['user_id'],'event_id'=>$data['event_id']))->find();
    if($join){//已经有此人的数据
      if($join['status']!=0)
        return false;
      foreach($data as $key=>$value){
        $join[$key]=$value;
      }
      $join['create_time'] = NOW_TIME;
      $join['status'] = 1;
      $id = $this->save($join);  
    }else{//没有此人数据，第一次加入
      $data['create_time'] = NOW_TIME;
      $data['status'] = 1;
      $id = $this->add($data);
    }
    if($id){
      D('Event')->save(array(
        'id'=>$data['event_id'],
        'join_count'=>array('exp','join_count+1'),
        ));
      D('User')->save(array(
        'id'=>$data['user_id'],
        'event_join'=>array('exp','event_join+1'),
        ));
    }
    return $id;
  }

  public function unjoinEvent($user_id,$event_id){
    $id = $this->where(array(
      'user_id'=>$user_id,
      'event_id'=>$event_id,
      ))->save(array(
      'status'=>0
      ));
    if($id){
      D('Event')->save(array(
        'id'=>$event_id,
        'join_count'=>array('exp','join_count-1'),
        ));
      D('User')->save(array(
        'id'=>$user_id,
        'event_join'=>array('exp','event_join-1'),
        ));
    }
    return $id;
  }

  public function getEventJoins($event_id){
    return $this->where(array('event_id'=>$event_id,'status'=>array('gt',0)))->select();
  }

  public function getUserJoinEventsCount($user_id){
    return $this->where(array('user_id'=>$user_id,'status'=>array('gt',0)))->count();
  }

  public function getUserJoinEventIds($user_id,$limit=0,$count=10){
    return $this->where(array('user_id'=>$user_id,'status'=>array('gt',0)))->field('event_id')->limit($limit,$count)->select();
  }

  public function getUserJoinEventIdsByTime($user_id,$count=10,$start_time=99999999999){
    return $this->where(array('user_id'=>$user_id,'start_time'=>array('lt',$start_time),'status'=>array('gt',0)))->field('event_id')->limit($count)->select();
  }

  public function deleteEventJoins($event_id){
    $joins = $this->getEventJoins($event_id);
    if($joins)
      foreach($joins as $join){
        $this->unjoinEvent($join['user_id'],$event_id);
      }
    return true;
  }
}