<?php 

foreach ($data->list as $key => $value) {
  $sql = "select * from pet_test_item_pos_item where posid = $data->posid and itemid = $value->id";
  if (empty(fetch($sql))) {
    $sql = "insert into pet_test_item_pos_item (posid, itemid) values($data->posid, $value->id)";
    query($sql);
  }
}

$sql = "select b.id, a.name from pet_test_item a inner join pet_test_item_pos_item b on a.id = b.itemid where b.posid = $data->posid";
$result['list'] = all($sql);
$result['status'] = 1;
