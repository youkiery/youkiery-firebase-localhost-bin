<?php 

$sql = "select name, storage + shop as number from pet_test_item where storage + shop < border order by name asc";
$list = all($sql);

$result['status'] = 1;
$result['list'] = $list;