<?php 
class MainAction extends Action{

  protected $navbar = array();

  public function _initialize(){
    vendor('MobileDetect.Mobile_Detect');
    $mobile = new Mobile_Detect();
    if($mobile->isMobile()){
      $this->assign('mobile',true);
    }
    $this->navbar = array(
      array('首页',U('Public/index'),0),
      array('个人',U('User/index'),0),
      array('活动',U('Main/events'),0),
      );
  }
  
  public function index(){
    $this->assign('title','首页');
    $this->navbar[0][2] = 1;
    $this->assign('navbar',$this->navbar);
    //获得三页数据
    $Event = D('Event');
    $User = D('User');
    $Image = D('Image');
    import('ORG.Util.String');
    //即将进行的活动
    if(!$events = S('latest_event_ids')){
      $events = $Event->getLatestEventIds(9);
      if($events){
        foreach($events as $key=>$value){
          $events[$key] = $Event->wrapEventInfo($Event->getEventInfo($value['id']));
          $events[$key]['url'] = U('Main/event',array('id'=>$value['id']));
          $events[$key]['short_name'] = String::msubstr($events[$key]['name'],0,13);
        }
        S('latest_event_ids',$events,3600);
      }
    }
    $this->events = $events;
    //热门举办方
    if(!$hotest_creater = S('hotest_creater')){
      $hotest_creater = D('User')->getHotestCreater(5);
      if($hotest_creater){
        foreach($hotest_creater as $key=>$value){
          $hotest_creater[$key] = $User->wrapUserInfo($value);
          $hotest_creater[$key]['short_nickname']= String::msubstr($hotest_creater[$key]['nickname'],0,7);
        }  
        S('hotest_creater',$hotest_creater,3600);  
      }
    }
    $this->hotest_creater = $hotest_creater;
    //热门用户
    if(!$hotest_follower = S('hotest_follower')){
      $hotest_follower = D('User')->getHotestFollower(5);
      if($hotest_follower){
        foreach($hotest_follower as $key=>$value){
          $hotest_follower[$key] = $User->wrapUserInfo($value);
          $hotest_follower[$key]['short_nickname']= String::msubstr($hotest_follower[$key]['nickname'],0,7);
        }  
        S('hotest_follower',$hotest_follower,3600);  
      }
    }
    $this->hotest_follower = $hotest_follower;
    //热门活动
    if(!$events = S('hotest_events')){
      $events = $Event->getHotestEventIds(4);
      if($events){
        foreach($events as $key=>$value){
          $value = $Event->wrapEventInfo($Event->getEventInfo($value['id']));
          $value['url'] = U('Main/event',array('id'=>$value['id']));
          $value['short_name'] = String::msubstr($value['name'],0,12);
          $value['location'] = String::msubstr($value['province'].' '.$value['city'].' '.$value['area'].' '.$value['location'],0,28);
          $value['time'] = $value['start_time'].' ~ '.$value['end_time'];
          $events[$key] = $value;
        }
        S('hotest_events',$events,3600);  
      }
    }
    $this->hotest_events = $events;
    $this->display();
  }

  public function event(){
    $this->title = "活动";
    $this->navbar[2][2] = 1;
    $this->assign('navbar',$this->navbar);
    $event_id = intval($this->_param('id'));
    if(!$event_id){
      $this->error('没有此活动');
    }
    $user_id = session(C('USER_AUTH_KEY'));
    $event=D('Event')->getEventInfo($event_id,true);
    if(!isset($event)){
      $this->error('活动不存在');
    }
    $event = D('Event')->wrapEventInfo($event);
    $event['location'] = $event['province'].' '.$event['city'].' '.$event['area'].' '.$event['location'];
    $event['time'] = $event['start_time'].' —— '.$event['end_time'];
    $event['description'] = html_entity_decode($event['description']);
    $event['schedule'] = json_decode($event['schedule'],true);
    if($event['status'] == 1) $event['show_status'] = '<span class="label">未完成</span>';
    else if($event['status'] == 2) $event['show_status'] = '<span class="label label-info">即将开始</span>';
    else if($event['status'] == 3) $event['show_status'] = '<span class="label label-success">正在进行</span>';
    else if($event['status'] == 4) $event['show_status'] = '<span class="label">已经结束</span>';
    $event['is_followed'] = D('EventFollow')->isFollowed($user_id,$event_id);
    $event['is_joined'] = D('EventJoin')->isJoined($user_id,$event_id);
    //如果二维码不存在就生成一下
    if(!$event['EventQrcode'] || !file_get(C('QRCODE_PATH').'/'.$event['EventQrcode']['name'])){
      $qrcode_name = generate_qrcode('http://'.$_SERVER['HTTP_HOST'].__APP__.'/Main/event/id/'.$event_id);
      if(!$event['EventQrcode'])
        $qrcode_id = D('EventQrcode')->addEventQrcode($event_id,$qrcode_name);
      else
        $qrcode_id = D('EventQrcode')->updateEventQrcode($event['EventQrcode']['id'],$event_id,$qrcode_name);
      $event['EventQrcode'] = array('id'=>$qrcode_id,'event_id'=>$event_id,'name'=>$qrcode_name);
    }

    $this->event = $event;
    $this->user_id = $user_id;
    $this->display();

  }

