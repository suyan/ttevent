<?php 
class UserAction extends CommonAction{
  public function getUserInfo(){
    $User = D('Tiantian://User');
    $data = array(
      'info'=>$User->wrapUserInfoForMobile($this->user),
      );
    $this->success($data);
  }

  public function getUserInfoById(){
    $user_id = $this->_param('id','intval',0);
    if(!$user_id)
      $this->error(10001);
    $User = D('Tiantian://User');
    $user_data = $User->getUserInfo($user_id);
    if(!$user_data)
      $this->error(10006);
    $user_data = $User->wrapUserInfoForMobile($user_data);
    unset($user_data['email']);
    $data = array(
      'info'=>$user_data,
      );
    $this->success($data);
  }
}
