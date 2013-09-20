<?php
class EventModel extends RelationModel{
  protected $_link = array(
    'EventTag' => array(
      'mapping_type' => MANY_TO_MANY,
      'class_name' => 'EventTag',
      'foreign_key'=>'event_id',
      'relation_foreign_key'=>'tag_id',
      'relation_table' => 'tt_event_event_tag',
      ),
    'EventQrcode' => array(
      'mapping_type' => HAS_ONE,
      'class_name' => 'EventQrcode',
      'foreign_key'=>'event_id',
      ),
    );

  public function getLatestEventIds($count=10,$limit=0){
    return $this->cache(true,60)->field('id')->where(array('end_time'=>array('gt',NOW_TIME),'status'=>array('gt',1)))->order('start_time desc')->limit($limit,$count)->select();
  }

  public function getHotestEventIds($count=10,$limit=0){
    return $this->cache(true,60)->field('id')->where(array('status'=>array('gt',1)))->order('join_count desc,follow_count desc')->limit($limit,$count)->select();
  }

  public function wrapEventInfoForMobile($event){
    $User = D('User');
    $user = $User->wrapUserInfo($User->getUserInfo($event['user_id']));
    $event['user']=$user;
    $schedule = json_decode($event['schedule'],true);
    $event['schedule'] = $schedule?$schedule:array();

    $Image = D('Image');
    $event['large_img'] = $Image->getImageUrl($event['large_img']);
    $event['middle_img'] = $Image->getImageUrl($event['middle_img']);
    $event['small_img'] = $Image->getImageUrl($event['small_img']);
    
    $location = D('Region')->getLocationById($event['province_id'],$event['city_id'],$event['area_id']);
    $event['province'] = $location['province']['name'];
    $event['city'] = $location['city']['name'];
    $event['area'] = $location['area']['name'];
    $event['description'] = strip_tags(html_entity_decode($event['description']));
    $event['description'] = (mb_strlen($event['description'],'utf-8')>100)?mb_substr($event['description'],0,100,'utf-8').'...':$event['name'];
    return $event;
  }

  public function wrapEventInfo($event){
    import('ORG.Util.String');
    $User = D('User');
    $user = $User->wrapUserInfo($User->getUserInfo($event['user_id']));
    $event['user']=$user;
    //判断活动当前状态
    if($event['status'] > 0){
      if(NOW_TIME<$event['start_time']) $event['status'] = 1;
      else if(NOW_TIME>$event['end_time']) $event['status'] = 3;
      else $event['status'] = 2;
    }
    $event['create_time']=$event['create_time']?date('Y-m-d G:i',$event['create_time']):'未知';
    $event['update_time']=$event['update_time']?date('Y-m-d G:i',$event['update_time']):'未知';

    $Image = D('Image');
    $event['large_img'] = $Image->getImageUrl($event['large_img']);
    $event['middle_img'] = $Image->getImageUrl($event['middle_img']);
    $event['small_img'] = $Image->getImageUrl($event['small_img']);
    $event['start_time']=$event['start_time']?date('Y-m-d G:i',$event['start_time']):'未知';
    $event['end_time']=$event['end_time']?date('Y-m-d G:i',$event['end_time']):'未知';
    $location = D('Region')->getLocationById($event['province_id'],$event['city_id'],$event['area_id']);
    $event['province'] = $location['province']['name']?$location['province']['name']:'';
    $event['city'] = $location['city']['name']?$location['city']['name']:'';
    $event['area'] = $location['area']['name']?$location['area']['name']:'';
    $event['short_description'] = strip_tags(html_entity_decode($event['description']));
    $event['short_description'] = (mb_strlen($event['short_description'],'utf-8')>100)?mb_substr($event['short_description'],0,100,'utf-8').'...':$event['name'];
    $event['category'] = D('EventCategory')->getCategoryName($event['category_id']);
    $event['sub_category'] = D('EventCategory')->getCategoryName($event['sub_category_id']);

    return $event;
  }

  public function isEventEnableFollow($event_id){
    $status = $this->where(array('id'=>$event_id))->getField('status');
    if($status > 1)
      return true;
    return false;
  }

  public function isEventEnableJoin($event_id){
    $status = $this->where(array('id'=>$event_id))->getField('status');
    if($status > 1)
      return true;
    return false;
  }

  public function isEventEnableComment($event_id){
    $status = $this->where(array('id'=>$event_id))->getField('status');
    if($status >1)
      return true;
    return false; 
  }

