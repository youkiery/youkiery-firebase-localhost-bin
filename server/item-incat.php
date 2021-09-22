<?php 

$sql = "select * from pet_test_item_cat where name = '$data->cat'";
if (!empty($row = fetch($sql))) $result['messenger'] = 'Danh mục đã tồn tại';
else {
  $sql = "insert into pet_test_item_cat (name) values('$data->cat')";
  $result['status'] = 1;
  $result['cat'] = insertid($sql);
  $result['catlist'] = getCatList();
}

function getCatList() {
  global $data, $mysqli;
  
  $sql = "select * from pet_test_item_cat order by name asc";
  return array_merge(array(array('id' => 0, 'name' => 'Chưa phân loại')), all($sql));
}
