<?php

require 'Slim/Slim.php';

//Loading global variables
define('CORE_ROOT', getcwd());
define('MODULE_ROOT', getcwd().'/modules');

//Loading core functions
require_once MODULE_ROOT.'/core/coreModule.php';
require_once MODULE_ROOT.'/core/database.php';

//Loading Modules
load_modules();

try {
  //Adding parth and services
  $app = new Slim();
  // Specify a method post, put, get, delete.
  // Specify the path and the function called.
  $app->post('/user/', 'addUser');
  $app->post('/user/login/', 'loginUser');
  $app->post('/order/products/', 'addProductToOrder');
  $app->put('/user/', 'updateUser');
  $app->put('/order/', 'updateOrder');
  $app->get('/order/products/:uid',  'getCartProductsByUser');
  $app->get('/order/newOrderArrived/',  'getNewOrderArrived');
  $app->get('/categories/',  'getCategories');
  $app->get('/products/:pid',  'getProductByPid');
  $app->post('/products/',  'addProduct');
  $app->delete('/products/delete/:pid', 'deleteProduct');
  $app->delete('/order/delete/:oid', 'deleteOrder');
  $app->get('/user/:uid',  'getUserByUid');
  $app->get('/vendors',  function () use ($app) {
    $cid = $app->request()->params('cid');
    getVendorsByCid($cid);
  });
  $app->get('/products',  function () use ($app) {
    $categoryId = $app->request()->params('category_id');
    $searchTerm = $app->request()->params('search_term');
    $vid = $app->request()->params('vid');
    getProductList($categoryId,$searchTerm, $vid);
  });
  $app->options('/.*?', 'handleOptions');
  $app->run();
} catch(Exception $e) {
  echo '{"error":{"text":' . $e->getMessage() . '}}';
}
?>