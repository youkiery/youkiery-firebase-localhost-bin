<?php 

require_once(ROOTDIR .'/drug.php');
$drug = new Drug();

if (empty($msg = $drug->update($data))) {
  $result['status'] = 1;
  $result['data'] = $drug->select($data->id);
}
else {
  $result['messenger'] = $msg;
}
