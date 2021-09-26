<?php 

require_once(ROOTDIR .'/vaccine.php');
$vaccine = new Vaccine();

$sql = "select userid, username, concat(last_name, ' ', first_name) as name from pet_users where (last_name like '%$data->keyword%' or first_name like '%$data->keyword%' or username like '%$data->keyword%') and userid not in (select userid from pet_test_doctor)";
$result['status'] = 1;
$result['list'] = all($sql);