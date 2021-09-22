<?php 

$image = '';
foreach ($data->image as $value) {
  if (strlen($value) > 50) $image = $value;
}

$sql = "insert into pet_test_item_pos (name, image) values('$data->pos', '$image')";

$result['status'] = 1;
$result['id'] = insertid($sql);
$result['image'] = $image;
