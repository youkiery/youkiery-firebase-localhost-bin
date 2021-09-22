<?php 

$sql = "select * from pet_test_customer where phone = '$data->phone'";
if (empty($c = fetch($sql))) {
  $sql = "insert into pet_test_customer (name, phone, addess) values('$data->customer', '$data->phone', '')";
  $c['id'] = insertid($sql);
}

$sql = "insert into pet_test_pet (name, customerid) values('$data->name', $c[id])";
$p['id'] = insertid($sql);

$sql = "select id, name from pet_test_pet where customerid = $c[id]";
$list = all($sql);

$result['status'] = 1;
$result['petid'] = $p['id'];
$result['petlist'] = $list;
