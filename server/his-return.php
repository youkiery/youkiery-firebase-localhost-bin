<?php 

$sql = "update pet_test_xray set insult = 1 where id = $data->id";
query($sql);

$result['status'] = 1;
$result['insult'] = 1;
