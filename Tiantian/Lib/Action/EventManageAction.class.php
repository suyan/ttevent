<?php 
class EventManageAction extends CommonAction{

  protected function _initialize(){
    parent::_initialize();
    $this->event_id = $this->_param('id');
    if(!$this->event_id){
      $this->redirect('Event/myEvent');
    }
    $this->user_id = session(C('USER_AUTH_KEY'));
    if(!D('Event')->isEventEnabled($this->event_id))
      $this->error('活动不存在');
    if(!D('Event')->isCreater($this->event_id,$this->user_id))
      $this->error('您不是此活动的创建者');
    $this->bread = array(
      array('首页',U('Public/index'),0),
      array('管理活动',U('Event/myEvent'),0),
      array('我的活动',U('Event/myEvent'),0)
      );
    $this->nav_list = array(
      '活动管理'=>array(
        array('查看活动',U('EventManage/index',array('id'=>$this->event_id)),0),
        array('修改活动信息',U('EventManage/modifyEventInfo',array('id'=>$this->event_id)),0),
        array('修改活动海报',U('EventManage/modifyEventPoster',array('id'=>$this->event_id)),0),
        ),
      '用户管理'=>array(
        array('管理成员',U('EventManage/admin',array('id'=>$this->event_id)),0),
        array('参与用户',U('EventManage/join',array('id'=>$this->event_id)),0),
        array('关注用户',U('EventManage/follow',array('id'=>$this->event_id)),0)
        )
      );
    $this->navbar[2][2] = true;
  }

  function index(){
    $this->title = '查看活动';
    $this->nav_list['活动管理'][0][2] = 1;
    $event = D('Event')->getEventInfo($this->event_id,true);
    $this->bread[2] = array($event['name'],U('EventManage/index',array('id'=>$this->event_id)),0);
    $this->bread[3] = array('活动资料','',1);
    $this->assign(array('navbar'=>$this->navbar,'bread'=>$this->bread,'nav_list'=>$this->nav_list));
    $event = D('Event')->wrapEventInfo($event);
    $event['location'] = $event['province'].' '.$event['city'].' '.$event['area'].' '.$event['location'];
    $event['time'] = $event['start_time'].' —— '.$event['end_time'];
    $event['description'] = html_entity_decode($event['description']);
    if($event['status'] == 1) $event['show_status'] = '<span class="label">未完成</span>';
    else if($event['status'] == 2) $event['show_status'] = '<span class="label label-info">即将开始</span>';
    else if($event['status'] == 3) $event['show_status'] = '<span class="label label-success">正在进行</span>';
    else if($event['status'] == 4) $event['show_status'] = '<span class="label">已经结束</span>';
    $this->event = $event;
    $this->display();
  }

  function modifyEventInfo(){
    $this->title = '修改活动信息';
    $this->nav_list['活动管理'][1][2] = 1;
    $this->assign(array('navbar'=>$this->navbar,'bread'=>$this->bread,'nav_list'=>$this->nav_list));
    if(!isset($_GET['id']))
      $this->error('活动不存在');
    $event_id = intval($_GET['id']);
    $Event = D('Event');
    if(!$Event->isCreater($event_id,session(C('USER_AUTH_KEY'))))
      $this->error('你不是活动的创建者');

    if($event = D('Event')->getEventInfo($event_id,true)){
      $this->id = $event_id;
      $this->event_name = $event['name'];
      $this->schedule = json_decode($event['schedule'],true);
      $this->event_category = $event['category_id'];
      $this->event_sub_category = $event['sub_category_id'];
      $this->start_time = $event['start_time']?date('Y-m-d G:i',$event['start_time']):'';
      $this->end_time = $event['end_time']?date('Y-m-d G:i',$event['end_time']):'';
      $this->province = $event['province_id'];
      $this->city = $event['city_id'];
      $this->area = $event['area_id'];
      $this->location = $event['location'];
      $this->description = $event['description'];
      $this->tag ='';
      foreach($event['EventTag'] as $value){
        $this->tag .= $value['name'].',';
      }
    }
    $this->display();
  }

  function modifyEventPoster(){
    $this->title = '修改活动海报';
    $this->nav_list['活动管理'][2][2] = 1;
    $this->assign(array('navbar'=>$this->navbar,'bread'=>$this->bread,'nav_list'=>$this->nav_list));
    if(!isset($_GET['id']))
      $this->error('活动不存在');
    $event_id = intval($_GET['id']);
    $Event = D('Event');
    if(!$Event->isCreater($event_id,session(C('USER_AUTH_KEY'))))
      $this->error('你不是活动的创建者');

    if($event = $Event->wrapEventInfo($Event->getEventInfo($event_id))){
      $this->name = $event['name'];
      $this->id = $event_id;
      if($event['middle_img']){
        $this->poster = $event['middle_img'];  
      }
    }
    $this->display();
  }

  function admin(){
    $this->title = '管理成员';
    $this->nav_list['用户管理'][0][2] = 1;
    $event = D('Event')->getEventInfo($this->event_id,true);
    $this->bread[2] = array($event['name'],U('EventManage/index',array('id'=>$this->event_id)),0);
    $this->bread[3] = array('管理成员','',1);
    $this->assign(array('navbar'=>$this->navbar,'bread'=>$this->bread,'nav_list'=>$this->nav_list));
    $event = D('Event')->wrapEventInfo($event);
    $this->event = $event;
    $this->display();
  }

  function join(){
    $this->title = '参与用户';
    $this->nav_list['用户管理'][1][2] = 1;
    $event = D('Event')->getEventInfo($this->event_id,true);
    $this->bread[2] = array($event['name'],U('EventManage/index',array('id'=>$this->event_id)),0);
    $this->bread[3] = array('参与用户','',1);
    $this->assign(array('navbar'=>$this->navbar,'bread'=>$this->bread,'nav_list'=>$this->nav_list));
    $joins = D('EventJoin')->getEventJoins($this->event_id);
    $this->joins = $joins;
    $this->display();
  }

  function follow(){
    $this->title = '关注用户';
    $this->nav_list['用户管理'][2][2] = 1;
    $event = D('Event')->getEventInfo($this->event_id,true);
    $this->bread[2] = array($event['name'],U('EventManage/index',array('id'=>$this->event_id)),0);
    $this->bread[3] = array('关注用户','',1);
    $this->assign(array('navbar'=>$this->navbar,'bread'=>$this->bread,'nav_list'=>$this->nav_list));
    $follows = D('EventFollow')->getEventFollows($this->event_id);
    if($follows){
      foreach($follows as $key=>$value){
        $follows[$key]['user'] = D('User')->getUserInfo($value['user_id']);
      }  
    }
    $this->follows = $follows;
    $this->display();
  }
}
