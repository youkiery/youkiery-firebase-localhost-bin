<?php 

$sql = "select * from pet_test_customer where phone like '%$data->key%' limit 20";
$result['status'] = 1;
$list = all($sql);

foreach ($list as $index => $row) {
  $sql = "select id, name from pet_test_pet where customerid = $row[id]";
  $list[$index]['petlist'] = all($sql);
}
$result['list'] = $list;
