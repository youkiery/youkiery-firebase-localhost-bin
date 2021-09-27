<?php 

require_once(ROOTDIR .'/spa.php');
$spa = new Spa();

if (!empty($data->uid)) $sql = "update pet_test_spa2 set utime = ". time() .",  status = 1, duser = $data->uid where id = $data->id";
else $sql = "update pet_test_spa2 set utime = ". time() .", status = 1 where id = $data->id";
query($sql);

$result['status'] = 1;