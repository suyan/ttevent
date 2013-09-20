<?php
class UserProfileModel extends RelationModel{

  public function getUserProfile($user_id){
    return $this->where(array('user_id'=>$user_id))->find();
  }

  public function updateUserProfile($profile){
    return $this->where(array('user_id'=>$profile['user_id']))->save($profile);
  }
}