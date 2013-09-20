<?php 
class EventAction extends CommonAction{
  public function getUserManageEvents(){
    $user = $this->user;
    $user_id = $user['id'];
    $count = $this->_param('count','intval',10);
    $start_time = $this->_param('start_time','intval',99999999999);
    $Event = D('Tiantian://Event');
    $data = array(
      'event_count'=>$user['event_count'],
      );
    if($user['event_count'] && $events = $Event->getUserEventIdsByTime($user_id,$count,$start_time)){
      foreach($events as $key=>$value){
        $events[$key] = $Event->wrapEventInfoForMobile($Event->getEventInfo($value['id']));
      }
    }else{
      $events=array();
    }
    $data['count']=count($events);
    $data['events']=$events;
    $this->success($data);
  }

  public function getUserJoinEvents(){
    $user = $this->user;
    $user_id = $user['id'];
    $count = $this->_param('count','intval',10);
    $start_time = $this->_param('start_time','intval',99999999999);
    $EventJoin = D('Tiantian://EventJoin');
    $Event = D('Tiantian://Event');
    $data = array(
      'event_join'=>$user['event_join'],
      );
    if($user['event_join'] && $events = $EventJoin->getUserJoinEventIdsByTime($user_id,$count,$start_time)){
      foreach($events as $key=>$value){
        $events[$key] = $Event->wrapEventInfoForMobile($Event->getEventInfo($value['id']));
      }
    }else{
      $events=array();
    }
    $data['count']=count($events);
    $data['events']=$events;
    $this->success($data);
  }

  public function getUserFollowEvents(){
    $user = $this->user;
    $user_id = $user['id'];
    $count = $this->_param('count','intval',10);
    $start_time = $this->_param('start_time','intval',99999999999);
    $EventFollow = D('Tiantian://EventFollow');
    $Event = D('Tiantian://Event');
    $data = array(
      'event_follow'=>$user['event_follow'],
      );
    if($user['event_follow'] && $events = $EventFollow->getUserFollowEventIdsByTime($user_id,$count,$start_time)){
      foreach($events as $key=>$value){
        $events[$key] = $Event->wrapEventInfoForMobile($Event->getEventInfo($value['id']));
      }
    }else{
      $events=array();
    }
    $data['count']=count($events);
    $data['events']=$events;
    $this->success($data);
  }
}

