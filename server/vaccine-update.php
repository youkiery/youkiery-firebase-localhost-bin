<?php 

require_once(ROOTDIR .'/vaccine.php');
$vaccine = new Vaccine();

$data->cometime = totime($data->cometime);
$data->calltime = totime($data->calltime);

$sql = "update pet_test_vaccine set typeid = $data->type, cometime = $data->cometime, calltime = $data->calltime where id = $data->id";
query($sql);
$result['status'] = 1;
if (!empty($data->prv)) {
  $result['list'] = $vaccine->gettemplist();
}
else {
  $result['list'] = $vaccine->getlist();
  $result['new'] = $vaccine->getlist(true);
}
