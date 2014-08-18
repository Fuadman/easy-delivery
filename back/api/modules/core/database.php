<?php
include_once 'settings.php';
class database{

  private $db_host = HOST;
  private $db_user = USER;
  private $db_pass = PASSWORD;
  private $db_name = DATABASE;


  private $con = false;
  private $result = array();
  private $myQuery = "";
  private $numResults = "";

  public function connect(){
    if(!$this->con){
      $myconn = @mysql_connect($this->db_host,$this->db_user,$this->db_pass);
      if($myconn){
        $seldb = @mysql_select_db($this->db_name,$myconn);
        if($seldb){
          $this->con = true;
          return true;
        }else{
          array_push($this->result,mysql_error());
          return false;
        }
      }else{
        array_push($this->result,mysql_error());
        return false;
      }
    }else{
      return true;
    }
  }

  public function disconnect(){
    if($this->con){
      if(@mysql_close()){
        $this->con = false;
        return true;
      }else{
        return false;
      }
    }
  }

  public function sql($sql){
    $query = @mysql_query($sql);
    $this->myQuery = $sql; // Pass back the SQL
    if($query){
      $this->numResults = mysql_num_rows($query);
      for($i = 0; $i < $this->numResults; $i++){
        $r = mysql_fetch_array($query);
        $key = array_keys($r);
        for($x = 0; $x < count($key); $x++){
          if(!is_int($key[$x])){
            if(mysql_num_rows($query) >= 1){
              $this->result[$i][$key[$x]] = $r[$key[$x]];
            }else{
              $this->result = null;
            }
          }
        }
      }
      return true; // Query was successful
    }else{
      array_push($this->result,mysql_error());
      return false; // No rows where returned
    }
  }

  // Function to SELECT from the database
  public function select($table, $rows = '*', $join = null, $where = null, $order = null, $limit = null){
    // Create query from the variables passed to the function
    $q = 'SELECT '.$rows.' FROM '.$table;
    if($join != null){
      $q .= ' JOIN '.$join;
    }
    if($where != null){
      $q .= ' WHERE '.$where;
    }
    if($order != null){
      $q .= ' ORDER BY '.$order;
    }
    if($limit != null){
      $q .= ' LIMIT '.$limit;
    }
    $this->myQuery = $q; // Pass back the SQL
    // Check to see if the table exists
    if($this->tableExists($table)){
      // The table exists, run the query
      $query = @mysql_query($q);
      if($query){
        // If the query returns >= 1 assign the number of rows to numResults
        $this->numResults = mysql_num_rows($query);
        // Loop through the query results by the number of rows returned
        for($i = 0; $i < $this->numResults; $i++){
          $r = mysql_fetch_array($query);
          $key = array_keys($r);
          for($x = 0; $x < count($key); $x++){
            // Sanitizes keys so only alphavalues are allowed
            if(!is_int($key[$x])){
              if(mysql_num_rows($query) >= 1){
                $this->result[$i][$key[$x]] = $r[$key[$x]];
              }else{
                $this->result = null;
              }
            }
          }
        }
        return true; // Query was successful
      }else{
        array_push($this->result,mysql_error());
        return false; // No rows where returned
      }
    }else{
      return false; // Table does not exist
    }
  }

  // Function to insert into the database
  public function insert($table,$params=array()){
    // Check to see if the table exists
    if($this->tableExists($table)){
      $sql='INSERT INTO `'.$table.'` (`'.implode('`, `',array_keys($params)).'`) VALUES ("' . implode('", "', $params) . '")';
      $this->myQuery = $sql; // Pass back the SQL
      // Make the query to insert to the database
      if($ins = @mysql_query($sql)){
        array_push($this->result,mysql_insert_id());
        return true; // The data has been inserted
      }else{
        array_push($this->result,mysql_error());
        return false; // The data has not been inserted
      }
    }else{
      return false; // Table does not exist
    }
  }

  //Function to delete table or row(s) from database
  public function delete($table,$where = null){
    // Check to see if table exists
    if($this->tableExists($table)){
      // The table exists check to see if we are deleting rows or table
      if($where == null){
        $delete = 'DELETE '.$table; // Create query to delete table
      }else{
        $delete = 'DELETE FROM '.$table.' WHERE '.$where; // Create query to delete rows
      }
      // Submit query to database
      if($del = @mysql_query($delete)){
        array_push($this->result,mysql_affected_rows());
        $this->myQuery = $delete; // Pass back the SQL
        return true; // The query exectued correctly
      }else{
        array_push($this->result,mysql_error());
        return false; // The query did not execute correctly
      }
    }else{
      return false; // The table does not exist
    }
  }

  // Function to update row in database
  public function update($table,$params=array(),$where){
    // Check to see if table exists
    if($this->tableExists($table)){
      // Create Array to hold all the columns to update
      $args=array();
      foreach($params as $field=>$value){
        // Seperate each column out with it's corresponding value
        $args[]=$field.'="'.$value.'"';
      }
      // Create the query
      $sql='UPDATE '.$table.' SET '.implode(',',$args).' WHERE '.$where;
      // Make query to database
      $this->myQuery = $sql; // Pass back the SQL
      if($query = @mysql_query($sql)){
        array_push($this->result,mysql_affected_rows());
        return true; // Update has been successful
      }else{
        array_push($this->result,mysql_error());
        return false; // Update has not been successful
      }
    }else{
      return false; // The table does not exist
    }
  }

  // Private function to check if table exists for use with queries
  private function tableExists($table){
    $tablesInDb = @mysql_query('SHOW TABLES FROM '.$this->db_name.' LIKE "'.$table.'"');
    if($tablesInDb){
      if(mysql_num_rows($tablesInDb)==1){
        return true; // The table exists
      }else{
        array_push($this->result,$table." does not exist in this database");
        return false; // The table does not exist
      }
    }
  }

  // Public function to return the data to the user
  public function getResult(){
    $val = $this->result;
    $this->result = array();
    return $val;
  }

  //Pass the SQL back for debugging
  public function getSql(){
    $val = $this->myQuery;
    $this->myQuery = array();
    return $val;
  }
  public function getLastInserted(){
    return mysql_insert_id();
  }
  public function numRows(){
    $val = $this->numResults;
    $this->numResults = array();
    return $val;
  }

  // Escape your string
  public function escapeString($data){
    return mysql_real_escape_string($data);
  }
} 