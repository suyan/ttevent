<?php 
class SettingModel extends Model{
  public function addKey($key,$value,$status=1){
    if($this->getKey($key,$status))
      $this->where(array('key'=>$key))->save(array('value'=>$value,'status'=>$status));
    else
      $this->add(array('key'=>$key,'value'=>$status,'status'=>$status));
  }

  public function getKey($key,$status=1){
    return $this->where(array('key'=>$key,'status'=>$status))->find();
  }

  public function updateKey($key,$value,$status=1){
    $this->where(array('key'=>$key))->save(array('value'=>$value,'status'=>$status));
  }

  public function incKey($key){
    $this->where(array('key'=>$key))->setInc('value');
  }
}