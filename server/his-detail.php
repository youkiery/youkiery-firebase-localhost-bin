<?php 

$time = explode('T', $data->time);
$time = explode('-', $time[0]);
$time = totime("$time[2]/$time[1]/$time[0]");

$sql = "insert into pet_test_xray_row (xrayid, doctorid, eye, temperate, other, treat, image, status, time) values($data->id, $userid, '$data->eye', '$data->temperate', '$data->other', '$data->treat', '', '$data->status', $time)";
$id = insertid($sql);

$sql = "select a.*, b.first_name as doctor, a.time from pet_test_xray_row a inner join pet_users b on a.doctorid = b.userid where a.id = $id order by time asc";
$row = fetch($sql);
$row['time'] = date('d/m/Y', $row['time']);

$result['status'] = 1;
$result['data'] = $row;
