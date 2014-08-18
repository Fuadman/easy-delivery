<?php
/**
 * Created by PhpStorm.
 * User: fsalomon
 * Date: 7/10/14
 * Time: 12:09 PM
 */

require_once 'productDao.php';
require_once 'vendorDao.php';
require_once 'productService.php';

function getProductList($categoryId, $searchTerm, $vid){
  $productService = new productService();
  $productService->getProductList($categoryId, $searchTerm, $vid);
}
function getProductByPid($pid){
  $productDao = new productDao();
  echo '{"results": ' . json_encode($productDao->getProductByPid($pid)) . '}';
}
function getVendorsByCid($cid){
  $vendorDao = new vendorDao();
  echo '{"results": ' . json_encode($vendorDao->getVendorsByCid($cid)) . '}';
}
function deleteProduct($pid){
  $productDao = new productDao();
  $productDao->deleteProduct($pid);
}
function getCategories(){
  $productService = new productService();
  $productService->getCategories();
}
function addProduct(){
  $productService = new productService();
  $request = Slim::getInstance()->request();
  $productService->addProduct($request);
}