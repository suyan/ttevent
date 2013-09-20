<?php 
class EventCommentModel extends Model{
  public function commentEvent($user_id,$event_id,$content){
    $id = $this->add(array(
      'user_id'=>$user_id,
      'event_id'=>$event_id,
      'create_time'=>time(),
      'status'=>1,
      'content'=>$content
      ));
    if($id){
      //添加评论数
      $Event = D('Event');
      $event = $Event->find($event_id);
      $Event->save(array(
        'id'=>$event_id,
        'comment_count'=>array('exp','comment_count+1'),
        ));
      $user = D('User')->getUserInfo($user_id);
      //构造消息内容，尽量精简内容
      $notification = json_encode(array(
        'user'=>array('id'=>$user['id'],'nickname'=>$user['nickname']),
        'event'=>array('id'=>$event['id'],'name'=>$event['name'],),
        'content'=>$content,
        ));
      D('UserNotification')->addNotification($user_id,$event['user_id'],1,$notification);
    }
    return $id;
  }

  public function getEventCommentsCount($event_id){
    return $this->where(array(
      'event_id'=>$event_id,
      'status'=>1,
      ))->count();
  }

  public function getEventComments($event_id,$limit=0,$count=5){
    $event_comment_table = C('DB_PREFIX').'event_comment';
    $user_table = C('DB_PREFIX').'user';
    return $this->Table("$event_comment_table as c")
                ->join("$user_table as u ON c.user_id = u.id")
                ->where("c.event_id = $event_id AND  c.status <> 0")
                ->field('c.id,c.user_id,c.event_id,c.create_time,c.content,c.status,u.nickname,u.email,u.update_time,u.large_img,u.middle_img,u.small_img')
                ->order('c.create_time desc')
                ->limit($limit,$count)
                ->select();
  }

  public function deleteEventComments($event_id){
    $comment = array('status'=>0);
    return $this->where(array('event_id'=>$event_id))->save($comment);
  }
}
