<?php
class Spa extends Module {
  function __construct() {
    parent::__construct();
    $this->module = 'spa';
    $this->spa_option = array(
      "wash_dog" => "Tắm chó",
      "wash_cat" => "Tắm mèo",
      "wash_white" => "Tắm trắng",
      "cut_fur" => "Cắt lông",
      "shave_foot" => "Cạo lông chân",
      "shave_fur" => "Cạo ông",
      "cut_claw" => "Cắt, dũa móng",
      "cut_curly" => "Cắt lông rối",
      "wash_ear" => "Vệ sinh tai",
      "wash_mouth" => "Vệ sinh răng miệng",
      "paint_footear" => "Nhuộm chân, tai",
      "paint_all" => "Nhuộm toàn thân",
      "pin_ear" => "Bấm lỗ tai",
      "cut_ear" => "Cắt lông tai",
      "dismell" => "Vắt tuyết hôi"
    );
    $this->prefix = 'pet_' . $this->table .'_'. $this->module;
    $this->role = $this->getRole();
  }

  // tắm, tỉa, cắt móng, vệ sinh tai, vắt tuyến hôi, nhuộm lông, cắt lông bàn chân, cắt lông rối, vệ sinh răng miệng, combo
  // function getList($time) {
  //   $list = array();
    
  //   $time = strtotime(date('Y/m/d', $time));
  //   $end = $time + 60 * 60 * 24 - 1;
  //   $sql = 'select id, customerid, note, type, done from `pet_test_spa` where time between '. $time .' and '. $end;
  //   // die($sql);
  //   $query = $this->db->query($sql);
  //   $type = $this->getTypeObject();

  //   while ($row = $query->fetch_assoc()) {
  //     // echo $row['done'] . '<br>';
  //     $row['type'] = $this->parseType($row['type'], $type);
  //     $customer = $this->getCustonerId($row['customerid']);
  //     $row['name'] = $customer['name'];
  //     $row['phone'] = $customer['phone'];
  //     if ($row['done']) $row['time'] = date('H:i', $row['done']);
  //     else $row['time'] = 'Chưa xong';
  //     $list []= $row;
  //   } 

  //   return $list;
  // }

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

  function getTypeList() {
    $list = array();
    $sql = 'select * from `pet_test_spa_type`';
    $query = $this->db->query($sql);

    while ($row = $query->fetch_assoc()) {
      $list []= array(
        'id' => $row['id'],
        'name' => $row['name'],
        'value' => 0
      );
    }
    return $list;
  }

  function getTypeObject() {
    $list = array();
    $sql = 'select * from `pet_test_spa_type`';
    $query = $this->db->query($sql);

    while ($row = $query->fetch_assoc()) {
      $list [$row['id']]= $row['name'];
    }
    return $list;
  }

  function getCustonerId($cid) {
    if (!empty($cid)) {
      $sql = 'select * from `pet_test_customer` where id = ' . $cid;
      $query = $this->db->query($sql);
  
      if (!empty($row = $query->fetch_assoc())) return $row;
    }
    return array('phone' => '');
  }

  function getList() {
    global $data;
  
    $time = strtotime(date('Y/m/d', $data->time / 1000));
    $end = $time + 60 * 60 * 24 - 1;
    $sql = 'select a.*, b.name, b.phone, c.first_name as user from `pet_test_spa` a inner join pet_test_customer b on a.customerid = b.id inner join pet_users c on a.doctorid = c.userid where time between '. $time .' and '. $end;
    $spa = $this->all($sql);
  
    $list = array();
    foreach ($spa as $row) {
      $option = array();
      $service = array();
      foreach ($this->spa_option as $key => $value) {
        if ($row[$key]) $service []= $this->spa_option[$key];
        $option[] = array(
          'name' => $key,
          'value' => $this->spa_option[$key],
          'check' => intval($row[$key])
        );
      }
      $image = explode(', ', $row['image']);
      $list []= array(
        'id' => $row['id'],
        'name' => $row['name'],
        'phone' => $row['phone'],
        'user' => $row['user'],
        'note' => $row['note'],
        'status' => $row['status'],
        'weight' => $row['weight'],
        'image' => (count($image) && !empty($image[0]) ? $image : array()),
        'time' => date('H:i', $row['time']),
        'option' => $option,
        'service' => implode(', ', $service)
      );
    }
  
    return $list;
  }

  public function fetch($sql) {
    $query = $this->db->query($sql);
    return $query->fetch_assoc();
  }

  public function insertid($sql) {
    $this->db->query($sql);
    return $this->db->insert_id();
  }

  public function query($sql) {
    return $this->db->query($sql);
  }

  public function all($sql) {
    $list = array();
    $query = $this->db->query($sql);
    while ($row = $query->fetch_assoc()) $list []= $row;
    return $list;
  }
}
