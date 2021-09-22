<?php 

$image = '';
foreach ($data->image as $value) {
  if (strlen($value) > 50) $image = $value;
}

$sql = "update pet_test_item_pos set name = '$data->pos', image = '$image' where id = $data->id";
query($sql);

$result['status'] = 1;
