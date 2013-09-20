<?php
class IndexAction extends Action {

  public function index(){
    $this->navs = array(
      'User'=>'用户',
      'Event'=>'活动',
      'Api'=>'接口'
      );
    if(isset($_GET['topic']) && array_key_exists($_GET['topic'], $this->navs)){
      $this->topic = $_GET['topic'];
      $result = A($this->topic)->run();
      $this->lists = $result['lists'];
      $this->content = $result['content'];
    }else{
      $this->content = "<p class='alert alert-error'>请选择要测试的模块</p>";
    }
    $this->display();
  }
}
