<?php
class Vaccine extends Module {
  function __construct() {
    parent::__construct();
    $this->module = 'vaccine';
    $this->prefix = 'pet_' . $this->table .'_'. $this->module;
    $this->role = $this->getRole();
  }

  function getlist($today = false) {
    global $db, $data, $userid;
  
    $sql = "select * from pet_test_permission where userid = $userid and module = 'vaccine'";
    $role = fetch($sql);

    $xtra = '';
    if ($role['type'] == 1) $xtra = " and userid = $userid ";

    $type = $this->typeList();
    $start = strtotime(date('Y/m/d'));
    if ($today) {
      $sql = "select a.*, c.first_name as doctor, b.name, b.phone, b.address from pet_test_vaccine2 a inner join pet_users c on a.userid = c.userid inner join pet_test_customer b on a.customerid = b.id where (a.time between $start and ". time() . ") $xtra and a.status < 2 order by a.id desc limit 50";
    }
    else if (empty($data->filter)) {
      $end = $start + 60 * 60 * 24 * 7 - 1; 
      $sql = "select a.*, c.first_name as doctor, b.name, b.phone, b.address from pet_test_vaccine2 a inner join pet_users c on a.userid = c.userid inner join pet_test_customer b on a.customerid = b.id where a.recall < $end $xtra and a.status < 2 order by a.calltime asc, a.recall desc limit 50";
    }
    else {
      $key = $data->filter;
      $sql = "select a.*, c.first_name as doctor, b.name, b.phone, b.address from pet_test_vaccine2 a inner join pet_users c on a.userid = c.userid inner join pet_test_customer b on a.customerid = b.id where (b.name like '%$key%' or b.phone like '%$key%') order by a.calltime asc, a.recall desc limit 50";
    }
  
    $query = query($sql);
    $list = array();
  
    // luật tính status
    // nếu chưa gọi, chưa cách quá 7 ngày, status = 0
    // nếu đã gọi, chưa cách quá 7 ngày status = 1
    // nếu đã gọi, cách quá 7 ngày status = 2
    // nếu chưa gọi, cách quá 7 ngày, status = 3
  
    $limit = $start - 60 * 60 * 24 * 7;
    while ($row = $query->fetch_assoc()) {
      $status = $row['status'];
      if ($status) {
        if ($row['calltime'] < $limit) $status = 2;
        else $status = 1;
      }
      else {
        if ($row['calltime'] < $limit) $status = 3;
        else $status = 0;
      }
  
      $list []= array(
        'id' => $row['id'],
        'note' => $row['note'],
        'doctor' => $row['doctor'],
        'name' => $row['name'],
        'phone' => $row['phone'],
        'address' => $row['address'],
        'status' => $status,
        'vaccine' => $type[$row['typeid']],
        'called' => ($row['called'] ? date('d/m/Y', $row['called']) : '-'),
        'cometime' => date('d/m/Y', $row['cometime']),
        'calltime' => date('d/m/Y', $row['calltime']),
      );
    }
  
    return $list;
  }

  function gettemplist($today = false) {
    global $db, $data, $userid;
  
    $sql = "select * from pet_test_permission where userid = $userid and module = 'vaccine'";
    $role = fetch($sql);

    $xtra = '';
    if ($role['type'] == 1) $xtra = " and userid = $userid ";

    $sql = "select a.*, c.first_name as doctor, b.name, b.phone, b.address from pet_test_vaccine2 a inner join pet_users c on a.userid = c.userid inner join pet_test_customer b on a.customerid = b.id where a.status = 5 $xtra order by a.id desc limit 50";
    $query = query($sql);
    $list = array();
  
    $type = $this->typeList();
    while ($row = $query->fetch_assoc()) {
      $list []= array(
        'id' => $row['id'],
        'note' => $row['note'],
        'doctor' => $row['doctor'],
        'name' => $row['name'],
        'phone' => $row['phone'],
        'address' => $row['address'],
        'vaccine' => $type[$row['typeid']],
        'called' => ($row['called'] ? date('d/m/Y', $row['called']) : '-'),
        'cometime' => date('d/m/Y', $row['cometime']),
        'calltime' => date('d/m/Y', $row['calltime']),
      );
    }
  
    return $list;
  }

