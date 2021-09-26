<?php 

require_once(ROOTDIR .'/vaccine.php');
$vaccine = new Vaccine();

$sql = "select * from pet_test_customer where phone = '$data->phone'";
if (!empty($customer = fetch($sql))) {
  $sql = "update pet_test_customer set name = '$data->name' where id = $customer[id]";
  query($sql);
}
else {
  $sql = "insert into pet_test_customer (name, phone, address) values ('$data->name', '$data->phone', '')";
  $customer['id'] = insertid($sql);
}

$data->cometime = totime($data->cometime);
$data->calltime = totime($data->calltime);

$sql = "insert into pet_test_vaccine (customerid, typeid, cometime, calltime, note, status, called, recall, userid, time) values ($customer[id], $data->type, $data->cometime, $data->calltime, '', 0, 0, $data->calltime, $userid, ". time() .")";
query($sql);
$result['status'] = 1;
$result['new'] = $vaccine->getlist(true);
$result['old'] = $vaccine->getOlder($customer['id']);
