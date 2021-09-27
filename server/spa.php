<?php
class Spa extends Module {
  function __construct() {
    parent::__construct();
    $this->module = 'spa';
    $this->prefix = 'pet_' . $this->table .'_'. $this->module;
    $this->role = $this->getRole();
  }

  function parseType($string, $type) {
    $type_array = explode(',', $string);
    if (count($type_array)) {
      foreach ($type_array as $key => $value) {
        if ($value && !empty($type[$value])) $type_array[$key] = $type[$value];
        else unset($type_array[$key]);
      }
      $string = implode(', ', $type_array);
    }
    return $string;
  }

  function getType() {
    $list = array();
    $sql = "select id, value from pet_test_config2 where module = 'spa'";
    $query = query($sql);

    while ($row = $query->fetch_assoc()) {
      $row ['check'] = 0;
      $list[]= $row;
    }
    return $list;
  }

  function getCustonerId($cid) {
    if (!empty($cid)) {
      $sql = 'select * from pet_test_customer where id = ' . $cid;
      $query = $this->db->query($sql);
  
      if (!empty($row = $query->fetch_assoc())) return $row;
    }
    return array('phone' => '');
  }

  function getList() {
    global $data;
  
    $time = strtotime(date('Y/m/d', $data->time / 1000));
    $end = $time + 60 * 60 * 24 - 1;
    $sql = "select * from (select a.*, b.name, b.phone, c.first_name as user from pet_test_spa2 a inner join pet_test_customer b on a.customerid = b.id inner join pet_users c on a.doctorid = c.userid where (time between $time and $end) and status < 3 order by utime desc) as z union (select a.*, b.name, b.phone, c.first_name as user from pet_test_spa2 a inner join pet_test_customer b on a.customerid = b.id inner join pet_users c on a.doctorid = c.userid where (time between $time and $end) and status = 3 order by utime desc)";
    $spa = all($sql);
  
    $sql = "select * from pet_test_config2 where module = 'spa'";
    $option_list = obj($sql, 'name');

    $list = array();
    foreach ($spa as $row) {
      $sql = "select b.value from pet_test_spa2_row a inner join pet_test_config2 b on a.spaid = $row[id] and a.typeid = b.id";
      $service = arr($sql, 'value');

      $sql = "select b.id from pet_test_spa2_row a inner join pet_test_config2 b on a.spaid = $row[id] and a.typeid = b.id";
      $option = arr($sql, 'id');

      $sql = "select name, phone from pet_test_customer where id = $row[customerid2]";
      $c = fetch($sql);

      $sql = "select first_name as name from pet_users where userid = $row[luser]";
      $u = fetch($sql);

      $sql = "select first_name as name from pet_users where userid = $row[duser]";
      $d = fetch($sql);

      $image = explode(', ', $row['image']);
      $list []= array(
        'id' => $row['id'],
        'name' => $row['name'],
        'phone' => $row['phone'],
        'name2' => (empty($c['name']) ? '' : $c['name']),
        'phone2' => (empty($c['phone']) ? '' : $c['phone']),
        'user' => $row['user'],
        'note' => $row['note'],
        'ltime' => (empty($u['name']) ? '' : date('d/m/Y H:i', $row['ltime'])),
        'luser' => (empty($u['name']) ? '' : $u['name']),
        'duser' => (empty($d['name']) ? '' : $d['name']),
        'status' => $row['status'],
        'weight' => $row['weight'],
        'image' => (count($image) && !empty($image[0]) ? $image : array()),
        'time' => date('H:i', $row['time']),
        'option' => $option,
        'service' => (count($service) ? implode(', ', $service) : '-')
      );
    }
  
    return $list;
  }
}
