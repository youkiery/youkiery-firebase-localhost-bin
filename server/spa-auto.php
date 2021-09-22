<?php 

require_once(ROOTDIR .'/spa.php');
$spa = new Spa();

$data->ctime = $data->ctime / 1000;
$today = date('d/m/Y');
$ctime = date('d/m/Y', $data->ctime);

if ($today !== $ctime) {
  $result['status'] = 1;
  $result['list'] = $spa->getList();
}
else {
  $sql = "select id from pet_test_spa where utime > $data->ctime";
  $result['status'] = 1;

  if (!empty(fetch($sql))) {
    $result['list'] = $spa->getList();
  }
}

if (empty($result['list'])) $result['list']= array();

