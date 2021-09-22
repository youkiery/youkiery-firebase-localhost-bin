<?php 

$sql = "select * from pet_test_item_pos order by name asc";
$list = all($sql);

foreach ($list as $key => $value) {
  $sql = "select * from pet_test_item a inner join pet_test_item_pos_item b on a.id = b.itemid where b.posid = $value[id]";
  $list[$key]['position'] = all($sql);
}

$result['status'] = 1;
$result['list'] = $list;
