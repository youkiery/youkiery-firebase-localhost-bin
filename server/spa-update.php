<?php 

require_once(ROOTDIR .'/spa.php');
$spa = new Spa();

$xtra = array();
foreach ($data->option as $n => $v) {
  $xtra []= $n . ' = '. $v;
}
$xtra = implode(', ', $xtra);

$sql = "select * from pet_test_customer where phone = '$data->phone'";
if (!empty($customer = $spa->fetch($sql))) {
  $sql = "update pet_test_customer set name = '$data->name' where id = $customer[id]";
  $spa->query($sql);
}
else {
  $sql = "insert into pet_test_customer (name, phone, address) values ('$data->name', '$data->phone', '')";
  $customer['id'] = $spa->insertid($sql);
}

$sql = "update pet_test_spa set customerid = $customer[id], doctorid = $userid, note = '$data->note', image = '". str_replace('@@', '%2F', implode(', ', $data->image))."', weight = $data->weight, $xtra where id = $data->id";
$spa->query($sql);  

$result['list'] = $spa->getList();
$result['status'] = 1;