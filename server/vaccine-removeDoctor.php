<?php 

require_once(ROOTDIR .'/vaccine.php');
$vaccine = new Vaccine();

$sql = "delete from pet_test_doctor where id = $data->id";
query($sql);
$result['status'] = 1;
$result['list'] = $vaccine->getDoctor();