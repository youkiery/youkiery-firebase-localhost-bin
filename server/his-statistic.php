<?php 

$sql = "select a.*, b.name as pet, c.name as customer, c.phone, d.first_name as doctor from pet_test_xray a inner join pet_test_pet b on a.petid = b.id inner join pet_test_customer c on b.customerid = c.id inner join pet_users d on a.doctorid = d.userid where (a.time between ". isototime($data->filter->from) ." and ". isototime($data->filter->end) .") or (a.time < ". isototime($data->filter->from) ." and a.insult = 0) order by id desc";
$list = all($sql);
$data = array();

foreach ($list as $key => $value) {
  if (empty($data[$value['doctorid']])) $data[$value['doctorid']] = array(0 => 0, 1 => 0, 2 => 0, 3 => 0, 'name' => $value['doctor']);
  $data[$value['doctorid']] [$value['insult']] ++;
  $data[$value['doctorid']] [3] ++;
}

$stat = array();

foreach ($data as $key => $value) {
  if ($value[2] > $value[1]) $data[$key]['balance'] = 2;
  else if ($value[1] > $value[2]) $data[$key]['balance'] = 1;
  else $data[$key]['balance'] = 0;
  $stat []= $data[$key];
}

$result['status'] = 1;
$result['data'] = $stat;
