<?php 
class EventCreateAction extends CommonAction{

  protected function _initialize(){
    parent::_initialize();
    $this->bread = array(
      array('活动',U('Event/myEvent'),0),
      array('创建活动',U('EventCreate/eventType'),0),
      array('活动信息','',0),
      );
    $this->nav_list = array(
      '创建活动'=>array(
        array('1.活动类型',U('EventCreate/offlineEventInfo'),0),
        array('2.活动信息',U('EventCreate/offlineEventInfo'),0),
        array('3.活动海报',U('EventCreate/offlineEventPoster'),0),
        array('4.完成创建',U('EventCreate/events'),0),
        ),
      );
    $this->navbar[2][2] = true;
  }

  public function eventType(){
    $this->title = "活动类型";
    $this->bread[2]=array('活动类型','',1);
    $this->nav_list['创建活动'][0][2] = 1;
    $this->assign(array('navbar'=>$this->navbar,'bread'=>$this->bread,'nav_list'=>$this->nav_list));
    $this->display();
  }

  public function offlineEventInfo(){
    $this->title = "活动信息";
    $this->bread[2][2]=1;
    $this->nav_list['创建活动'][1][2] = 1;
    $this->nav_list['创建活动'][0][0] .= "<i class='icon-ok'></i>";
    $this->assign(array('navbar'=>$this->navbar,'bread'=>$this->bread,'nav_list'=>$this->nav_list));
    if($this->_param('error'))
      $this->error = "请先完成此步";
    $this->display();
  }

  public function offlineEventInfoSave(){
    if(!$this->_param('name')){
      $this->error('活动名必须');
    }else if(!$this->_param('start_time') || !$this->_param('end_time')){
      $this->error("请输入活动时间");
    }else if(!$this->_param('category_select_')){
      $this->error("请选择活动类型");
    }else if(!$this->_param('location_select_') || !$this->_param('location')){
      $this->error("请填写活动地点和详细地址");
    }else if(!$this->_param('description')){
      $this->error("请填写活动描述");
    }
    //检查日程安排
    $schedule_time = $this->_param('schedule_time');
    $schedule_text = $this->_param('schedule_text');
    $schedule = array();
    foreach($schedule_time as $key=>$value){
      if(!$schedule_time[$key] || !$schedule_text[$key])
        $this->error("请完善活动日程安排");  
      $schedule[strtotime($schedule_time[$key])] = $schedule_text[$key];
    }

    $data = array();
    $Event = D('Event');
    $user_id = session(C('USER_AUTH_KEY'));
    // 有id则是单纯更新
    if(!isset($_GET['id'])){
      $data['user_id'] = $user_id;
      $data['name'] = $this->_param('name');
      $data['type'] = 1;
      $data['status'] = 1;
      $data['id'] = $Event->createEvent($data);
      if(!$data['id'])
        $this->error('创建失败');
    }else{
      $data['id'] = intval($_GET['id']);
      $data['user_id'] = $user_id;
      if(!D('Event')->isCreater($data['id'],$user_id))
        $this->error('你不是这个活动的创建者');
    }
    $data['category_id'] = $this->_param('category_select_');
    $data['sub_category_id'] = $this->_param('category_select__');
    $data['start_time'] = strtotime($this->_param('start_time'));
    $data['end_time'] = strtotime($this->_param('end_time'));
    $data['province_id'] = $this->_param('location_select_');
    $data['city_id'] = $this->_param('location_select__');
    $data['area_id'] = $this->_param('location_select___');
    $data['location'] = $this->_param('location');
    $data['description'] = $this->_param('description');
    $data['schedule'] = json_encode($schedule);
    $data['status'] = 2;//进入预发布期，可以报名了
    if($this->_param('tag')){
      $tags = explode(',',$this->_param('tag'));
      $tag_ids = array();
      foreach($tags as $tag){
        if(!($Tag = D('EventTag')->getEventTagByName($tag)))//获得相应id
          $Tag['id'] = D('EventTag')->addEventTag($tag);
        $tag_ids[] = array('id'=>$Tag['id']);
      }
      $data['EventTag'] = $tag_ids;
    }else{
      $data['EventTag'] = array('id'=>'');
    }
    
    $Event->updateEvent($data,true);
    if(!isset($_GET['id']))
      $this->success(U('EventCreate/offlineEventPoster',array('id'=>$data['id'])));
    else 
      $this->success('修改成功');
  }

