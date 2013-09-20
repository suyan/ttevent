<?php 
class UserFollowModel extends Model{
  public function isFollowed($user_id,$follow_id){
    $follow = $this->where(array(
      'user_id'=>$user_id,
      'follow_id'=>$follow_id
      ))->find();
    if(!$follow || $follow['status']==0)
      return false;
    return true;
  }

  public function followUser($user_id,$follow_id){
    $follow = $this->where(array('user_id'=>$user_id,'follow_id'=>$follow_id))->find();
    if($follow){//已有此人数据
      if($follow['status']!=0)
        return false;
      $follow['create_time']=NOW_TIME;
      $follow['status'] = 1;
      $id = $this->save($follow);
    }else{//第一次关注
      $id = $this->add(array(
        'user_id'=>$user_id,
        'follow_id'=>$follow_id,
        'create_time'=>NOW_TIME,
        'status'=>1
        ));
    }
    if($id){
      $User = D('User');
      $User->incUserFollowCount($user_id);
      $User->incFollowCount($follow_id);
      $user_info = $User->getUserInfo($id);
      $notification = json_encode(array(
        'user'=>array('id'=>$user_info['id'],'nickname'=>$user_info['nickname']),
        ));
      D('UserNotification')->addNotification($id,$follow_id,2,$notification);
    }
    return $id;
  }

  public function unfollowUser($user_id,$follow_id){
    $id = $this->where(array(
      'user_id'=>$user_id,
      'follow_id'=>$follow_id
      ))->save(array(
        'status'=>0
      ));
    if($id){
      D('User')->decUserFollowCount($user_id);
      D('User')->decFollowCount($follow_id);
    }
    return $id;
  }

  public function getUserFollows($user_id){
    return $this->where(array('user_id'=>$user_id,'status'=>array('gt',0)))->select();
  }

  public function getUserFollowsCount($user_id){
    return D('User')->where(array('user_id'=>$user_id))->getField('user_follow');
  }

  public function getUserFollowIds($user_id,$limit=0,$count=10){
    return $this->where(array('user_id'=>$user_id,'status'=>array('gt',0)))->field('follow_id')->limit($limit,$count)->select();
  }
}