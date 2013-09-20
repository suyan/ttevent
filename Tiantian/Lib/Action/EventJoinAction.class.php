<?php 
class EventJoinAction extends CommonAction{
  public function joinEvent(){
    $user_id = session(C('USER_AUTH_KEY'));
    $event_id = $this->_param('id','intval');
    if(!$user_id){
      $this->error('请先登录');
    }
    $ej = D('EventJoin');
    if(D('Event')->isEventEnableJoin($event_id) && $ej->joinEvent($user_id,$event_id)){
        $this->success('申请参加成功');
    }else{
      $this->error("加入失败");  
    }
  }
  public function unjoinEvent(){
    $user_id = session(C('USER_AUTH_KEY'));
    $event_id = $this->_param('id','intval');
    if(!$user_id){
      $this->error('请先登录');
    }
    $ej = D('EventJoin');
    if(D('Event')->isEventEnableJoin($event_id) && $ej->unjoinEvent($user_id,$event_id)){
      $this->success('取消参与成功');
    }else{
      $this->error("取消失败"); 
    }
  }

  public function showUserInfoForm(){
    $user_id = session(C('USER_AUTH_KEY'));
    $event_id = $this->_param('id');
    $profile = D('UserProfile')->getUserProfile($user_id);
    $input_event_id = array(
      'type'=>'hidden',
      'id'=>'event_id',
      'value'=>$event_id
      );
    $input_real_name = array(
      'type'=>'text',
      'id'=>'real_name',
      'name'=>'真实姓名',
      'value'=>$profile['real_name'],
      'rules'=>'{required:true}',
      'messages'=>'{required:"请输入真实姓名"}'
      );
    $input_event_email=array(
      'type'=>'email',
      'id'=>'event_email',
      'name'=>'邮箱',
      'value'=>$profile['event_email'],
      'rules'=>'{required:true,email:true}',
      'messages'=>'{required:"请输入邮箱",email:"请输入正确的邮箱"}',
      );
    $input_mobile = array(
      'type'=>'text',
      'id'=>'mobile',
      'name'=>'手机号码',
      'value'=>$profile['mobile'],
      'rules'=>'{required:true,digits:true,rangelength:[11,11]}',
      'messages'=>'{required:"请输入手机号码",digits:"请输入正确的手机号码",rangelength:"请输入正确的手机号码"}'
      );
    $this->data = array(
      'modal' => true,
      'modal_id' =>'test',
      'modal_title'=>'提交用户信息',
      'form_id'=>'checkForm',
      'action_url'=>U('EventJoin/checkEventJoin'),
      'submit_name'=>'提交',
      'submit_loading'=>'提交中...',
      'success'=>'$("#show_success").html(ret.info).show();show_unjoin_event();$("#test").modal("hide")',
      'error'=>'$("#show_alert").html(ret.info).show();',
      'inputs'=>array(
        'event_id'=>$input_event_id,
        'real_name'=>$input_real_name,
        'event_email'=>$input_event_email,
        'mobile'=>$input_mobile
        ),
      );
    $this->show('{:W("Form",$data)}');
  }

  public function checkEventJoin(){
    if(!isset($_POST['real_name']))
      $this->error('请输入真实姓名');
    if(!isset($_POST['event_email']))
      $this->error('请输入邮箱地址');
    if(!isset($_POST['mobile']))
      $this->error('请输入手机号码');
    if(!isset($_POST['event_id']))
      $this->error('无此活动');
    $data = array(
      'user_id'=>session(C('USER_AUTH_KEY')),
      'event_id'=>$this->_param('event_id'),
      'real_name'=>$this->_param('real_name'),
      'event_email'=>$this->_param('event_email'),
      'mobile'=>$this->_param('mobile')
      );
    $ret = D('EventJoin')->joinEvent($data);
    if($ret)
      $this->success('参加成功');
    else
      $this->error('参与失败');
  }
}