<?php 

$db = shop_connect();
$status = array(
  'wc-completed' => 'Hoàn Thành',
  'wc-processing' => 'Chờ xử lý',
  'wc-onhold' => 'Tạm giữ'
);

$sql = "select * from wp_posts where guid like '%shop%' and post_status <> 'wc-completed'";
$query = $db->query($sql);

$item = array();

while ($row = $query->fetch_assoc()) {
  $sql = "select * from wp_postmeta where post_id = $row[ID]";
  $query2 = $db->query($sql);
  $info = array();
  $item = array();

  while ($row2 = $query2->fetch_assoc()) $info[$row2['meta_key']] = $row2['meta_value'];

  $sql = "select * from wp_woocommerce_order_items where order_id = $row[ID]";
  $query2 = $db->query($sql);
  
  while ($row2 = $query2->fetch_assoc()) {
    $sql = "select * from wp_woocommerce_order_itemmeta where order_item_id = $row2[order_item_id]";
    $query3 = $db->query($sql);
    $intro = array();

    while ($row3 = $query3->fetch_assoc()) {
      $intro[$row3['meta_key']] = $row3['meta_value'];
    }
    $item []= array(
      'name' => $row2['order_item_name'],
      'price' => 0,
      'number' => $intro['_qty'],
      'total' => $intro['_line_total']
    );
  }

  $list []= array(
    'id' => $row['ID'],
    'customer' => $info['_billing_last_name'] . ' ' . $info['_billing_first_name'],
    'phone' => $info['_billing_phone'],
    'address' => $info['_billing_address_1'] . ', '. $info['_billing_city'],
    'time' => $row['post_date'],
    'status' => $status[$row['post_status']],
    'total' => $info['_order_total'],
    'payment' => $info['_payment_method_title'],
    'item' => $item
  );
}

$result['status'] = 1;
$result['list'] = $list;
