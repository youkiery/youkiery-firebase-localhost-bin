<?php

// define('ROOTDIR', pathinfo(str_replace(DIRECTORY_SEPARATOR, '/', __file__), PATHINFO_DIRNAME));
// include_once(ROOTDIR . '/server/global_function.php');
// include_once(ROOTDIR . '/config.php');

// $mysqli = new mysqli(
//   $config['servername'],
//   $config['username'],
//   $config['password'],
//   $config['database']
// );
// if ($mysqli->connect_errno) die('error: '. $mysqli -> connect_error);
// $mysqli->set_charset('utf8');

// $sql = "select a.*, b.customerid from pet_test_vaccine2 a inner join pet_test_pet b on a.petid = b.id";
// $list = all($sql);

// foreach ($list as $v) {
//   $sql = "update pet_test_vaccine2 set customerid = $v[customerid] where id = $v[id]";
//   query($sql);
// }

// $sql = "select * from pet_test_config2 where module = 'spa'";
// $type = obj($sql, 'name');
// // echo json_encode($type);die();

// $sql = "select * from pet_test_spa2";
// $list = all($sql);

// foreach ($list as $key => $value) {
//   foreach ($type as $row) {
//     if ($value[$row['name']]) {
//       $sql = "insert into pet_test_spa2_row (spaid, typeid) values($value[id], ". $row['id'] .")";
//       echo "$sql; <br>"; 
//       // query($sql);
//     }
//   }
// }
// die();

// include_once('config.php');

// $servername = $config['servername'];
// $username = $config['username'];
// $password = $config['password'];
// $database = $config['database'];

// // $servername = 'localhost';
// // $username = 'petco339_test';
// // $password = 'Ykpl.2412';
// // $database = 'petco339_test';

// define('INSERT_NOTIFY', 1);
// define('EDIT_NOTIFY', 2);
// define('COMPLETE_NOTIFY', 3);
// define('REMOVE_NOTIFY', 4);
// define('NV_ROOTDIR', pathinfo(str_replace(DIRECTORY_SEPARATOR, '/', __file__), PATHINFO_DIRNAME));
// $branch = 'test';

// $db = new mysqli($servername, $username, $password, $database);
// if ($db->connect_errno) die('error: '. $db -> connect_error);
// $db->set_charset('utf8');

// $sql = "select * from a2";
// $query = $db->query($sql);
// $list = array();

// while($row = $query->fetch_assoc()) {
//   $list [$row['phone']] = $row['name'];
// }

// $sql = "select * from a1";
// $query = $db->query($sql);

// while($row = $query->fetch_assoc()) {
//   if (empty($list[$row['phone']])) echo "insert into pet_test_customer(name, phone, address) values('$row[name]', '$row[phone]', '$row[address]');<br>";
//   // $list [$row['phone']] = $row['name'];
// }