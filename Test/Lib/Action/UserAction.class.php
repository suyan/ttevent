<?php 
class UserAction extends CommonAction{

  public function testUserLogin(){
    $User = D('Tiantian://User');
    $user_data = $User->relation(true)->find();
    //令此用户登录
    $token = $User->userLogin($user_data['id']);
    //检查登录次数来确定成功
    if($token)
      $this->success($token);
    else
      $this->error($User->getLastSql());
  }

}
