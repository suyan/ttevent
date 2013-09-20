<?php 
class CommentWidget extends Widget{
  public function render($data){
    $event_id = $data['event_id'];
    $Comment = D('EventComment');
    $count = $Comment->getEventCommentsCount($event_id);
    import('ORG.Util.Page');
    $Page = new Page($count,10);
    $Page->setConfig('theme','<ul><li>%first%</li><li>%upPage%</li><li>%prePage%</li><li>%linkPage%</li><li>%nextPage%</li><li>%downPage%</li><li>%end%</li></ul>');
    $page_show = $Page->show();
    $comments = $Comment->getEventComments($event_id,$Page->firstRow,$Page->listRows);
    foreach($comments as $key=>$value){
      $comments[$key]=D('User')->wrapUserInfo($value);
    }
    return $this->renderFile('comment',array(
      'event_id'=>$event_id,
      'comments'=>$comments,
      'error'=>"<center>还没有评论</center>",
      'page'=>$page_show,
      ));
  }
}