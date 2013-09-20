<?php
class IndexAction extends Action {

  public function update(){
    header("Content-type: text/html; charset=utf-8"); 
    //抓取活动列表页面
    vendor('SimpleHtmlDom.simple_html_dom');
    $count = $this->_param('count','',2);
    $this->show('抓取n页数据'.$count.'<br>');
    ob_flush();flush();
    for($i=0;$i<=$count;$i++){
      $this->show('第'.$i.'页开始抓抓取<br>');
      ob_flush();flush();
      $page = 10*$i;
      $html = file_get_html('http://beijing.douban.com/events/future-all?start='.$page);
      foreach($html->find('ul.events-list li.list-entry') as $li){
        //获得活动名称
        $title = $li->find('div.info div.title a span',0)->innertext;
        if(D('Event')->where(array('name'=>$title))->find()){
          break;//已存在活动就跳过
        }

        $data = array();
        $data['name']=$title;
        $data['user_id'] = 1;
        $data['type'] = 1;
        $data['create_time'] = NOW_TIME;
        $data['update_time'] = NOW_TIME;
        $data['status'] = 2;

        //获得链接地址
        $url = $li->find('div.pic a',0)->href;
        $event = file_get_html($url);
        $event_poster = $event->find('#poster_img',0)->src;
        $img = file_get_contents($event_poster);
        $file_name = uniqid();
        $img_name = sys_get_temp_dir().'/'.$file_name.'.jpg';
        file_put_contents($img_name, $img);//写入图像
        file_upload($img_name,'./Public/image/'.$file_name.'.jpg');
        $size = filesize($img_name);
        $Image = D('Image');
        $img_info = $Image->addImage($file_name,$file_name.'.jpg',$size,'image');

        $data['src_img'] = $img_info['id'];
        $data['large_img'] = $img_info['id'];
        $data['middle_img'] = $img_info['id'];
        $data['small_img'] = $img_info['id'];

        $event_info = $event->find('div.event-info',0);
        $time = $event_info->find('div.event-detail',0);
        $start_time = $time->find('time',0)->datetime;
        $end_time = $time->find('time',1)->datetime;

        $data['start_time'] = strtotime($start_time);
        $data['end_time'] = strtotime($end_time);
        $data['schedule'] = json_encode(array(
          $data['start_time']=>'活动开始',
          $data['end_time']=>'活动结束',
          ));

        $location = $event_info->find('div.event-detail',1);
        $city = rtrim($location->find('span[itemprop="region"]',0)->innertext,'&nbsp;');
        $locality = rtrim($location->find('span[itemprop="locality"]',0)->innertext,'&nbsp;');
        $street = $location->find('span[itemprop="street-address"]',0)->innertext;
        $province_id = D('Region')->where(array('name'=>'北京'))->getField('id');
        if($province_id)
          D('Region')->incRegionCount($province_id);
        $city_id = D('Region')->where(array('name'=>$city,'level'=>2))->getField('id');
        if($city_id)
          D('Region')->incRegionCount($city_id);
        $area_id = D('Region')->where(array('name'=>$locality,'level'=>3))->getField('id');
        if($area_id)
          D('Region')->incRegionCount($area_id);
        $data['province_id'] = $province_id;
        $data['city_id'] = $city_id;
        $data['area_id'] = $area_id;
        $data['location'] = $street;

        $category = $event_info->find('div.event-detail',3);
        $category = $category->find('a',0)->innertext;
        $category = explode('-', $category);

        if(isset($category[0])){
          $category_id = D('EventCategory')->where(array('name'=>$category[0]))->getField('id');
          $data['category_id'] =$category_id;
          D('EventCategory')->incCategoryCount($category_id);
        }
        if(isset($category[1])){
          $sub_category_id= D('EventCategory')->where(array('name'=>$category[1]))->getField('id');
          $data['sub_category_id'] = $sub_category_id;
          D('EventCategory')->incCategoryCount($sub_category_id);
        }

        $description = $event->find('#edesc_f',0)->innertext;
        $data['description'] = $description;
        D('Event')->add($data);
        D('User')->incUserEventCount(1);
        D('Setting')->incKey('event_count');
        $this->show('活动'.$data['name'].'抓取完成<br>');
        ob_flush();flush();
      }
      $this->show('第'.$i.'页抓取完成<br>');
      ob_flush();flush();
    }
  }

  public function reset(){
    //清空数据库
    $query = array(
      "TRUNCATE `tt_event`;",
      "TRUNCATE `tt_event_comment`;",
      "TRUNCATE `tt_event_event_tag`;",
      "TRUNCATE `tt_event_feed`;",
      "TRUNCATE `tt_event_follow`;",
      "TRUNCATE `tt_event_join`;",
      "TRUNCATE `tt_event_qrcode`;",
      "TRUNCATE `tt_event_tag`;",
      "TRUNCATE `tt_session`;",
      "TRUNCATE `tt_user`;",
      "TRUNCATE `tt_image`;",
      "TRUNCATE `tt_user_feed`;",
      "TRUNCATE `tt_user_follow`;",
      "TRUNCATE `tt_user_notification`;",
      "TRUNCATE `tt_user_profile`;",
      "UPDATE `tt_event_category` SET count =0;",
      "UPDATE `tt_region` SET count =0;",
      "UPDATE `tt_setting` SET `value` = '0' WHERE `id` = 1;",
      "UPDATE `tt_setting` SET `value` = '0' WHERE `id` = 2;"
      );
    foreach($query as $value){
      M()->execute($value);
    }
    //清空session
    session(null);
    //清空文件
    $files = array(
      './Public/upload/',
      './Public/temp/',
      './Public/qrcode/',
      './Public/image/',
      './Tiantian/Runtime/'
      );
    foreach($files as $file){
      $this->delete_file($file);
    }
    $this->show('ok');
  }

  public function delete_file($dir,$self=false){
    if(false === is_dir($dir)){
      if($self==false)
        return false;
      unlink($dir);
      return true;
    }
    if($handle = opendir($dir)){
      while (false !== ($file = readdir($handle))){
        if($file=='.' OR $file=='..')
          continue;
        $file=$dir.$file;
        if(is_file($file)){
          unlink($file);
        }else if(is_dir($file)){
          $this->delete_file($file.DIRECTORY_SEPARATOR,true);
        }
      }
      closedir($handle);
      if($self==true)
        rmdir($dir);
    }
  }
}
