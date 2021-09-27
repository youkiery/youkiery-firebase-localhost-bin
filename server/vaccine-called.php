<?php 

require_once(ROOTDIR .'/vaccine.php');
$vaccine = new Vaccine();

$sql = "update pet_test_vaccine2 set status = 1, note = '". $data->note ."', called = ". time() .", recall = ". (time() + 60 * 60 * 24 * 7) ." where id = $data->id";
query($sql);
$result['status'] = 1;
$result['list'] = $vaccine->getlist();