  public function isCreater($event_id,$user_id){
    return $this->where(array('id'=>$event_id,'user_id'=>$user_id))->find();
  }

  public function isEventEnabled($event_id){
    $event = $this->find($event_id);
    if(!$event || $event['status'] == 0 )
      return false;
    return true;
  }

  /**
   * 根据传入参数创建活动
   * status
   */
  public function createEvent($data,$relation = false){
    $data['create_time']=NOW_TIME;
    $data['update_time']=NOW_TIME;
    $id = $this->relation($relation)->add($data);
    if($id){//创建成功则追加一条数据
      D('User')->incUserEventCount($data['user_id']);
      D('Setting')->incKey('event_count');
      D('EventFeed')->addFeed($data['user_id'],$id,1,json_encode($data));
      return $id;
    }
    return false;
  }

  /**
   * 根据传入的参数来进行更新，但是更新时id必须
   */
  public function updateEvent($data,$relation=false){
    if(!isset($data['id']))
      return false;
    $event_src = $this->getEventInfo($data['id']);
    $data['update_time'] = NOW_TIME;
    $ret = $this->relation($relation)->save($data);
    if($ret){
      //更新分类数据
      if(isset($data['category_id']) && ($data['category_id']!=$event_src['category_id'])){
        D('EventCategory')->incCategoryCount($data['category_id']);
        if($event_src['category_id'])
          D('EventCategory')->decCategoryCount($event_src['category_id']);
      }
      if(isset($data['sub_category_id']) && ($data['sub_category_id']!=$event_src['sub_category_id'])){
        D('EventCategory')->incCategoryCount($data['sub_category_id']);
        if($event_src['sub_category_id'])
          D('EventCategory')->decCategoryCount($event_src['sub_category_id']);
      }

      //更新地点数据
      if(isset($data['province_id']) && ($data['province_id'] != $event_src['province_id'])){
        D('Region')->incRegionCount($data['province_id']);
        if($event_src['province_id'])
          D('Region')->decRegionCount($data['province_id']);
      }
      if(isset($data['city_id']) && ($data['city_id'] != $event_src['city_id'])){
        D('Region')->incRegionCount($data['city_id']);
        if($event_src['city_id'])
          D('Region')->decRegionCount($data['city_id']);
      }
      if(isset($data['area']) && ($data['area'] != $event_src['area'])){
        D('Region')->incRegionCount($data['area']);
        if($event_src['area'])
          D('Region')->decRegionCount($data['area']);
      }

      $content = json_encode($data);
      D('EventFeed')->addFeed($data['user_id'],$data['id'],2,$content);//增加一条活动动态
      //给关注了此活动的用户增加动态
      $follows = D('EventFollow')->getEventFollows($data['id']);
      foreach($follows as $follow){
        D('UserFeed')->addFeed($data['id'],$data['user_id'],$follow['user_id'],1,$content);
      }
      return $ret;
    }
    return false;
  }

  public function deleteEvent($event_id){
    //获得活动详细信息
    $event = D('Event')->getEventInfo($event_id);
    if(!$event) return false;
    //删除活动时只将状态变为0即可
    $event['status'] = 0;
    if($this->save($event)){
      D('User')->decUserEventCount($event['user_id']);
      //删除相关动态
      D('EventFeed')->deleteEventFeeds($event_id);
      //删除相关评论
      D('EventComment')->deleteEventComments($event_id);
      //删除所有跟随的人
      D('EventFollow')->deleteEventFollows($event_id);
      //删除所有参加的人
      D('EventJoin')->deleteEventJoins($event_id);
      //减少分类数量
      if($event['category_id']) D('EventCategory')->decCategoryCount($event['category_id']);
      if($event['sub_category_id']) D('EventCategory')->decCategoryCount($event['sub_category_id']);
      if($event['province_id']) D('Region')->decRegionCount($event['province_id']);
      if($event['city_id']) D('Region')->decRegionCount($event['city_id']);
      if($event['area_id']) D('Region')->decRegionCount($event['area_id']);

      D('Setting')->decKey('event_count');

      return true;
    }
    return false;
  }

  public function getEventInfo($event_id,$relation=false){
    return $this->relation($relation)->find($event_id);
  }

  public function getUserEventCount($user_id){
    return $this->where(array('user_id'=>$user_id,'status'=>array('gt',1)))->count();
  }

