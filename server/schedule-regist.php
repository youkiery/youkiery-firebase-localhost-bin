<?php 

require_once(ROOTDIR .'/schedule.php');
$schedule = new Schedule();
// ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ nhật']
$reversal_day = array(
  0 => 1, 2, 3, 4, 5, 6, 7 
);

$data->time /= 1000;

// echo json_encode($list);die();

foreach ($data->list as $value) {
  // a => day, b => type
  $time = $data->time + 60 * 60 * 24 * ($value->a - date('N', $data->time) + 1);
  $schedule->insert($userid, $time, $value->b, $value->c);
}

$result['status'] = 1;
$result['messenger'] = 'Đã đăng ký lịch';
$result['data'] = $schedule->getList(array('time' => $data->time));
