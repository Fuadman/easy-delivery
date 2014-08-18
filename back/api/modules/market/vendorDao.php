<?php
/**
 * Created by PhpStorm.
 * User: fsalomon
 * Date: 7/14/14
 * Time: 2:47 PM
 */
include_once '../api/modules/core/database.php';
class vendorDao {
  const VENDOR_TABLE = 'vendor';
  const VENDOR_CATEGORY_TABLE = 'vendor_category';
  const CATEGORY_TABLE = 'categories';

  public function  getVendorsListRendered($vid) {
    $output = '';
    $vendors = $this->getEntityVendorsArray();
    $selectedItem = '';
    $output .= "<select id='vidDropdown' name='vendor'>";
    foreach ($vendors as $vendor) {
      if ($vid == $vendor['vid']){
        $selectedItem = 'selected="selected"';
      }
      $output .= "<option value='" . $vendor['vid'] . "' ".$selectedItem.">" . $vendor['name'] . "</option>";
      $selectedItem='';
    }
    $output .= "</select>";
    return $output;
  }

  function addVendor($vendor) {
    $database = new database();
    try {
      $database->connect();
      $database->insert($this::VENDOR_TABLE, array(
        'name' => $vendor->name,
        'description' => $vendor->description,
        'address' => $vendor->address
      ));
      $database->disconnect();
      $data['success'] = TRUE;
      $data['errors'] = 'Vendor added successfully';
      return $data;
    } catch (mysqli_sql_exception $e) {
      $data['success'] = FALSE;
      $data['errors'] = $e->getMessage();
      return $data;
    }
  }

  public
  function editVendor($vendor) {
    $database = new database();
    try {
      $database->connect();
      $database->update($this::VENDOR_TABLE, array(
        'name' => $vendor->name,
        'description' => $vendor->description,
        'address' => $vendor->address
      ), $vendor->vid);
      $database->disconnect();
      $data['success'] = TRUE;
      $data['errors'] = 'Vendor was updated successfully';
      return $data;
    } catch (mysqli_sql_exception $e) {
      $data['success'] = FALSE;
      $data['errors'] = $e->getMessage();
      return $data;
    }
  }

  public
  function getVendorsByCid($cid) {
    $database = new database();
    try {
      $sql = "SELECT v.vid, v.name, v.description, v.address, c.name as category FROM " . $this::VENDOR_CATEGORY_TABLE . " vc, " . $this::VENDOR_TABLE . " v, " . $this::CATEGORY_TABLE . " c WHERE v.vid = vc.vid and vc.cid = c.cid and c.cid =" . $cid;
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

  public
  function getEntityVendorsArray() {
    $database = new database();
    $sql = "SELECT * FROM " . $this::VENDOR_TABLE;
    try {
      $database->connect();
      $database->sql($sql);
      $results = $database->getResult();
      $database->disconnect();
      return $results;
    } catch (mysqli_sql_exception $e) {
      $data['success'] = FALSE;
      $data['errors'] = $e->getMessage();
      echo $data;
    }
  }

//  public function getVendorsByCategoryId($cid){
//    $database = new database();
//    try {
//
//    }
//    catch(mysqli_sql_exception $e){
//      $data['success'] = false;
//      $data['message'] = $e->getMessage();
//    }
//  }
} 