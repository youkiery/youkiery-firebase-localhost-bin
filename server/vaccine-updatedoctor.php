<?php 

require_once(ROOTDIR .'/vaccine.php');
$vaccine = new Vaccine();

$sql = "update pet_test_doctor set userid = $data->user, name = '$data->name' where id = $data->id";
query($sql);
$result['status'] = 1;
$result['list'] = $vaccine->getDoctor();