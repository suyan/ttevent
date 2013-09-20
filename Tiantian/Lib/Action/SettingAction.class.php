<?php
class SettingAction extends CommonAction {

  protected function _initialize(){
    parent::_initialize();
    $this->bread = array(
      array('首页',U('Public/index'),0),
      array('帐号设置',U('Setting/baseProfile'),0),
      array('基本资料',U('Setting/baseProfile'),0)
      );
    $this->nav_list = array(
      '个人资料'=>array(
        array('基本资料',U('Setting/baseProfile'),0),
        array('详细资料',U('Setting/detailProfile'),0),
        array('修改头像',U('Setting/setAvatar'),0),
        array('修改密码',U('Setting/setPassword'),0)
        ),
      );
    $this->navbar[1][2] = true;
  }

  public function index(){
    
  }

  public function baseProfile(){
    $this->bread[2][2] = 1;
    $this->nav_list['个人资料'][0][2] = 1;
    $this->assign(array('navbar'=>$this->navbar,'bread'=>$this->bread,'nav_list'=>$this->nav_list));
    $this->title = '基本资料';
    $input_email=array(
      'type'=>'email',
      'id'=>'email',
      'name'=>'登录名/邮箱',
      'disabled'=>'disabled',
      'value' => session('email')
      );
    $input_nickname = array(
      'type'=>'text',
      'id'=>'nickname',
      'name'=>'昵称',
      'value' =>session('nickname'),
      'rules'=>'{required:true,minlength:2}',
      'messages'=>'{required:"请输入昵称",minlength:"昵称最少为两个字"}',
      );
    $this->data = array(
      'form_id'=>'modifyForm',
      'form_title'=>'基本资料',
      'action_url'=>U('Setting/updateBaseProfile'),
      'submit_name'=>'确认修改',
      'submit_loading'=>'处理中...',
      'success'=>'$("#show_success").html(ret.info).show();',
      'error'=>'$("#show_alert").html(ret.info).show();',
      'inputs'=>array(
        'email'=>$input_email,
        'nickname'=>$input_nickname,
        ),
      );
    $this->display();
  }

  public function updateBaseProfile(){
    if(!isset($_POST['nickname'])){
      $this->error('昵称是必填项');
    }
    $User = D('User');
    $User->id = session(C('USER_AUTH_KEY'));
    $User->nickname = $this->_param('nickname');
    if($User->save()){
      session('nickname',$this->_param('nickname'));
      $this->success('修改成功');
    }
    $this->error('资料未改变或修改失败');
  }

  public function detailProfile(){
    $this->bread[2] = array('详细资料',U('Setting/detailProfile'),1);
    $this->nav_list['个人资料'][1][2] = 1;
    $this->title = '详细资料';
    $this->assign(array('navbar'=>$this->navbar,'bread'=>$this->bread,'nav_list'=>$this->nav_list));
    $user_id = session(C('USER_AUTH_KEY'));
    $profile = D('UserProfile')->getUserProfile($user_id);
    $input_real_name = array(
      'type'=>'text',
      'id'=>'real_name',
      'name'=>'真实姓名',
      'value' =>$profile['real_name'],
      'rules'=>'{rangelength:[2,8]}',
      'messages'=>'{rangelength:"请输入正确的姓名"}',
      );
    $input_event_email=array(
      'type'=>'email',
      'id'=>'event_email',
      'name'=>'活动使用邮箱',
      'value' => $profile['event_email'],
      'rules'=>'{email:true}',
      'messages'=>'{email:"请输入正确的邮箱"}'
      );
    $input_gender = array(
      'type'=>'radio',
      'id'=>'gender',
      'name'=>'性别',
      'inline'=>'inline',
      'rules'=>'{required:true}',
      'radios'=>array(
        array('1','男',$profile['gender']?1:0),
        array('0','女',$profile['gender']?0:1)
        ));
    $input_mobile = array(
      'type'=>'text',
      'id'=>'mobile',
      'name'=>'手机号码',
      'value'=>$profile['mobile'],
      'rules'=>'{digits:true,rangelength:[11,11]}',
      'messages'=>'{digits:"请输入正确的手机号码",rangelength:"请输入正确的手机号码"}'
      );
    $this->data = array(
      'form_id'=>'modifyForm',
      'form_title'=>'修改资料',
      'action_url'=>U('Setting/updateDetailProfile'),
      'submit_name'=>'确认修改',
      'submit_loading'=>'处理中...',
      'success'=>'$("#show_success").html(ret.info).show();',
      'error'=>'$("#show_alert").html(ret.info).show();',
      'inputs'=>array(
        'event_email'=>$input_event_email,
        'real_name'=>$input_real_name,
        'gender'=>$input_gender,
        'mobile'=>$input_mobile
        ));
    $this->display();
  }

