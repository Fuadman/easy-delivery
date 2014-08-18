<?php
/**
 * Created by PhpStorm.
 * User: fsalomon
 * Date: 7/10/14
 * Time: 12:08 PM
 */
include_once '../api/modules/core/database.php';
include_once '../api/modules/order/orderDao.php';
class productDao {
  const PRODUCTS_TABLE = 'products';

  public function getCategoriesListRendered($cid) {
    $output = '';
    $categories = $this->getCategories();
    $output .= "<select id='cidDropDown' name='category'>";
    $selectedValue = '';
    foreach ($categories as $category) {
      if($cid == $category['cid']){
        $selectedValue = "selected='selected'";
      }
      $output .= "<option value='" . $category['cid'] . "' ".$selectedValue.">" . $category['name'] . "</option>";
      $selectedValue='';
    }
    $output .= "</select>";
    return $output;
  }

  public function getAllProducts($query) {
    $database = new database();
    if (!empty($query)) {
      $sql = "SELECT * FROM " . $this::PRODUCTS_TABLE . ' where ' . $query;
    }
    else {
      $sql = "SELECT * FROM " . $this::PRODUCTS_TABLE;
    }
    try {
      $database->connect();
      $database->sql($sql);
      $results = $database->getResult();
      $database->disconnect();
      return $results;
    } catch (mysqli_sql_exception $e) {
      $data['success'] = FALSE;
      $data['errors'] = $e->getMessage();
      return $data;
    }
  }

  public function getAllEntireProducts() {
    $database = new database();
    $sql = "select p.pid, v.name as vendor, p.name, p.year, p.description, p.price, p.picture from products p, vendor v where p.vid = v.vid;";
    try {
      $database->connect();
      $database->sql($sql);
      $results = $database->getResult();
      $database->disconnect();
      return $results;
    } catch (mysqli_sql_exception $e) {
      $data['success'] = FALSE;
      $data['errors'] = $e->getMessage();
      return $data;
    }
  }

  public function getProductByPid($pid) {
    $database = new database();
    try {
      $sql = "SELECT * FROM " . $this::PRODUCTS_TABLE . " WHERE pid = " . $pid . " LIMIT 1";
      $database->connect();
      $database->sql($sql);
      $results = $database->getResult();
      $database->disconnect();
      return $results;
    } catch (mysqli_sql_exception $e) {
      $data['success'] = FALSE;
      $data['errors'] = $e->getMessage();
      return $data;
    }
  }

  public function addProduct($product) {
    $database = new database();
    try {
      $database->connect();
      $database->insert($this::PRODUCTS_TABLE, array(
        'vid' => $product->vid,
        'name' => $product->name,
//        'year' => $product->year,
        'description' => $product->description,
        'picture' => $product->picture,
        'cid' => $product->cid,
        'price' => $product->price
      ));
      $database->disconnect();
      $data['success'] = TRUE;
      $data['errors'] = 'Product added successfully';
      return $data;
    } catch (mysqli_sql_exception $e) {
      $data['success'] = FALSE;
      $data['errors'] = $e->getMessage();
      return $data;
    }
  }

  public function editProduct($product) {
    $database = new database();
    try {
      $database->connect();
      $database->update($this::PRODUCTS_TABLE, array(
        'vid' => $product->vid,
        'name' => $product->name,
//        'year' => $product->year,
        'description' => $product->description,
        'picture' => $product->picture,
        'cid' => $product->cid,
        'price' => $product->price
      ), 'pid = '.$product->pid);
      $database->disconnect();
      $data['success'] = TRUE;
      $data['errors'] = 'Product updated successfully';
      return $data;
    } catch (mysqli_sql_exception $e) {
      $data['success'] = FALSE;
      $data['errors'] = $e->getMessage();
      return $data;
    }
  }

  public function getCategories() {
    $database = new database();
    $sql = "SELECT * FROM categories";
    try {
      $database->connect();
      $database->sql($sql);
      $results = $database->getResult();
      $database->disconnect();
      return $results;
    } catch (mysqli_sql_exception $e) {
      $data['success'] = FALSE;
      $data['errors'] = $e->getMessage();
      return $data;
    }
  }

  public function deleteProduct($pid) {
    $orderDao = new orderDao();
    $database = new database();
    try {
      $database->connect();
      $database->delete($this::PRODUCTS_TABLE, "pid = " . $pid);
      $database->delete($orderDao::ORDERS_PRODUCTS_TABLE, "pid = " . $pid);
      $database->disconnect();
      return 'Item Borrado';
    } catch (mysqli_sql_exception $e) {
      $data['success'] = FALSE;
      $data['errors'] = $e->getMessage();
      return $data;
    }
  }
} 