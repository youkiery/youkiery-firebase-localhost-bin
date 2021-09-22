<?php 

require_once(ROOTDIR .'/spa.php');
$spa = new Spa();

$sql = "update pet_test_spa set utime = ". time() .",  status = 1, duser = $userid where id = $data->id";
query($sql);

$result['status'] = 1;