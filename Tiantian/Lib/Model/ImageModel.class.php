<?php 
class ImageModel extends Model{

  public function addImage($name,$file_name,$size,$dir){
    import('@.ORG.Image');
    $url = file_domain('Public')."/${dir}/".$file_name;
    $img_info = Image::getImageInfo($url);
    $info = array(
      'name'=>$name,
      'file_name'=>$file_name,
      'file_dir'=>$dir,
      'url'=>$url,
      'size'=>$size,
      'type'=>$img_info['type'],
      'height'=>$img_info['height'],
      'width'=>$img_info['width'],
      'create_time'=>NOW_TIME,
      'status'=>1
      );
    $id = $this->add($info);
    if($id){
      $info['id']=$id;
      return $info;
    }else{
      return false;
    }
  }

  public function uploadImage($dir='image'){
    import('@.ORG.UploadFile');
    $upload = new UploadFile();
    $upload->maxSize = 3292200;
    $upload->allowExts = explode(',','jpg,png,jpeg');
    $upload->savePath  = "./Public/${dir}/";
    $upload->saveRule  = 'uniqid';
    if (!$upload->upload()) {
      return $upload->getErrorMsg();
    } else {
      $uploadList = $upload->getUploadFileInfo();
      $name = array_shift(explode(".",$uploadList[0]['savename']));
      $info = $this->addImage($name,$uploadList[0]['savename'],$uploadList[0]['size'],$dir);
      if($info)
        return $info;
      else
        return '上传失败';
    }
  }

  public function cropImage($info,$dir,$save_name,$coords,$width,$height){
    import('ORG.Util.Image.ThinkImage'); 
    $img = new ThinkImage(THINKIMAGE_GD);
    $src = $info['url'];
    $tmp_file=sys_get_temp_dir().'/'.$info['file_name'];
    $img->open($info['url'])->crop($coords[2],$coords[3],$coords[0],$coords[1],$width,$height)->save($tmp_file);
    file_upload($tmp_file,"./Public/${dir}/${save_name}.jpg");
    $size = filesize($tmp_file);
    return $this->addImage($save_name,$save_name.'.jpg',$size,$dir);
  }

  public function deleteImage($id){
    $info = $this->getImageInfo($id);
    $info['status'] = 0;
    return $this->save($info);
  }

  public function getImageInfo($id){
    return $this->find($id);
  }

  public function getImageUrl($id){
    return $this->where(array('id'=>$id))->getField('url');
  }
}

