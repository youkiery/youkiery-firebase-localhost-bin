<?php 

require_once(ROOTDIR .'/vaccine.php');
$vaccine = new Vaccine();

$sql = "insert into pet_test_doctor (userid, name) values('$data->user', '$data->name')";
query($sql);
$result['status'] = 1;
$result['list'] = $vaccine->getDoctor();