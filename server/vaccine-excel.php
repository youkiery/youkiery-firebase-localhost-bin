<?php 

require_once(ROOTDIR .'/vaccine.php');
$vaccine = new Vaccine();

// $raw = $_FILES['file']['tmp_name'];
// $des = ROOTDIR .'upload/'. $_FILES['file']['name'];

// move_uploaded_file($raw, $des);
echo json_encode($vaccine->gettemplist());die();

$page_title = "Nhập hồ sơ một cửa";
$x = array(
  'A' => 0, 'B' => 1, 'C' => 2, 'D' => 3, 'E' => 4, 'F' => 5, 'G' => 6, 'H' => 7, 'I' => 8, 'J' => 9, 'K' => 10, 'L' => 11, 'M' => 12, 'N' => 13, 'O' => 14, 'P' => 15, 'Q' => 16, 'R' => 17, 'S' => 18, 'T' => 19, 'U' => 20, 'V' => 21, 'W' => 22, 'X' => 23, 'Y' => 24, 'Z' => 25
);
$xr = array(0 => 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');

include ROOTDIR .'PHPExcel/IOFactory.php';
$inputFileName = ROOTDIR .'upload/ChiTietHoaDon_HD250167_KV24092021-103818-243.xlsx';
  
$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objReader->load($inputFileName);

$sheet = $objPHPExcel->getSheet(0); 

$highestRow = $sheet->getHighestRow(); 
$highestColumn = $sheet->getHighestColumn();

$sql = "select * from pet_test_doctor";
$doctor = obj($sql, 'name', 'userid');

$sql = "select * from pet_test_type";
$type = obj($sql, 'code', 'id');

$col = array(
  'Mã hàng' => '', // 0
  'Tên người bán' => '', // 1
  'Số điện thoại' => '', // 2
  'Khách hàng' => '', // 3
  'Ngày bán' => '', // 4
  'Ghi chú' => '' // 5
);

for ($j = 0; $j <= $x[$highestColumn]; $j ++) {
  $val = $sheet->getCell($xr[$j] . '1')->getValue();
  foreach ($col as $key => $value) {
    if ($key == $val) $col[$key] = $j;
  }
}

$data = array();
for ($i = 2; $i <= $highestRow; $i ++) { 
  $temp = array();
  foreach ($col as $key => $j) {
    $val = $sheet->getCell($xr[$j] . $i)->getValue();
    $temp []= $val;
  }
  $data []= $temp;
}

foreach ($data as $row) {
  $sql = "select * from pet_test_customer where phone = '$row[2]'";
  if (empty($c = fetch($sql))) {
    $sql = "insert into pet_test_customer (name, phone) values('$row[3]', '$row[2]')";
    $c['id'] = insertid($sql);
  }

  $datetime = explode(' ', $row[4]);
  $date = explode('-', $datetime[0]);
  // echo json_encode($date);
  // die();
  $cometime = strtotime("$date[0]/$date[1]/$date[2]");

  $datetime = explode(' ', $row[5]);
  $date = explode('-', $datetime[0]);
  if (count($date) == 3) $calltime = strtotime("$date[0]/$date[1]/$date[2]");
  else $calltime = time();

  echo "insert into pet_test_vaccine (customerid, typeid, cometime, calltime, note, status, recall, userid, time, called) values($c[id], ". $type[$row[0]] .", $cometime, $calltime, '', 5, $calltime, ". $doctor[$row[1]] .", ". time() .", 0) <br>";
}
die();

echo json_encode($data);
die();
