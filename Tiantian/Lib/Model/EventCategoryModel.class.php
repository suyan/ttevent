<?php
class EventCategoryModel extends RelationModel{
  public function decCategoryCount($category_id){
    return $this->save(array(
      'id'=>$category_id,
      'count'=>array('exp','count-1')
      ));
  }

  public function incCategoryCount($category_id){
    return $this->save(array(
      'id'=>$category_id,
      'count'=>array('exp','count+1')
      ));
  }

  public function getAllCategories(){
    return $this->cache(true,60)->select();
  }

  public function getCategory($category_id){
    return $this->find($category_id);
  }

  public function getCategoryName($category_id){
    return $this->where(array('id'=>$category_id))->getField('name');
  }

  public function getAllCategoriesJson(){
    $categories = $this->cache(true)->field('id,name,count')->where(array('level'=>1))->order('count desc')->select();
    $ret = array();
    foreach($categories as $value){
      $ret[$value['id']] = $value['name'];
    }
    return json_encode($ret);
  }

  public function getSubCategoriesJson($id){
    $categories = $this->cache(true)->field('id,name,count')->where(array('parent_id'=>$id))->order('count desc')->select();
    $ret = array();
    foreach($categories as $value){
      $ret[$value['id']] = $value['name'];
    }
    return json_encode($ret);
  }

}