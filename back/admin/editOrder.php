<?php
//Loading global variables
include_once '../api/modules/order/orderDao.php';
$oid = $_GET['oid'];
$orderDao = new orderDao();
$order = $orderDao->getOrderByOid($_GET['oid']);
$status = $order[0]['status'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
  <meta name="description" content=""/>
  <meta name="keywords" content=""/>
  <meta name="author" content=""/>
  <link rel="stylesheet" type="text/css" href="style.css" media="screen"/>
  <link rel="stylesheet" type="text/css" href="../media/css/jquery.dataTables.css" media="screen"/>
  <script type="text/javascript" src="../js/jscron.js"></script>
  <script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
  <script type="text/javascript" src="../media/js/jquery.dataTables.js"></script>
  <script type="text/javascript" src="../js/admin.js"></script>
  <title>Easy Delivery</title>
</head>
<body>
<div id="wrapper">
  <?php include('includes/header.php'); ?>
  <?php include('includes/nav.php'); ?>
  <div id="content">

    <h3>Orden</h3>
    <input type="hidden" id="oid" name="oid" class="txt" value="<?php print $oid; ?>">
    <label for="status">Status</label>
    <select id='statusDropdown' name='vendor'>
      <option value="<?php print $status; ?>">
        <?php print $status; ?>
      </option>
      <option value="nueva">
        Nueva
      </option>
      <option value="activa">
        Activa
      </option>
      <option value="eliminada">
        Eliminada
      </option>
    </select>
    <br>
    <br>
    <button id="saveOrder">Actualizar</button>
    <button id="viewDetail">Ver Detalle</button>

  </div>
  <!-- end #content -->
  <!--  --><?php //include('includes/sidebar.php'); ?>
  <?php include('includes/footer.php'); ?>
</div>
<!-- End #wrapper -->
</body>
</html>