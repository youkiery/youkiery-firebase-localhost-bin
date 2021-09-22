<?php 

require_once(ROOTDIR .'/spa.php');
$spa = new Spa();

$name = array();
$value = array();
foreach ($data->option as $n => $v) {
  $name[] = $n;
  $value[] = $v;
}

$sql = "select * from pet_test_customer where phone = '$data->phone'";
if (!empty($customer = $spa->fetch($sql))) {
  $sql = "update pet_test_customer set name = '$data->name' where id = $customer[id]";
  $spa->query($sql);
}
else {
  $sql = "insert into pet_test_customer (name, phone, address) values ('$data->name', '$data->phone', '')";
  $customer['id'] = $spa->insertid($sql);
}

$sql = "insert into pet_test_spa (customerid, doctorid, note, time, weight, " . implode(", ", $name) . ", image) values($customer[id], $userid, '$data->note', '" . time() . "', $data->weight, " . implode(", ", $value) . ", '". str_replace('@@', '%2F', implode(', ', $data->image))."')";
$spa->query($sql);  

$result['list'] = $spa->getList();
$result['status'] = 1;