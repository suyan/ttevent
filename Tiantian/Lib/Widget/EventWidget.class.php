<?php 
class EventWidget extends Widget{
  public function render($data){
    return $this->renderFile('event',$data);
  }
}