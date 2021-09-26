<?php 

require_once(ROOTDIR .'/vaccine.php');
$vaccine = new Vaccine();

$sql = "update pet_test_type set name = '$data->name', code = '$data->code' where id = $data->id";
query($sql);
$result['status'] = 1;
$result['list'] = $vaccine->gettype();