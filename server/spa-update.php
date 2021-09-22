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

$sql = "update pet_test_spa set customerid = $customer[id], customerid2 = $customer2[id], doctorid = $userid, note = '$data->note', image = '". str_replace('@@', '%2F', implode(', ', $data->image))."', weight = $data->weight, utime = ". time() .", luser = $userid, ltime = ". time() ." where id = $data->id";
query($sql);  

$sql = "delete from pet_test_spa_row where spaid = $data->id";
query($sql);

foreach ($data->option as $value) {
  $sql = "insert into pet_test_spa_row (spaid, typeid) values($data->id, $value)";
  query($sql);
}

$result['list'] = $spa->getList();
$result['status'] = 1;
