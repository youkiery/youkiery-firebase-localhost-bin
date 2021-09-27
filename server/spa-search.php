<?php 

require_once(ROOTDIR .'/spa.php');
$spa = new Spa();

$sql = "select a.*, b.name, b.phone, c.first_name as user from pet_test_spa2 a inner join pet_test_customer b on a.customerid = b.id inner join pet_users c on a.doctorid = c.userid where (b.name like '%$data->keyword%' or b.phone like '%$data->keyword%') order by time desc limit 30";
$spa = all($sql);

$list = array();
foreach ($spa as $key => $row) {
  $sql = "select b.value from pet_test_spa2_row a inner join pet_test_config2 b on a.spaid = $row[id] and a.typeid = b.id";
  $service = arr($sql, 'value');

  $sql = "select first_name as name from pet_users where userid = $row[duser]";
  $d = fetch($sql);

  $image = explode(', ', $row['image']);
  $list []= array(
    'id' => $row['id'],
    'name' => $row['name'],
    'phone' => $row['phone'],
    'duser' => (empty($d['name']) ? '' : $d['name']),
    'note' => $row['note'],
    'status' => $row['status'],
    'image' => (count($image) && !empty($image[0]) ? $image : array()),
    'time' => date('d/m/Y H:i', $row['time']),
    'service' => (count($service) ? implode(', ', $service) : '-')
  );
}

$result['status'] = 1;
$result['list'] = $list;
