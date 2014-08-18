<?php
//Loading global variables
include_once '../api/modules/market/productService.php';
include_once '../api/modules/market/vendorDao.php';
$productDao = new productDao();
$vendorDao = new vendorDao();
if (isset($_GET['pid'])) {
  $product = $productDao->getProductByPid($_GET['pid']);
}
$name = $product[0]['name'];
$pid = $product[0]['pid'];
$description = $product[0]['description'];
$price = $product[0]['price'];
$image = $product[0]['picture'];
$vendorListRenderedAsDropdown = $vendorDao->getVendorsListRendered($product[0]['vid']);
$categoriesListRenderedAsDropdown = $productDao->getCategoriesListRendered($product[0]['cid']);
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
  <script type="text/javascript" src="../js/jquery.form.js"></script>
  <script type="text/javascript" src="../media/js/jquery.dataTables.js"></script>
  <script type="text/javascript" src="../js/admin.js"></script>
  <title>Easy Delivery</title>
</head>
<body>
<div id="wrapper">
  <?php include('includes/header.php'); ?>
  <?php include('includes/nav.php'); ?>
  <div id="content">

    <h3>Producto</h3>
    <input type="hidden" id="pid" name="pid" class="txt" value="<?php print $pid; ?>">
    <label for="email">Nombre</label>
    <input type="text" id="name" name="name" class="txt" value="<?php print $name; ?>">
    <br>
    <label for="msg">Descripcion</label>
    <textarea id="description" name="description" class="txtarea"><?php print $description; ?></textarea>
    <br>
    <label for="price">Precio</label>
    <input type="text" id="price" name="price" class="txt" value="<?php print $price; ?>">
    <br>
    <label for="vendor">Vendedor</label>
    <?php print $vendorListRenderedAsDropdown; ?>
    <br>
    <label for="categoria">Categoria</label>
    <?php print $categoriesListRenderedAsDropdown; ?>
    <br>
    <br>
    <!-- loader.gif -->
    <img style="display:none" id="loader" src="loader.gif" alt="Loading...." title="Loading...."/>
    <!-- simple file uploading form -->
    <form id="form" action="ajaxupload.php" method="post" enctype="multipart/form-data">
      <input id="uploadImage" type="file" accept="image/*" name="image"/>
      <input id="uploadImageButton" type="submit" value="Upload">
    </form>
    <!-- preview action or error msgs -->
    <div class="image_upload_preview" id="preview"  <?php if (empty($image)) {
      print ('style="display:none"');
    } ?> ><?php if (!empty($image)) {
        print ('<img src="' . $image . '">');
      }?></div>
    <br>
    <br>
    <button id="saveProduct">Grabar</button>

  </div>
  <!-- end #content -->
  <!--  --><?php //include('includes/sidebar.php'); ?>
  <?php include('includes/footer.php'); ?>
</div>
<!-- End #wrapper -->
</body>
</html>