<?php 

$sql = "insert into pet_test_xray_his (petid, his, time) values($data->petid, '$data->his', ". time() .")";
query($sql);

$sql = "select * from pet_test_xray_his where petid = $data->petid";
$his = obj($sql, 'id', 'his');

$result['status'] = 1;
$result['his'] = implode(', ', $his);