<?php 

require_once(ROOTDIR .'/spa.php');
$spa = new Spa();

$sql = "update pet_test_spa set status = 1 where id = $data->id";
$spa->query($sql);

$result['status'] = 1;