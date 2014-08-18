<?php
/**
 * Created by PhpStorm.
 * User: fsalomon
 * Date: 7/10/14
 * Time: 12:11 PM
 */



//In the future loading modules should be an automatic process with database installers, etc
function load_modules(){
  require_once MODULE_ROOT.'/user/userModule.php';
  require_once MODULE_ROOT . '/market/productModule.php';
  require_once MODULE_ROOT . '/order/orderModule.php';
}
function get_random_salt(){
  return hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
}

function getConnection() {
  $dbhost = HOST;
  $dbuser = USER;
  $dbpass = PASSWORD;
  $dbname = DATABASE;
  $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  return $dbh;
}