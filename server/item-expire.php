<?php 

$sql = "select * from pet_test_item where code = '$data->name'";
if (empty($item = fetch($sql))) {
  $sql = "insert into pet_test_item (name, code, shop, storage, catid, border, image) values('$data->name', '$data->code', 0, 0, 0, 10, '')";
  $item['id'] = insertid($sql);
}

$data->expire = totime($data->expire);
$sql = "insert into pet_test_item_expire (rid, number, expire, time) values($item[id], $data->number, $data->expire, ". time() .")";
query($sql);
$result['status'] = 1;
$result['messenger'] = 'Đã thêm hạn sử dụng';
