<?php 

require_once(ROOTDIR .'/spa.php');
$spa = new Spa();

$sql = "select * from pet_test_customer where phone = '$data->phone'";
if (!empty($customer = fetch($sql))) {
  $sql = "update pet_test_customer set name = '$data->name' where id = $customer[id]";
  query($sql);
}
else {
  $sql = "insert into pet_test_customer (name, phone, address) values ('$data->name', '$data->phone', '')";
  $customer['id'] = insertid($sql);
}

$customer2 = array('id' => 0);
if (!empty($data->phone2) && !empty($data->name2)) {
  $sql = "select * from pet_test_customer where phone = '$data->phone2'";
  if (!empty($customer2 = fetch($sql))) {
    $sql = "update pet_test_customer set name = '$data->name2' where id = $customer2[id]";
    query($sql);
  }
  else {
    $sql = "insert into pet_test_customer (name, phone, address) values ('$data->name2', '$data->phone2', '')";
    $customer2['id'] = insertid($sql);
  }
}

$sql = "insert into pet_test_spa2 (customerid, customerid2, doctorid, note, time, utime, weight, image) values($customer[id], $customer2[id], $userid, '$data->note', '" . time() . "', '" . time() . "', $data->weight, '". str_replace('@@', '%2F', implode(', ', $data->image))."')";
$id = insertid($sql);

foreach ($data->option as $value) {
  $sql = "insert into pet_test_spa2_row (spaid, typeid) values($id, $value)";
  query($sql);
}

$result['list'] = $spa->getList();
$result['status'] = 1;