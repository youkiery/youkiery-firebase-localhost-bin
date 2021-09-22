<?php 

$sql = "select name, code from pet_test_item where name like '%$data->key%'";
  
$result['status'] = 1;
$result['list'] = all($sql);
