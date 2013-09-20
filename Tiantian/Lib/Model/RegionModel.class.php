<?php
class RegionModel extends RelationModel{

  public function getLocationById($province_id,$city_id,$area_id){
    $Region = D('Region');
    $province = $Region->field('id,name')->find($province_id);
    $city = $Region->field('id,name')->find($city_id);
    $area = $Region->field('id,name')->find($area_id);
    return array(
      'province'=>$province,
      'city'=>$city,
      'area'=>$area
      );
  }

  public function getLocationStringById($province_id,$city_id,$area_id){
    $Region = D('Region');
    $province = $Region->field('id,name')->find($province_id);
    $city = $Region->field('id,name')->find($city_id);
    $area = $Region->field('id,name')->find($area_id);
    return $province['name'].' '.$city['name'].' '.$area['name'];
  }   

  public function getAllRegions(){
    return $this->cache(true)->select();
  }

  public function getAllProvincesJson(){
    $provinces = $this->cache(true)->field('id,name,count')->where(array('level'=>1))->order('count desc')->select();
    $ret = array();
    foreach($provinces as $value){
      $ret[$value['id']] = $value['name'];
    }
    return json_encode($ret);
  }

  public function getSubRegionJson($id){
    $region = $this->cache(true)->field('id,name,count')->where(array('parent_id'=>$id))->order('count desc')->select();
    $ret = array();
    foreach($region as $value){
      $ret[$value['id']] = $value['name'];
    }
    return json_encode($ret);
  }

  public function incRegionCount($id){
    return $this->where(array('id'=>$id))->setInc('count');
  }

  public function decRegionCount($id){
    return $this->where(array('id'=>$id))->setDec('count');
  }
}