  public function events(){
    $this->title = '全部活动';
    $this->navbar[2][2] = 1;
    $this->assign('navbar',$this->navbar);
    $Event = D('Event');
    $EventCategory = D('EventCategory');
    $this->categories = $EventCategory->getAllCategories();
    $this->category_id = isset($_GET['category_id'])?$_GET['category_id']:1;
    $this->time = isset($_GET['time'])?$_GET['time']:'';
    //获得此分类数量
    $category = $EventCategory->getCategory($this->category_id);
    $count = $Event->getListEventCount($this->category_id,$this->time?$this->time:'all');
    import('ORG.Util.Page');
    $Page = new Page($count,5);
    $Page->setConfig('theme','<ul><li>%first%</li><li>%upPage%</li><li>%prePage%</li><li>%linkPage%</li><li>%nextPage%</li><li>%downPage%</li><li>%end%</li></ul>');
    $page_show = $Page->show();
    $ids = $Event->getListEventIds($this->category_id,$this->time?$this->time:'all',$Page->firstRow,$Page->listRows);
    $events = array();
    if($ids){
      foreach($ids as $key=>$value){
        $value = $Event->wrapEventInfo($Event->getEventInfo($value['id']));
        $value['url'] = U('Main/event',array('id'=>$value['id']));
        if($value['status'] == 0) $value['show_status'] = '<span class="label pull-right">未完成</span>';
        else if($value['status'] == 1) $value['show_status'] = '<span class="label label-info pull-right">即将开始</span>';
        else if($value['status'] == 2) $value['show_status'] = '<span class="label label-success pull-right">正在进行</span>';
        else if($value['status'] == 3) $value['show_status'] = '<span class="label pull-right">已经结束</span>';
        $events[$key] = $value;
      }  
    }
    $this->data =array(
      'events' => $events,
      'error' => '<h4>没有复合条件的活动</h4>',
      'page' =>$page_show
      ); 
    $this->display();
  }

  public function search(){
    $this->title = '查找活动';
    $this->navbar[2][2] = 1;
    $this->assign('navbar',$this->navbar);
    $Event = D('Event');
    $this->q = $this->_param('q');
    //获得此分类数量
    $count = $Event->getSearchCount($this->q);
    import('ORG.Util.Page');
    $Page = new Page($count,5);
    $Page->setConfig('theme','<ul><li>%first%</li><li>%upPage%</li><li>%prePage%</li><li>%linkPage%</li><li>%nextPage%</li><li>%downPage%</li><li>%end%</li></ul>');
    $page_show = $Page->show();
    $ids = $Event->getSearchIds($this->q,$Page->firstRow,$Page->listRows);
    $events = array();
    foreach($ids as $key=>$value){
      $value = $Event->wrapEventInfo($Event->getEventInfo($value['id']));
      $value['url'] = U('Main/event',array('id'=>$value['id']));
      if($value['status'] == 0) $value['show_status'] = '<span class="label pull-right">未完成</span>';
      else if($value['status'] == 1) $value['show_status'] = '<span class="label label-info pull-right">即将开始</span>';
      else if($value['status'] == 2) $value['show_status'] = '<span class="label label-success pull-right">正在进行</span>';
      else if($value['status'] == 3) $value['show_status'] = '<span class="label pull-right">已经结束</span>';
      $events[$key] = $value;
    }
    $this->data =array(
      'events' => $events,
      'error' => '<h4>没有复合条件的活动</h4>',
      'page' =>$page_show
      ); 
    $this->display();
  }

  public function eventPrint(){
    $this->title = "活动";
    $event_id = intval($this->_param('id'));
    if(!$event_id){
      $this->error('没有此活动');
    }
    $event=D('Event')->getEventInfo($event_id,true);
    if(!isset($event)){
      $this->error('活动不存在');
    }
    $event = D('Event')->wrapEventInfo($event);
    $event['location'] = $event['province'].' '.$event['city'].' '.$event['area'].' '.$event['location'];
    $event['time'] = $event['start_time'].' —— '.$event['end_time'];
    //如果二维码不存在就生成一下
    if(!$event['EventQrcode']){
      $qrcode_name = generate_qrcode('http://'.$_SERVER['HTTP_HOST'].__APP__.'/Main/event/id/'.$event_id);
      $qrcode_id = D('EventQrcode')->addEventQrcode($event_id,$qrcode_name);
      $event['EventQrcode'] = array('id'=>$qrcode_id,'event_id'=>$event_id,'qrcode'=>$qrcode_name);
    }
    $this->event = $event;
    $this->display();
  }
}