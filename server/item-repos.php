<?php 

$sql = "delete from pet_test_item_pos_item where id = $data->itemid";
query($sql);

$sql = "select b.id, a.name from pet_test_item a inner join pet_test_item_pos_item b on a.id = b.itemid where b.posid = $data->posid";
$result['list'] = all($sql);
$result['status'] = 1;
