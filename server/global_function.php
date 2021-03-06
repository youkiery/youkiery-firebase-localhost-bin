<?php
function shop_connect() {
  global $shop_config;
  $servername = $shop_config['servername'];
  $username = $shop_config['username'];
  $password = $shop_config['password'];
  $database = $shop_config['database'];

  $mysqli = new mysqli($servername, $username, $password, $database);
  if ($mysqli->connect_errno) die('error: '. $mysqli -> connect_error);
  $mysqli->set_charset('utf8');
  return $mysqli;
}

function query($sql) {
  global $mysqli;
  return $mysqli->query($sql);
}

function insertid($sql) {
  global $mysqli;
  $mysqli->query($sql);
  return $mysqli->insert_id;
}

function all($sql) {
  global $mysqli;
  $list = array();
  $query = $mysqli->query($sql);
  while ($row = $query->fetch_assoc()) $list []= $row;
  return $list;
}

function arr($sql, $name) {
  global $mysqli;
  $list = array();
  $query = $mysqli->query($sql);

  while ($row = $query->fetch_assoc()) $list[]= $row[$name];
  return $list;
}

function objlist($sql, $name = '') {
  global $mysqli;
  $list = array();
  $query = $mysqli->query($sql);

  while ($row = $query->fetch_assoc()) $list[]= $row[$name];
  return $list;
}

function obj($sql, $key, $name = '') {
  global $mysqli;
  $list = array();
  $query = $mysqli->query($sql);

  if (strlen($name)) {
    while ($row = $query->fetch_assoc()) $list [$row[$key]]= $row[$name];
  }
  else {
    while ($row = $query->fetch_assoc()) $list [$row[$key]]= $row;
  }
  return $list;
}

function num_rows($sql) {
  global $mysqli;
  $query = $mysqli->query($sql);
  return $query->num_rows;
}

function fetch($sql) {
  global $mysqli;
  $query = $mysqli->query($sql);
  return $query->fetch_assoc();
}

function checkUserId($userid) {
    global $mysqli;
    $sql = 'select * from pet_users where userid = '. $userid;
    $query = $mysqli->query($sql);

    if (!empty($user = $query->fetch_assoc())) {
        return $user;
    }
    return false;
}

function cmp($source, $target) {
  return strcmp($target['expecttime'], $source['expecttime']);
}

function cmp2($source, $target) {
  return strcmp($target['calltime'], $source['calltime']);
}

function cmp3($a, $b) {
  return $a['danhgia'] < $b['danhgia'];
}

function checkUserRole($userid) {
  global $mysqli;
  if (!empty(checkUserId($userid))) {
      $sql = 'select * from pet_test_user where userid = '. $userid;
      $query = $mysqli->query($sql);
  
      $user = $query->fetch_assoc();
      if ($user['manager']) return true;
  }
  return false;
}

function getUserBranch($branch) {
  global $userid, $mysqli;
  try {
    $sql = 'select b.* from pet_setting_user a inner join pet_setting_branch b on a.branch = b.id where b.prefix = "'. $branch .'" and a.userid = ' . $userid;
    $query = $mysqli->query($sql);
    $user = $query->fetch_assoc();

    if (!empty($user)) {
      return array(
        'id' => $user['id'],
        'prefix' => $user['prefix']
      );
    }
    throw new ErrorException('user without branch');
  }
  catch(Exception $e) { 
    echo json_encode(array(
      'status' => 0,
      'no_branch' => 1
    ));
    die();
  }
}

function lower($str) {
  $str = strtolower($str);
  $str = preg_replace("/(??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???)/", 'a', $str);
  $str = preg_replace("/(??|??|???|???|???|??|???|???|???|???|???)/", 'e', $str);
  $str = preg_replace("/(??|??|???|???|??)/", 'i', $str);
  $str = preg_replace("/(??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???)/", 'o', $str);
  $str = preg_replace("/(??|??|???|???|??|??|???|???|???|???|???)/", 'u', $str);
  $str = preg_replace("/(???|??|???|???|???)/", 'y', $str);
  $str = preg_replace("/(??)/", 'd', $str);
  return $str;
}

function parseGetData($dataname, $default = '') {
  global $_GET, $_POST;
  $result = $default;
  if (isset($_GET[$dataname]) && $_GET[$dataname] != '') $result = $_GET[$dataname];
  if (isset($_POST[$dataname]) && $_POST[$dataname] != '') $result = $_POST[$dataname];
  return addslashes($result);
}

function totime($time) {
  if (preg_match("/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/", $time, $m)) {
    $time = mktime(0, 0, 0, $m[2], $m[1], $m[3]);
  }
  else return false;
  return $time;
}

function isototime($time) {
  $time = explode('T', $time);
  $time = explode('-', $time[0]);
  return strtotime("$time[0]/$time[1]/$time[2]");
}
