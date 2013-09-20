<?php 
class UserNotificationModel extends Model{

  /**
   * 增加用户的描述
   * @param [type] $from_id 产生人id
   * @param [type] $to_id   接收人id
   * @param [type] $type    {1:活动被评论，2:自己被关注}
   * @param [type] $content json格式，包括了生成信息所需数据
   */
  public function addNotification($from_id,$to_id,$type,$content){
    return $this->add(array(
      'from_id'=>$from_id,
      'to_id'=>$to_id,
      'type'=>$type,
      'content'=>$content,
      'is_read'=>0,
      'create_time'=>time()
      ));
  }

  public function getNotifications($to_id,$is_read=0,$limit=0,$count=10){
    $where = array();
    $where['to_id'] = $to_id;
    if(!$is_read) $where['is_read'] = $is_read;
    $notifications = $this->where($where)->order('create_time desc')->limit($limit,$count)->select();
    if($notifications){
      foreach($notifications as $key=>$notification){
        $content = json_decode($notification['content'],true);
        $notifications[$key]['content'] = $content;
      }  
    }
    return $notifications;
  }

  public function getNotificationsCount($to_id,$is_read=0){
    $where = array();
    $where['to_id'] = $to_id;
    if(!$is_read) $where['is_read'] = $is_read;
    return $this->where($where)->count();
  }

  public function readAllNotifications($user_id){
    return $this->where(array('user_id'=>$user_id))->save(array('is_read'=>1));
  }

}
