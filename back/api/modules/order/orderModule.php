<?php
/**
 * Created by PhpStorm.
 * User: fsalomon
 * Date: 7/14/14
 * Time: 9:24 AM
 */

include_once 'orderDao.php';
include_once 'orderService.php';
include_once 'orderService.php';
include_once '../api/modules/core/database.php';

include_once MODULE_ROOT . '/market/productDao.php';

function getCartProductsByUser($uid) {
  $orderService = new orderService();
  $orderService->getCartProductsByUser($uid);
}
function addProductToOrder(){
  $orderService = new orderService();
  $request = Slim::getInstance()->request();
  $orderService->addProductToOrder($request);
}
function getNewOrderArrived(){
  $orderService = new orderService();
  $orderService->getNewOrderArrived();
}
function deleteOrder($oid){
  $orderDao = new orderDao();
  $orderDao->deleteOrder($oid);
}
function updateOrder(){
  $orderService = new orderService();
  $request = Slim::getInstance()->request();
  $orderService->updateOrderStatus($request);
}