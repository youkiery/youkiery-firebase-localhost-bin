<?php 

require_once(ROOTDIR .'/spa.php');
$spa = new Spa();


$sql = "select * from pet_test_user where userid = $userid and spa = 1";
if (!empty(fetch($sql))) {
  $sql = "select * from pet_test_doctor";
  $result['doctor'] = all($sql);
}
else $result['doctor'] = array();

$result['status'] = 1;
$result['time'] = time();
$result['type'] = $spa->getType();
$result['list'] = $spa->getList();
