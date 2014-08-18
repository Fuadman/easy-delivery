<?php
/**
 * Created by PhpStorm.
 * User: fsalomon
 * Date: 7/11/14
 * Time: 11:47 AM
 */

include_once 'settings.php';
include_once 'coreFunctions.php';

function handleOptions() {
  $response = Slim::getInstance()->response();
  $response->status(200);
  return $response;
}