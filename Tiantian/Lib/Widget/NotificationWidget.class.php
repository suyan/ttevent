<?php 
class NotificationWidget extends Widget{
  public function render($data){
    $user_id = session(C('USER_AUTH_KEY'));
    $Notification = D('UserNotification');
    $count = $Notification->getNotificationsCount($user_id,1);
    import('ORG.Util.Page');
    $Page = new Page($count,10);
    $Page->setConfig('theme','<ul><li>%first%</li><li>%upPage%</li><li>%prePage%</li><li>%linkPage%</li><li>%nextPage%</li><li>%downPage%</li><li>%end%</li></ul>');
    $page_show = $Page->show();
    $notifications = $Notification->getNotifications($user_id,1,$Page->firstRow,$Page->listRows);
    return $this->renderFile('notification',array(
      'user_id'=>$user_id,
      'notifications'=>$notifications,
      'error'=>"<center>还没有消息</center>",
      'page'=>$page_show,
      ));
  }
}