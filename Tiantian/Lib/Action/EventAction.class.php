<?php 
class EventAction extends CommonAction{

  protected function _initialize(){
    parent::_initialize();
  }

  public function index(){

  }

  public function showManageEvent(){
    $own = false;
    $user_id = $this->_param('user_id','intval',0);
    if(!$user_id)
      $user_id = session(C('USER_AUTH_KEY'));
    if($user_id == session(C('USER_AUTH_KEY')))
      $own = true;
    $Event = D('Event');
    $count = $Event->getUserEventCount($user_id);
    import('ORG.Util.Page');
    $Page = new Page($count,10);
    $Page->setConfig('theme','<ul><li>%first%</li><li>%upPage%</li><li>%prePage%</li><li>%linkPage%</li><li>%nextPage%</li><li>%downPage%</li><li>%end%</li></ul>');
    $page_show = $Page->show();
    $events = array();
    $ids = $Event->getUserEventIds($user_id,$Page->firstRow,$Page->listRows);
    foreach($ids as $key=>$value){
      $value = $Event->wrapEventInfo($Event->getEventInfo($value['id']));
      if($own)
        $value['url'] = U('EventManage/index',array('id'=>$value['id']));  
      else
        $value['url'] = U('Main/event',array('id'=>$value['id']));  
      if($value['status'] == 1) $value['show_status'] = '<span class="label pull-right">未完成</span>';
      else if($value['status'] == 2) $value['show_status'] = '<span class="label label-info pull-right">即将开始</span>';
      else if($value['status'] == 3) $value['show_status'] = '<span class="label label-success pull-right">正在进行</span>';
      else if($value['status'] == 4) $value['show_status'] = '<span class="label pull-right">已经结束</span>';
      $events[$key] = $value;
    }
    $this->data =array(
      'events' => $events,
      'error' => $own?'<h4>还没有创建活动</h4><a href="create">创建活动</a>':'<h4>Ta还没有创建活动</hr>',
      'page' =>$page_show
      ); 
    $this->show('{:W("Event",$data)}');
  }

  public function showJoinEvent(){
    $own = false;
    $user_id = $this->_param('user_id','intval',0);
    if(!$user_id)
      $user_id = session(C('USER_AUTH_KEY'));
    if($user_id == session(C('USER_AUTH_KEY')))
      $own = true;
    $Event = D('Event');
    $EventJoin = D('EventJoin');
    $count = $EventJoin->getUserJoinEventsCount($user_id);
    import('ORG.Util.Page');
    $Page = new Page($count,10);
    $Page->setConfig('theme','<ul><li>%first%</li><li>%upPage%</li><li>%prePage%</li><li>%linkPage%</li><li>%nextPage%</li><li>%downPage%</li><li>%end%</li></ul>');
    $page_show = $Page->show();
    $events = array();
    $ids = $EventJoin->getUserJoinEventIds($user_id,$Page->firstRow,$Page->listRows);
    foreach($ids as $key=>$value){
      $value = $Event->wrapEventInfo($Event->getEventInfo($value['event_id']));
      $value['url'] = U('Main/event',array('id'=>$value['id']));
      if($value['status'] == 1) $value['show_status'] = '<span class="label pull-right">未完成</span>';
      else if($value['status'] == 2) $value['show_status'] = '<span class="label label-info pull-right">即将开始</span>';
      else if($value['status'] == 3) $value['show_status'] = '<span class="label label-success pull-right">正在进行</span>';
      else if($value['status'] == 4) $value['show_status'] = '<span class="label pull-right">已经结束</span>';
      $events[$key] = $value;
    }
    $this->data =array(
      'events' => $events,
      'error' => $own?'<h4>还没有参加活动</h4>':'<h4>Ta还没有参加活动</h4>',
      'page' =>$page_show
      ); 
    $this->show('{:W("Event",$data)}');
  }

  public function showFollowEvent(){
    $own = false;
    $user_id = $this->_param('user_id','intval',0);
    if(!$user_id)
      $user_id = session(C('USER_AUTH_KEY'));
    if($user_id == session(C('USER_AUTH_KEY')))
      $own = true;
    $Event = D('Event');
    $EventFollow = D('EventFollow');
    $count = $EventFollow->getUserFollowEventsCount($user_id);
    import('ORG.Util.Page');
    $Page = new Page($count,10);
    $Page->setConfig('theme','<ul><li>%first%</li><li>%upPage%</li><li>%prePage%</li><li>%linkPage%</li><li>%nextPage%</li><li>%downPage%</li><li>%end%</li></ul>');
    $page_show = $Page->show();
    $events = array();
    $ids = $EventFollow->getUserFollowEventIds($user_id,$Page->firstRow,$Page->listRows);
    foreach($ids as $key=>$value){
      $value = $Event->wrapEventInfo($Event->getEventInfo($value['event_id']));
      $value['url'] = U('Main/event',array('id'=>$value['id']));
      if($value['status'] == 1) $value['show_status'] = '<span class="label pull-right">未完成</span>';
      else if($value['status'] == 2) $value['show_status'] = '<span class="label label-info pull-right">即将开始</span>';
      else if($value['status'] == 3) $value['show_status'] = '<span class="label label-success pull-right">正在进行</span>';
      else if($value['status'] == 4) $value['show_status'] = '<span class="label pull-right">已经结束</span>';
      $events[$key] = $value;
    }
    $this->data =array(
      'events' => $events,
      'error' => $own?'<h4>还没有关注活动</h4>':'<h4>Ta还没有关注活动</h4>',
      'page' =>$page_show
      ); 
    $this->show('{:W("Event",$data)}');
  }

  public function getEventCategory(){
    echo D('EventCategory')->getJsonCategories();
  }

  public function getRegion(){
    echo D('Region')->getJsonRegions();
  }

  public function getEventTag(){
    $tag = $this->_param('tag');
    echo D('EventTag')->getJsonEventTags($tag);
  }

  public function deleteEvent(){
    $id = intval($this->_param('id'));
    $user_id = session(C('USER_AUTH_KEY'));
    if(!D('Event')->isEventEnabled($event_id))
      $this->error('活动不存在');
    if(!D('Event')->isCreater($id,$user_id))
      $this->error('您不是此活动的创建者');
    //删除图片文件
    // file_delete('./Public/upload/'.$Event->large_img);
    // file_delete('./Public/upload/'.$Event->middle_img);
    // file_delete('./Public/upload/'.$Event->small_img);
    //最后删除相关数据
    if(D('Event')->deleteEvent($id))
      $this->success('删除成功');
    else
      $this->error('删除失败');
  }
}