  function getOlder($customerid) {
    global $db;
  
    $sql = "select * from pet_test_vaccine2 where status < 2 and customerid = $customerid order by id asc";
    $list = all($sql);
    $query = query($sql);
    $type = $this->typeList();
    foreach ($list as $index => $row) {
      $list[$index]['type'] = $type[$row['typeid']];
      $list[$index]['calltime'] = date('d/m/Y', $row['calltime']);
      $list[$index]['called'] = ($row['called'] ? date('d/m/Y', $row['called']) : '-');
    }
  
    return $list;
  }

  function getDoctor() {
    $sql = "select a.id, a.userid, a.name, b.username from pet_test_doctor a inner join pet_users b on a.userid = b.userid";
    return all($sql);
  }
  
  function getCustomer($petid) {
    global $db;
  
    $sql = "select * from pet_test_pet where id = $petid";
    $pet = fetch($sql);
  
    $sql = "select * from pet_test_customer where id = $pet[customerid]";
    return fetch($sql);
  }
  
  function typeList() {
    $sql = 'select * from pet_test_type where active = 1';
    return obj($sql, 'id', 'name');
  }
  
  function gettype() {
    $sql = 'select * from pet_test_type where active = 1';
    return all($sql);
  }

  // function thisrole() {
  //   $sql = 'select * from pet_test_permission where userid = '. $this->userid .' and module = "vaccine"';
  //   $query = $this->db->query($sql);
  //   $role = $query->fetch_assoc();
  //   return $role['type'];
  // }

  // function getList($filter) {
  //   $list = array();
  //   $data = array();
  //   $type = $this->gettypeList();

  //   $time = time();
  //   $limit = $time + 60 * 60 * 24 * 14;

  //   $sql = 'select * from pet_test_vaccine2 where calltime < '. $limit .' and status = '. $filter['status'] .' order by calltime desc limit 50';
  //   $query = $this->db->query($sql);

  //   // tên thú cưng, sđt, vaccine, ngày tái chủng, ghi chú, trạng thại
  //   while ($row = $query->fetch_assoc()) {
  //     if ($time > $row['calltime']) $row['color'] = 'red';
  //     else $row['color'] = 'green';
  //     $list []= $row;
  //   }

  //   usort($list, "cmp2");

  //   // tên thú cưng, sđt, vaccine, ngày tái chủng, ghi chú, trạng thại
  //   foreach ($list as $row) {
  //     $pet = $this->getPetId($row['petid']);
  //     $customer = $this->getCustonerId($pet['customerid']);
  //     if (!empty($customer['phone'])) {
  //       $data []= array(
  //         'id' => $row['id'],
  //         'petname' => $pet['name'],
  //         'name' => $customer['name'],
  //         'number' => $customer['phone'],
  //         'vaccine' => $type[$row['typeid']],
  //         'calltime' => date('d/m/Y', $row['calltime']),
  //         'note' => $row['note'],
  //         'color' => $row['color'],
  //       );
  //     }
  //   }
  //   return $data;
  // }

  // function gettypeList() {
  //   $list = array();
  //   $sql = 'select * from pet_test_type';
  //   $query = $this->db->query($sql);

  //   while ($row = $query->fetch_assoc()) {
  //     $list[$row['id']] = $row['name'];
  //   }
  //   return $list;
  // }

  // function typeList() {
  //   $list = array();
  //   $sql = 'select * from pet_test_type';
  //   $query = $this->db->query($sql);

  //   while ($row = $query->fetch_assoc()) {
  //     $list []= array(
  //       'id' => $row['id'],
  //       'name' => $row['name']
  //     );
  //   }
  //   return $list;
  // }

  // function getCustonerId($cid) {
  //   if (!empty($cid)) {
  //     $sql = 'select * from pet_test_customer where id = ' . $cid;
  //     $query = $this->db->query($sql);
  
  //     if (!empty($row = $query->fetch_assoc())) return $row;
  //   }
  //   return array('phone' => '');
  // }

  // function getPetId($pid) {
  //   if (!empty($pid)) {
  //     $sql = 'select * from pet_test_pet where id = ' . $pid;
  //     $query = $this->db->query($sql);
  
  //     if (!empty($row = $query->fetch_assoc())) return $row;
  //   }
  //   return array('customerid' => 0);
  // }

