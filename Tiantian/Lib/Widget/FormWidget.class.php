<?php 
class FormWidget extends Widget{

  public function render($data){
    if(isset($data['modal'])&&$data['modal'])
      $file_name = 'modal_form';
    else
      $file_name = 'form';
    return $this->renderFile($file_name,$data);
  }
}