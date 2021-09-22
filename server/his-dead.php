<?php 

$sql = "update pet_test_xray set insult = 2 where id = $data->id";
query($sql);

$result['status'] = 1;
$result['insult'] = 2;
