<?php 
class EventAction extends CommonAction{

  public function testCreateEvent(){
    //增加一条数据，然后再删掉
    $data = array(
      'user_id'=>1,
      'name'=>'test'
      );
    $Event = D('Event');
    $EventComment = D('EventComment');
    $EventFeed = D('EventFeed');
    if($id = $Event->createEvent($data)){
      $this->info('插入成功，id ='.$id);
      $Event->deleteEvent($id,true);
    }else{
      $this->error($Event->getLastSql());
    }
  }  
}
