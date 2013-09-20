<?php
class UserModel extends RelationModel{

  public $_link = array(
    'UserProfile' => array(
      'mapping_type' => HAS_ONE,
      'mapping_name' => 'UserProfile',
      'class_name' => 'UserProfile',
      'foreign_key' => 'user_id',
      )
    );

  public $_validate = array(
    array('email','email','邮箱格式错误',self::MUST_VALIDATE),
    array('email','require','邮箱必须',self::MUST_VALIDATE),
    array('password','require','密码必须',self::MUST_VALIDATE),
    array('confirm_password','require','确认密码必须',self::EXISTS_VALIDATE),
    array('confirm_password','password','确认密码不一致',self::EXISTS_VALIDATE,'confirm'),
    array('nickname','require','昵称必须',self::MUST_VALIDATE)
    );

  public $_auto   = array(
    array('password','pwdHash',self::MODEL_BOTH,'callback'),
    );

  public function pwdHash() {
    if(isset($_POST['password'])) {
      return md5($_POST['password']);
    }else{
      return false;
    }
  }

  public function addUser($data){
    import('ORG.Net.IpLocation');
    $Ip = new IpLocation('UTFWry.dat');
    $location  = $Ip->getlocation();
    $data['update_time'] = NOW_TIME;
    $data['status']=1;
    $data['login_count'] = 1;
    $data['UserProfile'] = array(
      'last_login_time' => NOW_TIME,
      'last_login_ip' => $location['ip'],
      'last_login_location' => $location['country'],
      'create_time'=>NOW_TIME
      );
    if($result = $this->relation(true)->add($data)){
      D('Setting')->incKey('user_count');
    }
    return $result;
  }

  public function updateUser($data){
    return $this->save($data);
  }

  public function checkEmail($email){
    return $this->where("email='$email'")->getField('id');
  }

  public function checkUser($email,$password,$relation=false){
    $user = $this->where(array('email'=>$email,'password'=>$password,))->relation($relation)->find();
    unset($user['password']);
    return $user;
  }

  public function checkUserByToken($token,$relation=false){
    $user = $this->where(array('token'=>$token))->relation($relation)->find(); 
    if(!$user)
      return false;
    unset($user['password']);
    import('ORG.Net.IpLocation');
    $Ip = new IpLocation('UTFWry.dat');
    $location  = $Ip->getlocation();
    $data = array(
      'id'=>$user['id'],
      'update_time'=>NOW_TIME,
      'UserProfile'=>array(
        'last_login_time' => NOW_TIME,
        'last_login_ip' => $location['ip'],
        'last_login_location' => $location['country'],
        ));
    $this->relation(true)->save($data);
    return $user;
  }
  
  public function userLogin($id){
    import('ORG.Net.IpLocation');
    $Ip = new IpLocation('UTFWry.dat');
    $location  = $Ip->getlocation();
    $data = array(
      'id'=>$id,
      'update_time'=>NOW_TIME,
      'login_count'=>array('exp','login_count+1'),
      'token'=>md5(uniqid(mt_rand(), true)),
      'UserProfile'=>array(
        'last_login_time' => NOW_TIME,
        'last_login_ip' => $location['ip'],
        'last_login_location' => $location['country'],
        ));
    if($this->relation(true)->save($data))
      return $data['token'];
    else 
      return $this->getError();
  }

  public function incUserEventCount($user_id){
    return $this->save(array('id'=>$user_id,'event_count'=>array('exp','event_count+1')));
  }

  public function decUserEventCount($user_id){
    return $this->save(array('id'=>$user_id,'event_count'=>array('exp','event_count-1')));
  }

  public function incUserFollowCount($user_id){
    return $this->save(array('id'=>$user_id,'user_follow'=>array('exp','user_follow+1')));
  }

  public function decUserFollowCount($user_id){
    return $this->save(array('id'=>$user_id,'user_follow'=>array('exp','user_follow-1')));
  }

  public function incFollowCount($user_id){
    return $this->save(array('id'=>$user_id,'follow_count'=>array('exp','follow_count+1')));
  }

  public function decFollowCount($user_id){
    return $this->save(array('id'=>$user_id,'follow_count'=>array('exp','follow_count-1')));
  }

  public function getHotestCreater($num){
    return $this->field('id,nickname,event_count,event_follow,event_join,update_time,src_img,middle_img')->order('event_count desc')->limit($num)->select();
  }

  public function getHotestFollower($num){
    return $this->field('id,nickname,event_count,event_follow,event_join,update_time,src_img,middle_img')->order('event_follow desc')->limit($num)->select();
  }

  public function getUserInfo($user_id,$relation=false){
    return $this->field('id,nickname,event_count,login_count,event_follow,event_join,follow_count,user_follow,email,status,update_time,src_img,large_img,middle_img,small_img')->relation($relation)->find($user_id);
  }

  public function getUserImgs($user_id){
    $ids = $this->field('src_img,large_img,middle_img,small_img')->find($user_id);
    return $ids;
  }

  public function getUserImgUrls($user_id){
    $ids = $this->field('src_img,large_img,middle_img,small_img')->find($user_id);
    if($ids['src_img']==0){
      $ids['src_img'] = $ids['large_img'] = $ids['middle_img'] = $ids['small_img'] = 'http://'.$_SERVER['HTTP_HOST'].__ROOT__."/Public/img/avatar.jpg";
      return $ids;
    }

    $Image = D('Image');
    foreach($ids as $key=>$value){
      $ids[$key]=$Image->getImageUrl($value);
    }
    return $ids;
  }

  public function wrapUserInfo($user){
    if(!isset($user['src_img']) || !$user['src_img']){
      $user['src_img'] = $user['large_img'] = $user['middle_img'] = $user['small_img'] = 'http://'.$_SERVER['HTTP_HOST'].__ROOT__."/Public/img/avatar.jpg";
    }else{
      $Image = D('Image');
      if(isset($user['src_img'])) $user['src_img'] = $Image->getImageUrl($user['src_img']);
      if(isset($user['large_img'])) $user['large_img'] = $Image->getImageUrl($user['large_img']);
      if(isset($user['middle_img'])) $user['middle_img'] = $Image->getImageUrl($user['middle_img']);
      if(isset($user['small_img'])) $user['small_img'] = $Image->getImageUrl($user['small_img']);
    }
    $user['update_time']=date('Y-m-d G:i',$user['update_time']);
    return $user;
  }

  public function wrapUserInfoForMobile($user){
    if(!$user['src_img']){
      $user['src_img'] = $user['large_img'] = $user['middle_img'] = $user['small_img'] = 'http://'.$_SERVER['HTTP_HOST'].__ROOT__."/Public/img/avatar.jpg";
    }else{
      $Image = D('Image');
      $user['src_img'] = $Image->getImageUrl($user['src_img']);
      $user['large_img'] = $Image->getImageUrl($user['large_img']);
      $user['middle_img'] = $Image->getImageUrl($user['middle_img']);
      $user['small_img'] = $Image->getImageUrl($user['small_img']);
    }

    if($user['UserProfile']){
      $user['real_name'] = $user['UserProfile']['real_name'];
      $user['event_email'] = $user['UserProfile']['event_email'];
      $user['mobile'] = $user['UserProfile']['mobile'];
      $user['gender'] = $user['UserProfile']['gender'];
      unset($user['UserProfile']); 
      unset($user['token']);
    }
    return $user;
  }
}