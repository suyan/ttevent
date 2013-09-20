<?php
class CommonAction extends ApiAction {

  protected function _initialize() {//检查用户是否登录
    $token = $this->_param('token');
    if($token){
      $User = D('Tiantian://User');
      $this->user = $User->checkUserByToken($token,true);
      if(false == $this->user)
        $this->error(10004);
    }else{
      $this->error(10002);
    }
  }
}