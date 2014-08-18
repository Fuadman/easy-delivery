<?php
/**
 * Created by PhpStorm.
 * User: fsalomon
 * Date: 7/10/14
 * Time: 9:58 AM
 */

require_once 'userDao.php';
require_once 'userService.php';

function addUser() {
  $userService = new userService();
  $request = Slim::getInstance()->request();
  $userService->addUser($request);
}

function updateUser() {
  $userService = new userService();
  $request = Slim::getInstance()->request();
  $userService->updateUser($request);
}

function loginUser() {
  $userService = new userService();
  $request = Slim::getInstance()->request();
  $userService->loginUser($request);
}
function getUserByUid($uid){
  $userDao = new userDao();
  echo '{"user": ' . json_encode($userDao->getUserByUid($uid)) . '}';
}
