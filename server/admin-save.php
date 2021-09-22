<?php

foreach ($data->module as $key => $value) {
  $sql = 'select * from pet_test_permission where module = "'. $key .'" and userid = '. $data->id;
  $query = $mysqli->query($sql);
  $type = intval($value);

  if (empty($query->fetch_assoc())) {
    $sql = 'insert into pet_test_permission (userid, module, type) values ('. $data->id .', "'. $key .'", '. $type .')';
  }
  else {
    $sql = 'update pet_test_permission set type = '. $type .' where module = "'. $key .'" and userid = '. $data->id;
  }
  $query = $mysqli->query($sql);
}

$sql = 'select * from pet_test_permission where userid = '. $userid;
$query = $mysqli->query($sql);
$list = array();
while ($row = $query->fetch_assoc()) {
  $list[$row['module']] = $row['type'];
} 

$result['status'] = 1;
$result['data'] = $data->module;
$result['config'] = $list;
