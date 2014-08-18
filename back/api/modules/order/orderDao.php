<?php
/**
 * Created by PhpStorm.
 * User: fsalomon
 * Date: 7/14/14
 * Time: 9:24 AM
 */
include_once '../api/modules/core/database.php';
include_once '../api/modules/market/productDao.php';
class orderDao {
  const ORDERS_TABLE = 'orders';
  const ORDERS_PRODUCTS_TABLE = 'orderproducts';

  public function getOrderProductsByUser($uid) {
    $productDao = new productDao();
    $database = new database();
    $sql = "SELECT o.oid,p.pid,p.name,p.description,p.picture FROM " . $this::ORDERS_PRODUCTS_TABLE . " op, " . $this::ORDERS_TABLE . " o, " . $productDao::PRODUCTS_TABLE . " p WHERE o.uid = " . $uid . " and o.oid = op.oid and op.pid = p.pid";
    try {
      $database->connect();
      $database->sql($sql);
      $results = $database->getResult();
      $database->disconnect();
      return $results;
    } catch (mysqli_sql_exception $e) {
      $data['success'] = FALSE;
      $data['errors'] = $e->getMessage();
      return $data;
    }
  }

  public function getCompleteOrderProductsByOid($oid) {
    $productDao = new productDao();
    $database = new database();
    $sql = "SELECT o.oid,p.pid,p.name,p.description,op.quantity, op.total, p.price FROM " . $this::ORDERS_PRODUCTS_TABLE . " op, " . $this::ORDERS_TABLE . " o, " . $productDao::PRODUCTS_TABLE . " p WHERE o.oid = " . $oid . " and o.oid = op.oid and op.pid = p.pid";
    try {
      $database->connect();
      $database->sql($sql);
      $results = $database->getResult();
      $database->disconnect();
      return $results;
    } catch (mysqli_sql_exception $e) {
      $data['success'] = FALSE;
      $data['errors'] = $e->getMessage();
      return $data;
    }
  }
  public function getOrderProductsByOid($oid) {
    $productDao = new productDao();
    $database = new database();
    $sql = "SELECT * FROM ".$this::ORDERS_PRODUCTS_TABLE.' where oid = '.$oid;
    try {
      $database->connect();
      $database->sql($sql);
      $results = $database->getResult();
      $database->disconnect();
      return $results;
    } catch (mysqli_sql_exception $e) {
      $data['success'] = FALSE;
      $data['errors'] = $e->getMessage();
      return $data;
    }
  }

  public function addProductToOrder($order) {
    $productDao = new productDao();
    $database = new database();
    $product = $productDao->getProductByPid($order->pid);
//    $productObject = json_decode(json_encode($product), FALSE);
    try {
      $database->connect();
      $total = $order->quantity * $product[0]['price'];
      $database->insert($this::ORDERS_PRODUCTS_TABLE, array(
        "pid" => $order->pid,
        "oid" => $order->oid,
        "quantity" => $order->quantity,
        "total"=>$total
      ));
      $database->disconnect();
      $data['success'] = TRUE;
      $data['message'] = 'Product added successfully.';
      return $data;
    } catch (mysqli_sql_exception $e) {
      $data['success'] = FALSE;
      $data['errors'] = $e->getMessage();
      echo $data;
    }
  }
  public function getOrderByStatus($status){
    $database = new database();
    $sql = "select * from ".$this::ORDERS_TABLE." where status = '".$status."'";
    try {
      $database->connect();
      $database->sql($sql);
      $results = $database->getResult();
      $database->disconnect();
      return $results;
    } catch (mysqli_sql_exception $e){
      $data['success'] = FALSE;
      $data['errors'] = $e->getMessage();
      echo $data;
    }
  }
  public function getOrderByOid($oid){
    $database = new database();
    $sql = "select * from ".$this::ORDERS_TABLE." where oid = ".$oid;
    try {
      $database->connect();
      $database->sql($sql);
      $results = $database->getResult();
      $database->disconnect();
      return $results;
    } catch (mysqli_sql_exception $e){
      $data['success'] = FALSE;
      $data['errors'] = $e->getMessage();
      echo $data;
    }
  }
  public function getEntityOrdersArray(){
    $database = new database();
    $sql = "select o.oid, a.description, u.name, u.lastname, u.mail, o.status from ".$this::ORDERS_TABLE." o, address a, users u where o.aid = a.aid and u.uid = o.uid";
    try {
      $database->connect();
      $database->sql($sql);
      $results = $database->getResult();
      $database->disconnect();
      return $results;
    } catch (mysqli_sql_exception $e){
      $data['success'] = FALSE;
      $data['errors'] = $e->getMessage();
      echo $data;
    }
  }
  public function deleteOrder($oid){
    $database = new database();
    try {
      $database->connect();
      $database->delete($this::ORDERS_TABLE, "oid = " . $oid);
      $database->delete($this::ORDERS_PRODUCTS_TABLE, "oid = ".$oid);
      $database->disconnect();
      return 'Item Borrado';
    } catch (mysqli_sql_exception $e) {
      $data['success'] = FALSE;
      $data['errors'] = $e->getMessage();
      return $data;
    }
  }
  public function updateOrderStatus($status, $oid){
    $database = new database();
    try {
      $database->connect();
      $database->update($this::ORDERS_TABLE,array('status'=>$status),"oid = ".$oid);
      $database->disconnect();
      return 'Item Actualizado';
    } catch (mysqli_sql_exception $e) {
      $data['success'] = FALSE;
      $data['errors'] = $e->getMessage();
      return $data;
    }
  }
} 