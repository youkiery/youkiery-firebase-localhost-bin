<?php 

require_once(ROOTDIR .'/usg.php');
$usg = new Usg();

$data = array(
  'text' => parseGetData('text', ''),
  'id' => parseGetData('id', ''),
);

$filter = array(
  'status' => parseGetData('status', 0),
  'keyword' => parseGetData('keyword', '')
);

$sql = 'update `pet_test_usg2` set note = "'. $data['text'] .'" where id = '. $data['id'];
$query = $mysqli->query($sql);

$result['status'] = 1;

echo json_encode($result);
die();
