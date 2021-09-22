<?php 

$result['status'] = 1;
$result['list'] = getList();
return $result;

function getList() {
  global $data;
  
  $sql = "select * from pet_test_item where name like '%$data->keyword%' order by name asc";
  $list = all($sql);

  foreach ($list as $key => $value) {
    $list[$key]['image'] = explode(', ', $value['image']);

    $sql = "select a.id, a.name from pet_test_item_pos a inner join pet_test_item_pos_item b on a.id = b.posid where b.itemid = $value[id]";
    $list[$key]['position'] = all($sql);
  }

  return $list;
}