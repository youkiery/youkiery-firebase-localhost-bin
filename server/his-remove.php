<?php 

$sql = "delete from pet_test_xray where id = $data->id";
query($sql);

$sql = "delete from pet_test_xray_row where xrayid = $data->id";
query($sql);

$sql = "select a.*, b.name as pet, c.name as customer, c.phone, d.first_name as doctor from pet_test_xray a inner join pet_test_pet b on a.petid = b.id inner join pet_test_customer c on b.customerid = c.id inner join pet_users d on a.doctorid = d.userid where (a.time between ". isototime($data->filter->from) ." and ". isototime($data->filter->end) .") or (a.time < ". isototime($data->filter->from) ." and a.insult = 0) order by id desc";
$list = all($sql);

foreach ($list as $key => $value) {
  $sql = "select a.*, b.first_name as doctor, a.time from pet_test_xray_row a inner join pet_users b on a.doctorid = b.userid where a.xrayid = $value[id] order by time asc";
  $row = all($sql);
  foreach ($row as $index => $detail) {
    $row[$index]['time'] = date('d/m/Y', $detail['time']);
  }

  $sql = "select * from pet_test_xray_his where petid = $value[petid]";
  $his = obj($sql, 'id', 'his');

  $list[$key]['status'] = $row[count($row) - 1]['status'];
  $list[$key]['detail'] = $row;
  $list[$key]['time'] = date('d/m/Y', $value['time']);
  $list[$key]['his'] = implode(', ', $his);
}

$result['status'] = 1;
$result['messenger'] = 'Đã xóa hồ sơ';
$result['list'] = $list;
