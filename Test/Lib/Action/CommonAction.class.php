<?php 
class CommonAction extends Action{
  public $content = '';
  public $lists = array();

  public function run(){
    $this->start($this);
    return array(
      'content'=>$this->content,
      'lists'=>$this->lists,
      );
  }

  protected function start(&$class){
    $class_name = get_class($class);
    $rf_class = new ReflectionClass($class_name);
    $methods = $rf_class->getMethods(ReflectionMethod::IS_PUBLIC);
    foreach($methods as $method) {
      //新处理一个函数
      if($method->class == $class_name && preg_match('/test.*/i',$method->name)){
        $class->content .= "<tr id='$method->name' class='info'><td colspan='2' style='text-align:center;'><strong>$class_name  ::  $method->name</strong></td></tr>";
        $class->lists[$method->name] = "#$method->name";
        $method->invoke($class);
      }
    }
  }

  protected function info($info){
    $backtrace = debug_backtrace();
    $topic = 'Line : '.$backtrace[0]['line'];
    if(is_string($info)){
      if(is_array($json = json_decode($info,true)))
        $info = dump($json,false);
    }else if(is_array($info)){
      $info = dump($info,false);
    }
    $this->content .= "<tr><td>$topic</td><td>$info</td></tr>";
  }

  protected function error($error,$a='',$b=''){
    $backtrace = debug_backtrace();
    $topic = 'Line : '.$backtrace[0]['line'];
    if(is_string($error)){
      if(is_array($json = json_decode($error,true)))
        $error = dump($json,false);
    }else if(is_array($error)){
      $error = dump($error,false);
    }
    $this->content .= "<tr class='error'><td>$topic</td><td>$error</td></tr>";
  }

  protected function success($success,$a='',$b=''){
    $backtrace = debug_backtrace();
    $topic = 'Line : '.$backtrace[0]['line'];
    if(is_string($success)){
      if(is_array($json = json_decode($success,true)))
        $success = dump($json,false);
    }else if(is_array($success)){
      $success = dump($success,false);
    }
    $this->content .= "<tr class='success'><td>$topic</td><td>$success</td></tr>";
  }

  public function curlget($url,$param=array()){//提交一个get请求
    if(!empty($param)){
      $args = '?';
      foreach($param as $key=>$value){
        $args .= $key.'='.$value.'&';
      }
      $url = $url.$args;  
    }
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $ret = curl_exec($curl);
    curl_close($curl);
    return $ret;
  }

  public function curlpost($url,$param=array()){//提交一个get请求
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, count($param));
    curl_setopt($curl, CURLOPT_POSTFIELDS,$param);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $ret = curl_exec($curl);
    curl_close($curl);
    return $ret;
  }
}
