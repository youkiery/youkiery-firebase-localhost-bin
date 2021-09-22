<?php 

$limit = time() * 60 * 60 * 24 * 60;
$sql = "select a.id, b.name, a.expire from pet_test_item_expire a inner join pet_test_item b on a.rid = b.id where expire < $limit";
$list = all($sql);

foreach ($list as $key => $value) {
  $list[$key]['expire'] = date('d/m/Y', $value['expire']);
}

$result['status'] = 1;
$result['list'] = $list;