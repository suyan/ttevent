<?php 
function generate_qrcode($url){
  vendor('QRCode.phpqrcode');
  $name = uniqid().'.png';
  $tmp_file=sys_get_temp_dir().'/'.$name;
  $qrcode_name = C('QRCODE_PATH').'/'.$name;
  $level = 'L';
  $size = 4;
  QRcode::png($url, $tmp_file, 'L', 4, 2);
  file_upload($tmp_file,$qrcode_name);
  return $name;
}
