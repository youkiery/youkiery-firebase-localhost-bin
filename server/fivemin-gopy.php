<?php 

require_once(ROOTDIR .'/fivemin.php');
$fivemin = new Fivemin();

$inputJSON = file_get_contents('php://input');
$data = json_decode($inputJSON);

$result['status'] = 1;
$result['gopy'] = $fivemin->gopy($data->gopy, $data->id);
