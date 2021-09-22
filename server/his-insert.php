<?php 

$sql = "select * from pet_test_customer where phone = '$data->phone'";

if (empty($c = fetch($sql))) {
  $sql = "insert into pet_test_customer (name, phone, addess) values('$data->name', '$data->phone', '')";
  $c['id'] = insertid($sql);
}

$sql = "select * from pet_test_pet where id = $data->pet";
if (empty($p = fetch($sql))) {
  $sql = "insert into pet_test_pet (name, customerid) values('Chưa đặt tên', $c[id])";
  $p['id'] = insertid($sql);
}

$sql = "insert into pet_test_xray(petid, doctorid, insult, time) values($p[id], $userid, 0, ". time() .")";
$id = insertid($sql);

$sql = "insert into pet_test_xray_row (xrayid, doctorid, eye, temperate, other, treat, image, status, time) values($id, $userid, '$data->eye', '$data->temperate', '$data->other', '$data->treat', '', '$data->status', ". time() .")";
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
$result['list'] = $list;
