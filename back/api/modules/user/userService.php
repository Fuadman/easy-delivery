<?php
/**
 * Created by PhpStorm.
 * User: fsalomon
 * Date: 7/10/14
 * Time: 9:48 AM
 */

require_once 'userDao.php';

class userService {
  public function addUser($request) {
    error_log('addUser\n', 3, '/var/tmp/php.log');
    $user = json_decode($request->getBody());
    if (!$this->verifyRepeatedUserByMail($user->mail)) {
      $user->salt = get_random_salt();
      // Create salted password
      $user->password = hash('sha512', $user->password . $user->salt);
      $userDao = new userDao();
      $userDao->addUser($user);
    }
    else {
      $data['success'] = FALSE;
      $data['errors'] = 'Repeated email';
      echo json_encode($data);
    }
  }

  public function updateUser($request) {
    error_log('addUser\n', 3, '/var/tmp/php.log');
    $user = json_decode($request->getBody());
    $user->salt = get_random_salt();
    // Create salted password
    $user->password = hash('sha512', $user->password . $user->salt);
    $userDao = new userDao();
    $userDao->updateUser($user);
  }

  public function verifyRepeatedUserByMail($mail) {
    $userDao = new userDao();
    return $userDao->userExistsByMail($mail);
  }

  public function loginUser($request) {
    $user = json_decode($request->getBody());
    $userDao = new userDao();
    $userRegistry = $userDao->getUserByEmail($user->mail);
    if ($userRegistry) {
      $password = hash('sha512', $user->password . $userRegistry->salt);
      if (count($userRegistry) == 1) {
        if ($userRegistry->password == $password) {
          // Password is correct!
          // Get the user-agent string of the user.
          $user_browser = $_SERVER['HTTP_USER_AGENT'];

          // XSS protection as we might print this value
          $user_id = preg_replace("/[^0-9]+/", "", $userRegistry->uid);
          $_SESSION['user_id'] = $user_id;

          // XSS protection as we might print this value
          $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $userRegistry->name);

          $_SESSION['username'] = $username;
          $_SESSION['login_string'] = hash('sha512', $password . $user_browser);
          // if there are no errors, return a message
          $data['success'] = TRUE;
          $data['message'] = 'Success!';
          $data['username'] = $username;
          $data['uid'] = $userRegistry->uid;
          echo json_encode($data);
        }
        else {
          $now = time();
          $sw = 0;
          $userDao->addLoginAttemp($userRegistry->uid, $now);
          if(!$userDao->checkBrute($userRegistry->uid)){
            $data['success'] = FALSE;
            $data['errors'] = 'Too many login attemps';
            $sw = 1;
          }

          $data['success'] = FALSE;
          if($sw == 1){
            $data['errors'] = 'Invalid Password and account was disabled';
          }
          else {
            $data['errors'] = 'Invalid Password';
          }
          echo json_encode($data);
        }
      }
    }
    else {
      $data['success'] = FALSE;
      $data['errors'] = 'Invalid Mail';
      echo json_encode($data);
    }

  }
} 