<?php 

$db = shop_connect();
$inputJSON = file_get_contents('php://input');
$data = json_decode($inputJSON);

$sql = "update wp_posts set post_status = '$data->status' where ID = $data->id";
$query = $db->query($sql);

$result['status'] = 1;
