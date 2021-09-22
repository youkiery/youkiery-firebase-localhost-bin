<?php 

$name_sql = "select * from pet_test_item where name = '$data->name'";
$code_sql = "select * from pet_test_item where code = '$data->code'";
if (!empty(fetch($name_sql))) $result['messenger'] = 'Tên mặt hàng đã tồn tại'; 
else if (!empty(fetch($code_sql))) $result['messenger'] = 'Mã mặt hàng đã tồn tại'; 
else {
  $sql = "insert into pet_test_item (name, code, shop, storage, catid, border, image) values('$data->name', '$data->code', 0, 0, $data->cat, 10, '". str_replace('@@', '%2F', implode(', ', $data->image)) ."')";
  query($sql);

  $result['status'] = 1;
  $result['list'] = getList();
}

function getList() {
  global $data;
  
  $sql = "select * from pet_test_item where name like '%$data->keyword%' order by name asc";
  $list = all($sql);

  foreach ($list as $key => $value) {
    $list[$key]['image'] = explode(', ', $value['image']);

    $sql = "select a.name from pet_test_item_pos a inner join pet_test_item_pos_item b on a.id = b.posid where b.itemid = $value[id]";
    $list[$key]['position'] = all($sql);
  }

  return $list;
}