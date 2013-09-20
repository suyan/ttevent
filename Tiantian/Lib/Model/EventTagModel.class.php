<?php
class EventTagModel extends RelationModel{
  protected $_link = array(
    'Event' => array(
      'mapping_type' => MANY_TO_MANY,
      'class_name' => 'Event',
      'foreign_key'=>'tag_id',
      'relation_foreign_key'=>'event_id',
      'relation_table' => 'tt_event_event_tag',
      ),
    );

  public function addEventTag($name){
    return $this->add(array('name'=>$name));
  }

  public function getEventTagByName($tag){
    return $this->where(array('name'=>$tag))->find();
  }

  public function getEventTags($tag){
    return $this->where(array('name'=>array('like',"%${tag}%")))->select();
  }

  public function getJsonEventTags($tag){
    $ret = $this->getEventTags($tag);
    $tags = array();
    foreach($ret as $value){
      $tags[] = array('tag'=>$value['name']);
    }
    return json_encode(array('tags'=>$tags));
  }
}