  public function offlineEventPoster(){
    if(!isset($_GET['id']))
      $this->redirect('EventCreate/offlineEventInfo',array('error'=>true));
    $event_id = $this->_param('id',0);
    $Event = D('Event');
    if(!$Event->isCreater($event_id,session(C('USER_AUTH_KEY'))))
      $this->redirect('EventCreate/offlineEventInfo',array('error'=>true));

    $this->title = "活动海报";
    $this->bread[2]=array('活动海报','',1);
    $this->nav_list['创建活动'][2][2] = 1;
    $this->nav_list['创建活动'][0][0] .= "<i class='icon-ok'></i>";
    $this->nav_list['创建活动'][1][0] .= "<i class='icon-ok'></i>";
    $this->assign(array('navbar'=>$this->navbar,'bread'=>$this->bread,'nav_list'=>$this->nav_list));
    if($this->_param('error'))
      $this->error = "请先完成此步";
    if($event = $Event->wrapEventInfo($Event->getEventInfo($event_id))){
      $this->name = $event['name'];
      $this->id = $event_id;
      if($event['middle_img']){
        $this->poster = $event['middle_img'];  
      }
    }
    $this->display();
  }

  public function offlineEventFinish(){
    if(!isset($_GET['id']))
      $this->redirect('EventCreate/offlineEventInfo',array('error'=>true));
    $event_id = $this->_param('id',0);
    $Event = D('Event');
    if(!$Event->isCreater($event_id,session(C('USER_AUTH_KEY'))))
      $this->redirect('EventCreate/offlineEventInfo',array('error'=>true));
    $this->title = "创建成功";
    $this->bread[2]=array('创建成功','',1);
    $this->nav_list['创建活动'][3][2] = 1;
    $this->nav_list['创建活动'][0][0] .= "<i class='icon-ok'></i>";
    $this->nav_list['创建活动'][1][0] .= "<i class='icon-ok'></i>";
    $this->nav_list['创建活动'][2][0] .= "<i class='icon-ok'></i>";
    $this->assign(array('navbar'=>$this->navbar,'bread'=>$this->bread,'nav_list'=>$this->nav_list));
    $this->url = U('EventManage/index',array('id'=>$event_id));
    $this->display();
  }

  public function uploadImage(){
    $event_id = I('get.id',0,'intval');
    if(!$event_id)
      $this->error('请完成活动信息');
    $user_id = session(C('USER_AUTH_KEY'));
    $Event = D('Event');
    $Image = D('Image');
    if(!$Event->isCreater($event_id,$user_id))
      $this->error('你不是活动创建者');
    
    $info = $Image->uploadImage();
    if(!is_array($info))
      $this->error($info);
    $imgs = $Event->getEventImgs($event_id);
    $Image->deleteImage($imgs['src_img']);
    $Image->deleteImage($imgs['large_img']);
    $Image->deleteImage($imgs['middle_img']);
    $Image->deleteImage($imgs['small_img']);

    $data = array();
    $data['id'] = $event_id;
    $datq['user_id'] = $user_id;
    $data['src_img'] = $info['id'];
    $data['large_img'] = '';
    $data['middle_img'] = '';
    $data['small_img'] = '';
    $Event->updateEvent($data);
    $this->show(json_encode($info));
  }

  public function cropImage(){
    $event_id = I('get.id',0,'intval');
    if(!$event_id)
      $this->error('请完成活动信息');
    $user_id = session(C('USER_AUTH_KEY'));
    $Event = D('Event');
    $Image = D('Image');
    if(!$Event->isCreater($event_id,$user_id))
      $this->error('你不是活动创建者');
    $coords = explode(',',I('get.coords'));
    //裁剪图像
    $imgs = $Event->getEventImgs($event_id);
    if(!isset($imgs['src_img']))
      $this->error('请先上传海报');
    //获得图像信息
    $info = $Image->getImageInfo($imgs['src_img']);
    $large_info = $Image->cropImage($info,'image',$info['name'].'_large',$coords,400,600);
    $middle_info = $Image->cropImage($info,'image',$info['name'].'_middle',$coords,200,300);
    $small_info = $Image->cropImage($info,'image',$info['name'].'_small',$coords,100,150);
    $data = array(
      'id'=>$event_id,
      'large_img'=>$large_info['id'],
      'middle_img'=>$middle_info['id'],
      'small_img'=>$small_info['id'],
      );
    D('Event')->updateEvent($data);
    $this->show(json_encode(array(
       'url'=>$middle_info['url']
    )));
  }

}