<?php 

require_once(ROOTDIR .'/vaccine.php');
$vaccine = new Vaccine();

$sql = "update pet_test_vaccine set status = 3, note = '$data->note' where id = $data->id";
query($sql);
$result['status'] = 1;
$result['list'] = $vaccine->getlist();