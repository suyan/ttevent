<?php
class ApiAction extends Action{

  public function success($message,$jumpUrl='',$ajax=true){
    $data['info'] = $message;
    $data['status'] = 1;
    header('Content-Type:application/json; charset=utf-8');
    exit(json_encode($data));
  }

  public function error($errno,$message='',$jumpUrl='',$ajax=true){
    if(C('ERROR.'.$errno)){
      $data['info'] = array('error_code'=>$errno,'error_msg'=>C('ERROR.'.$errno));
    }else{
      $data['info'] = array('error_code'=>$errno,'error_msg'=>$message);
    }
    $data['status'] = 0;
    header('Content-Type:application/json; charset=utf-8');
    exit(json_encode($data));
  }
}