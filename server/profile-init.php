<?php 

$filter = array(
  'keyword' => parseGetData('keyword', ''),
  'page' => parseGetData('page', 1),
);

$sql = 'select id, name, customer, phone, time from pet_test_profile where phone like "%'. $filter['keyword'] .'%" or customer like "%'. $filter['keyword'] .'%" order by id desc limit 10 offset '. ($filter['page'] - 1) * 10;
$query = $mysqli->query($sql);
$list = array();

while ($row = $query->fetch_assoc()) {
  $list []= $row;
}

$result['status'] = 1;
$result['list'] = $list;