  public function updateDetailProfile(){
    $user_id = session(C('USER_AUTH_KEY'));
    $profile = array();
    $profile['user_id'] = $user_id;
    $profile['real_name'] = $this->_param('real_name');
    $profile['event_email'] = $this->_param('event_email');
    $profile['gender'] = $this->_param('gender');
    $profile['mobile'] = $this->_param('mobile');
    $result = D('UserProfile')->updateUserProfile($profile);
    if($result){
      $this->success('修改成功');
    }
    $this->error('资料未改变或修改失败');
  }

  public function setAvatar(){
    $this->bread[2] = array('修改头像',U('Setting/setAvatar'),1);
    $this->nav_list['个人资料'][2][2] = 1;
    $this->assign(array('navbar'=>$this->navbar,'bread'=>$this->bread,'nav_list'=>$this->nav_list));
    $this->title = '修改头像';
    $this->avatar = D('User')->getUserImgUrls(session(C('USER_AUTH_KEY')));
    $this->display();
  }

  public function setPassword(){
    $this->bread[2] = array('修改密码',U('Setting/setPassword'),1);
    $this->nav_list['个人资料'][3][2] = 1;
    $this->assign(array('navbar'=>$this->navbar,'bread'=>$this->bread,'nav_list'=>$this->nav_list));
    $this->title = '修改密码';
    $input_src_password=array(
      'type'=>'password',
      'id'=>'src_password',
      'name'=>'原始密码',
      'rules'=>'{required:true,minlength:6}',
      'messages'=>'{required:"请输入密码",minlength:"密码最短为六位"}',
      );
    $input_password=array(
      'type'=>'password',
      'id'=>'password',
      'name'=>'新密码',
      'rules'=>'{required:true,minlength:6}',
      'messages'=>'{required:"请输入密码",minlength:"密码最短为六位"}',
      );
    $input_confirm_password=array(
      'type'=>'password',
      'id'=>'confirm_password',
      'name'=>'确认密码',
      'rules'=>'{required:true,minlength:6,equalTo:"#password"}',
      'messages'=>'{required:"请输入密码",minlength:"密码最短为六位",equalTo:"密码输入不一致"}',
      );
    $this->data = array(
      'form_id'=>'changeForm',
      'form_title'=>'修改密码',
      'action_url'=>U('Setting/updatePassword'),
      'submit_name'=>'确定修改',
      'submit_loading'=>'处理中...',
      'success'=>'$("#show_success").html(ret.info).show();',
      'error'=>'$("#show_alert").html(ret.info).show();',
      'inputs'=>array(
        'src_password'=>$input_src_password,
        'password'=>$input_password,
        'confirm_password'=>$input_confirm_password
        ),
      );
    $this->display();
  }

  public function updatePassword(){
    if(!isset($_POST['src_password'])){
      $this->error('请输入原始密码');
    }else if(!isset($_POST['password'])){
      $this->error('请输入新密码');
    }
    if(md5($this->_param('src_password')) != D('User')->where(array('id'=>session(C('USER_AUTH_KEY'))))->getField('password')){
      $this->error('原始密码输入错误');
    }
    D('User')->save(array(
      'id'=>session(C('USER_AUTH_KEY')),
      'password'=>md5($this->_param('password')),
      'update_time'=>time()
      ));
    $this->success('修改成功');
  }

  public function uploadImage(){
    $user_id = session(C('USER_AUTH_KEY'));
    $Image = D('Image');
    $User = D('User');
    $info = $Image->uploadImage();
    if(!is_array($info))
      $this->error($info);
    $imgs = $User->getUserImgs($user_id);
    $Image->deleteImage($imgs['src_img']);
    $Image->deleteImage($imgs['large_img']);
    $Image->deleteImage($imgs['middle_img']);
    $Image->deleteImage($imgs['small_img']);

    $data = array();
    $data['id'] = $user_id;
    $data['src_img'] = $info['id'];
    $data['large_img'] = '';
    $data['middle_img'] = '';
    $data['small_img'] = '';
    $User->updateUser($data);
    $this->show(json_encode($info));
  }

  public function cropImage(){
    $user_id = session(C('USER_AUTH_KEY'));
    $Image = D('Image');
    $User = D('User');
    $coords = explode(',',I('get.coords'));
    //裁剪图像
    $imgs = $User->getUserImgs($user_id);
    if(!isset($imgs['src_img']))
      $this->error('请先上传头像');
    //获得图像信息
    $info = $Image->getImageInfo($imgs['src_img']);
    $large_info = $Image->cropImage($info,'image',$info['name'].'_large',$coords,140,140);
    $middle_info = $Image->cropImage($info,'image',$info['name'].'_middle',$coords,50,50);
    $small_info = $Image->cropImage($info,'image',$info['name'].'_small',$coords,30,30);
    $data = array(
      'id'=>$user_id,
      'large_img'=>$large_info['id'],
      'middle_img'=>$middle_info['id'],
      'small_img'=>$small_info['id'],
      );
    $User->updateUser($data);
    $this->show(json_encode(array(
       'large_img'=>$large_info['url'],
       'middle_img'=>$middle_info['url'],
       'small_img'=>$small_info['url']
    )));
  }
}