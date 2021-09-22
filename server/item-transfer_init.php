<?php 

$sql = "select name, storage, shop from pet_test_item where shop < border and storage > 0 order by name asc";
$list = all($sql);

$result['status'] = 1;
$result['list'] = $list;