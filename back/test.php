<?php
/**
 * Created by PhpStorm.
 * User: fsalomon
 * Date: 7/10/14
 * Time: 12:25 PM
 */


/**
 * Root directory of Core installation.
 */
//define('CORE_ROOT', getcwd());

include_once 'database.php';

$database = new database();
$database->connect();
$database->update('users',array('name'=>'test',"mail"=>"fuadtest@gmail.com"),'uid=5');
$database->sql('select * from users');
var_dump(json_encode($database->getResult()));
$database->disconnect();
