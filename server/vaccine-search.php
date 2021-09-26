<?php 

require_once(ROOTDIR .'/vaccine.php');
$vaccine = new Vaccine();

$result['status'] = 1;
$result['list'] = $vaccine->getlist();