<?php 

require_once(ROOTDIR .'/vaccine.php');
$vaccine = new Vaccine();

$result['status'] = 1;
$result['list'] = $vaccine->getlist();
$result['new'] = $vaccine->getlist(true);
$result['type'] = $vaccine->gettype();
$result['doctor'] = $vaccine->getDoctor();
$result['temp'] = $vaccine->gettemplist();
