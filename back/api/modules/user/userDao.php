<?php
/**
 * Created by PhpStorm.
 * User: fsalomon
 * Date: 7/10/14
 * Time: 9:48 AM
 */

class userDao {
  const USERS_TABLE = 'users';
  const LOGIN_ATTEMP = 'login_attemps';

  public function addUser($user) {
    $database = new database();
    try {
      $database->connect();
      $database->insert($this::USERS_TABLE, array(
        'name' => $user->name,
        'lastname' => $user->lastname,
        'mail' => $user->mail,
        'phone' => $user->phone,
        'password' => $user->password,
        'salt' => $user->salt
      ));
      $user->uid = $database->getLastInserted();
      $database->disconnect();
      $data['success'] = TRUE;
      $data['message'] = 'Updated Successfully';
      $data['username'] = $user->name;
      $data['uid'] = $user->uid;
      echo json_encode($data);
    } catch (PDOException $e) {
      error_log($e->getMessage(), 3, '/var/tmp/php.log');
      $data['success'] = FALSE;
      $data['errors'] = $e->getMessage();
      echo json_encode($data);
    }
  }

  public function updateUser($user) {
    $database = new database();
    try {
      $database->connect();
      $database->update($this::USERS_TABLE, array(
          'name' => $user->name,
          'lastname' => $user->lastname,
          'mail' => $user->mail,
          'phone' => $user->phone,
          'password' => $user->password,
          'salt' => $user->salt
        ), 'uid = ' . $user->uid);
      $database->disconnect();
      echo json_encode($user);
    } catch (PDOException $e) {
      $data['success'] = FALSE;
      $data['errors'] = $e->getMessage();
      echo json_encode($data);
    }
  }

  public function userExistsByMail($mail) {
    $database = new database();
    try {
      $database->connect();
      $database->sql("SELECT mail from " . $this::USERS_TABLE . " where mail = '$mail'");
      $results = $database->getResult();
      $database->disconnect();
      return $results;
    } catch (PDOException $e) {
      $data['success'] = FALSE;
      $data['errors'] = $e->getMessage();
    }
  }

  public function getUserByEmail($mail) {
    try {
      $db = getConnection();
      $sql = "SELECT * from " . $this::USERS_TABLE . " where mail = :mail LIMIT 1";
      $stmt = $db->prepare($sql);
      $stmt->bindParam("mail", $mail);
      $stmt->execute();
      $db = NULL;
      return $stmt->fetchObject();
    } catch (PDOException $e) {
      $data['success'] = FALSE;
      $data['errors'] = $e->getMessage();
    }
  }

  public function getUserByUid($uid) {
    $sql = "SELECT * FROM " . $this::USERS_TABLE . " WHERE uid =" . $uid;
    $database = new database();
    try {
      $database->connect();
      $database->sql($sql);
      $result = $database->getResult();
      $database->disconnect();
      return $result;
    } catch (mysqli_sql_exception $e) {
      $data['success'] = FALSE;
      $data['errors'] = $e->getMessage();
      echo $data;
    }
  }

  public function deleteUser($uid) {
    $database = new database();
    try {
      $database->connect();
      $database->delete($this::USERS_TABLE, 'uid = ' . $uid);
      $database->disconnect();
      $data['success'] = TRUE;
      $data['message'] = "User was deleted";
      echo $data;
    } catch (mysqli_sql_exception $e) {
      $data['success'] = FALSE;
      $data['errors'] = $e->getMessage();
    }
  }

  public function addLoginAttemp($uid, $time) {
    $database = new database();
    $database->connect();
    $database->insert($this::LOGIN_ATTEMP, array('uid' => $uid, 'time' => $time));
    $database->disconnect();

  }

  public function checkBrute($uid) {
    $database = new database();
    $now = time();
    $valid_attempts = $now - (2 * 60 * 60);
    try {
      $database->connect();
      $database->sql("select uid from " . $this::LOGIN_ATTEMP . " where uid = " . $uid . " and time > " . $valid_attempts);
      if ($database->numRows() > 5) {
        return FALSE;
      }
      $database->disconnect();
      return TRUE;
    } catch (mysqli_sql_exception $e) {
      $data['success'] = FALSE;
      $data['errors'] = $e->getMessage();
    }
  }
}