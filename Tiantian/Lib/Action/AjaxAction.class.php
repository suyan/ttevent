<?php 
class AjaxAction extends Action{
  public function getRegion(){
    $id = $this->_param('id','intval',0);
    if(!$id){
      echo D('Region')->getAllProvincesJson();
    }else{
      echo D('Region')->getSubRegionJson($id);
    }
  }

  public function getCategory(){
    $id = $this->_param('id','intval',0);
    if(!$id){
      echo D('EventCategory')->getAllCategoriesJson();
    }else{
      echo D('EventCategory')->getSubCategoriesJson($id);
    }
  }
}