  public function getUserEvents($user_id,$limit=0,$count=5){
    return $this->relation(true)
                ->where(array('user_id'=>$user_id,'status'=>array('gt',1)))
                ->order('create_time desc')
                ->limit($limit,$count)
                ->select();
  }

  public function getUserEventIds($user_id,$limit=0,$count=5){
    return $this->where(array('user_id'=>$user_id,'status'=>array('gt',0)))->field('id')->order('create_time desc')->limit($limit,$count)->select();
  }

  public function getUserEventIdsByTime($user_id,$count=5,$start_time=99999999999){
    return $this->where(array('user_id'=>$user_id,'start_time'=>array('lt',$start_time),'status'=>array('gt',0)))->field('id')->order('start_time desc')->limit($count)->select();
  }

  public function getCategoryEventIds($category_id,$limit=0,$count=5){
    return $this->where(array('category_id'=>$category_id,'status'=>array('gt',1)))->field('id')->limit($limit,$count)->select();
  }

  public function getListEventCount($category_id,$time){
    if($time == 'all')
      return $this->where(array('category_id'=>$category_id))->count();
    else if($time == 'today'){
      $today = strtotime(date('Y-m-d',NOW_TIME));
      $tomorrow = strtotime(date('Y-m-d',NOW_TIME).'+1 day');
      return $this->where(
        array(
          'category_id'=>$category_id,
          'start_time'=>array(array('gt',$today),array('lt',$tomorrow)),
          'status'=>array('gt',1)
          )
        )->count();
    }else if($time == 'tomorrow'){
      $tomorrow = strtotime(date('Y-m-d',NOW_TIME).'+1 day');
      $after_tomorrow = strtotime(date('Y-m-d',NOW_TIME).'+2 day');
      return $this->where(
        array(
          'category_id'=>$category_id,
          'start_time'=>array(array('gt',$tomorrow),array('lt',$after_tomorrow)),
          'status'=>array('gt',1)
          )
        )->count();
    }else if($time == 'week'){
      $today = strtotime(date('Y-m-d',NOW_TIME));
      $week = strtotime(date('Y-m-d',NOW_TIME).'+7 day');
      return $this->where(
        array(
          'category_id'=>$category_id,
          'start_time'=>array(array('gt',$today),array('lt',$week)),
          'status'=>array('gt',1)
          )
        )->count();
    }
  }

  public function getListEventIds($category_id,$time,$limit=0,$count=10){
    if($time == 'all')
      return $this->where(array('category_id'=>$category_id,'status'=>array('gt',1)))->field('id')->limit($limit,$count)->select();
    else if($time == 'today'){
      $today = strtotime(date('Y-m-d',NOW_TIME));
      $tomorrow = strtotime(date('Y-m-d',NOW_TIME).'+1 day');
      return $this->where(
        array(
          'category_id'=>$category_id,
          'start_time'=>array(array('gt',$today),array('lt',$tomorrow)),
          'status'=>array('gt',1)
          )
        )->field('id')->limit($limit,$count)->select();
    }else if($time == 'tomorrow'){
      $tomorrow = strtotime(date('Y-m-d',NOW_TIME).'+1 day');
      $after_tomorrow = strtotime(date('Y-m-d',NOW_TIME).'+2 day');
      return $this->where(
        array(
          'category_id'=>$category_id,
          'start_time'=>array(array('gt',$tomorrow),array('lt',$after_tomorrow)),
          'status'=>array('gt',1)
          )
        )->field('id')->limit($limit,$count)->select();
    }else if($time == 'week'){
      $today = strtotime(date('Y-m-d',NOW_TIME));
      $week = strtotime(date('Y-m-d',NOW_TIME).'+7 day');
      return $this->where(
        array(
          'category_id'=>$category_id,
          'start_time'=>array(array('gt',$today),array('lt',$week)),
          'status'=>array('gt',1)
          )
        )->field('id')->limit($limit,$count)->select();
    } 
  }

  public function getSearchCount($q){
    return $this->where(array('name'=>array('like',"%{$q}%")))->count();
  }

  public function getSearchIds($q,$limit=0,$count=10){
    return $this->where(array('name'=>array('like',"%{$q}%")))->limit($limit,$count)->select();
  }

  public function getEventImgs($event_id){
    return $this->where(array('id'=>$event_id))
                ->field('src_img,large_img,middle_img,small_img')->find();
  }

  public function getEventStatus($event_id){
    return $this->where(array('id'=>$event_id))->getField('status');
  }

  public function getEventType($event_id){
    return $this->where(array('id'=>$event_id))->getField('type');
  }
}