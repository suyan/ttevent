<?php
class ApiAction extends CommonAction{

  public function _initialize(){
    $this->url = 'http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/api.php';
    $this->email = 'test1@test.com';
    $this->password = '123qwe';
    $this->event_id = 1;
    $this->event_email = 'test1@test.com';
    $this->real_name = 'test1';
    $this->mobile = '11111111111';
  }

  public function userLogin(){
    $this->display();
  }

  public function testUserLogin(){
    $url =$this->url.'/Public/login';
    $key = base64_encode($this->email.':'.$this->password);
    $ret = $this->curlpost($url,array('key'=>$key));
    $ret = json_decode($ret,true);
    if($ret['status']==0)
      $this->error('登录失败');
    else
      $this->success('登录成功');
    $this->token = $ret['info']['token'];
    $this->info($ret);
  }

  public function testHotestEvent(){
    $url = $this->url.'/Public/getHotestEvents';
    $ret = $this->curlget($url,array('count'=>1));
    $events = json_decode($ret,true);
    if($events['status']==0)
      $this->error('获取失败');
    else
      $this->success('获取成功');
    // $this->info($events['info']);
  }

  public function testFollowEvent(){
    $url = $this->url.'/EventFollow/follow';
    $ret = $this->curlget($url,array('token'=>$this->token,'event_id'=>$this->event_id));
    $ret = json_decode($ret,true);
    if($ret['status']==0)
      $this->error($ret['info']);
    else
      $this->success('关注成功');
  }

  public function testUnfollowEvent(){
    $url = $this->url.'/EventFollow/unfollow';
    $ret = $this->curlget($url,array('token'=>$this->token,'event_id'=>$this->event_id));
    $ret = json_decode($ret,true);
    if($ret['status']==0)
      $this->error($ret['info']);
    else
      $this->success('取消关注成功');
  }

  public function testJoinEvent(){
    $url = $this->url.'/EventJoin/join';
    $ret = $this->curlget($url,array(
      'token'=>$this->token,
      'event_id'=>$this->event_id,
      'event_email'=>$this->event_email,
      'mobile'=>$this->mobile,
      'real_name'=>$this->real_name
      ));
    $ret = json_decode($ret,true);
    if($ret['status']==0)
      $this->error($ret['info']);
    else
      $this->success('参加成功');
  }

  public function testUnjionEvent(){
    $url = $this->url.'/EventJoin/unjoin';
    $ret = $this->curlget($url,array(
      'token'=>$this->token,
      'event_id'=>$this->event_id,
      ));
    $ret = json_decode($ret,true);
    if($ret['status']==0)
      $this->error($ret['info']);
    else
      $this->success('取消参加成功');
  }

}