<?php 
class EventQrcodeModel extends Model{

  public function addEventQrcode($event_id,$name){
    $this->add(array('event_id'=>$event_id,'name'=>$name));
  }
  
  public function updateEventQrcode($id,$event_id,$name){
    $this->save(array('id'=>$id,'event_id'=>$event_id,'name'=>$name));
  }

}