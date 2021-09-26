<?php 

require_once(ROOTDIR .'/vaccine.php');
$vaccine = new Vaccine();

$sql = "insert into pet_test_type (name, code) values('$data->name', '$data->code')";
query($sql);
$result['status'] = 1;
$result['list'] = $vaccine->gettype();