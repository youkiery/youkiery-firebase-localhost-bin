<?php 

require_once(ROOTDIR .'/vaccine.php');
$vaccine = new Vaccine();

$sql = "update pet_test_vaccine2 set status = 2 where id = $data->id";
query($sql);
$result['status'] = 1;
$result['list'] = $vaccine->getlist();
