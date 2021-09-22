<?php 

$result['status'] = 1;
$result['purchase'] = getPurchase();
$result['transfer'] = getTransfer();
$result['expired'] = getExpire();
$result['catlist'] = getCatList();
$result['all'] = getSuggestList();
$result['image'] = getImagePos();
$result['list'] = getList();

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

function getPurchase() {
  global $data, $mysqli;

  $sql = "select count(*) as number from pet_test_item where storage + shop < border";
  $number = fetch($sql);
  return $number['number'];
}

function getTransfer() {
  global $data, $mysqli;

  $sql = "select count(*) as number from pet_test_item where shop < border and storage > 0";
  $number = fetch($sql);
  return $number['number'];
}

function getExpire() {
  global $data, $mysqli;

  $limit = time() * 60 * 60 * 24 * 60;
  $sql = "select count(*) as number from pet_test_item_expire where expire < $limit";
  $number = fetch($sql);
  return $number['number'];
}

function getCatList() {
  global $data, $mysqli;
  
  $sql = "select * from pet_test_item_cat order by name asc";
  return array_merge(array(array('id' => "0", 'name' => 'Chưa phân loại')), all($sql));
}

function getSuggestList() {
  global $data, $mysqli;
  
  $sql = "select id, name from pet_test_item order by name asc";
  $list = all($sql);
  foreach ($list as $key => $value) {
    $list[$key]['alias'] = lower($value['name']);
  }
  return $list;
}

function getImagePos() {
  global $data, $mysqli;
  
  $sql = "select id, image from pet_test_item_pos order by name asc";
  return obj($sql, 'id', 'image');
}
