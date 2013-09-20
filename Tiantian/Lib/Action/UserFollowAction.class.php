<?php 
class UserFollowAction extends CommonAction{
  public function followUser(){
    $user_id = session(C('USER_AUTH_KEY'));
    $follow_id = $this->_param('id','intval');
    if(!$user_id){
      $this->error('请先登录');
    }
    $uf = D('UserFollow');
    if($uf->followUser($user_id,$follow_id)){
      $this->success('关注成功');
    }else{
      $this->error("关注失败");  
    }
  }

  public function unfollowUser(){
    $user_id = session(C('USER_AUTH_KEY'));
    $follow_id = $this->_param('id','intval');
    if(!$user_id){
      $this->error('请先登录');
    }
    $uf = D('UserFollow');
    if($uf->unfollowUser($user_id,$follow_id)){
      $this->success('取消关注成功');
    }else{
      $this->error("关注失败");  
    }
  }

}