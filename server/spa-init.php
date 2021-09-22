<?php 

require_once(ROOTDIR .'/spa.php');
$spa = new Spa();

$result['status'] = 1;
$result['type'] = $spa->getType();
$result['list'] = $spa->getList();
