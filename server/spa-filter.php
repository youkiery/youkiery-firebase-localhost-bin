<?php 

require_once(ROOTDIR .'/spa.php');
$spa = new Spa();

$result['status'] = 1;
$result['list'] = $spa->getList();
