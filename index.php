<?php

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