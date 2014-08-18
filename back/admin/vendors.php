<?php
//Loading global variables
include_once '../api/modules/market/vendorService.php';
$vendorService = new vendorService();
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

    <h3>Lista de Vendedores</h3>
    <?php print $vendorService->getAllVendorsRendered(); ?>

  </div>
  <!-- end #content -->
<!--  --><?php //include('includes/sidebar.php'); ?>
  <?php include('includes/footer.php'); ?>
</div>
<!-- End #wrapper -->
</body>
</html>