  // function getUserNotify($page = 1) {
  //   $list = array();
  //   // lấy danh sách thông báo
  //   $xtra = '';
  //   if ($this->thisrole() < 2) {
  //     // nhân viên, lấy thông báo bản thân
  //     $xtra = 'where userid = ' . $this->userid;
  //   }
  //   $sql = 'select * from pet_test_notify ' . $xtra . ' order by time desc';
  //   $query = $this->db->query($sql);

  //   while ($row = $query->fetch_assoc()) {
  //     $list []= $this->parseWorkNotify($row);
  //   }
  //   return $list;
  // }

  // function getUserNotifyTime() {
  //   $sql = 'select * from pet_test_notify_read where userid = ' . $this->userid;
  //   $query = $this->db->query($sql);

  //   if (empty($row = $query->fetch_assoc())) {
  //     $sql = 'insert into pet_test_notify_read (userid, time) values ('. $this->userid .', 0)';
  //     $this->db->query($sql);
  //     $row = array(
  //       'time' => 0
  //     );
  //   }
  //   return $row['time'];
  // }

  // // userid, action, workid, time
  // function parseWorkNotify($data) {
  //   $action_trans = array(1 => 'thêm công việc', 'cập nhật tiến độ', 'hoàn thành', 'hủy công việc');
  //   $user = checkUserId($data['userid']);
  //   $name = (!empty($user['last_name']) ? $user['last_name'] . ' ': '') . $user['first_name'];
  //   $work = $this->getWorkById($data['workid']);

  //   return array(
  //     'id' => $data['workid'],
  //     'content' => $name . ' ' . $action_trans[$data['action']] . ' ' . $work['content'],
  //     'time' => date('d/m/Y H:i', $data['time'])
  //   );
  // }

  // function getWorkById($workid) {
  //   $sql = 'select * from pet_test_vaccine2 where id = ' . $workid;
  //   $query = $this->db->query($sql);
  //   return $query->fetch_assoc();
  // }

  // function checkWorkId($workid) {
  //   $sql = 'select * from pet_test_vaccine2 where id = '. $workid;
  //   $query = $this->db->query($sql);

  //   if (!empty($query->fetch_assoc())) return true;
  //   return false;
  // }

  // function insertWork($data, $time) {
  //   $sql = 'insert into pet_test_vaccine2 (cometime, calltime, last_time, post_user, edit_user, userid, depart, customer, content, process, confirm, review, note) value("'. $data['cometime'] .'", "'. $data['calltime'] .'", '. $time .', '. $this->userid .', '. $this->userid .', '. $data['employ'] .', 0, 0, "'. $data['content'] .'", 0, 0, "", "")';

  //   if ($this->db->query($sql)) {
  //     $id = $this->db->insert_id;
  //     $this->insertNotify(INSERT_NOTIFY, $id, $time);
  //     $this->setLastUpdate($time);
  //   }
  // }

  // function updateWork($data, $time) {
  //   $xtra = '';
  //   if ($this->thisrole() > 1) $xtra .= ', calltime = ' . $data['calltime'] . ', content = "' . $data['content'] . '"';

  //   $sql = 'update pet_test_vaccine2 set process = '. $data['process'] .', note = "'. $data['note'] .'", image = "'. $data['image'] .'" '. $xtra .' where id = '. $data['id'];
  //   if ($this->db->query($sql)) {
  //     if ($data['process'] == 100) $this->insertNotify(COMPLETE_NOTIFY, $data['id'], $time);
  //     else $this->insertNotify(EDIT_NOTIFY, $data['id'], $time);
  //     $this->setLastUpdate($time);
  //   }
  // }

  // function doneWork($data, $time) {
  //   $xtra = '';
  //   $sql = 'update pet_test_vaccine2 set process = 100 where id = '. $data['id'];
  //   if ($this->db->query($sql)) {
  //     $this->insertNotify(EDIT_NOTIFY, $data['id'], $time);
  //     $this->setLastUpdate($time);
  //   }
  // }

  // function removeWork($data, $time) {
  //   $sql = 'update pet_test_vaccine2 set active = 0 where id = '. $data['id'];
  //   if ($this->db->query($sql)) {
  //     $this->setLastUpdate($time);
  //     $this->insertNotify(REMOVE_NOTIFY, $data['id'], $time);
  //   }
  // }
}
