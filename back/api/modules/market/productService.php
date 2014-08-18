<?php
/**
 * Created by PhpStorm.
 * User: fsalomon
 * Date: 7/10/14
 * Time: 12:08 PM
 */
include_once 'productDao.php';
class productService {
  public function getProductListArray() {
    $productDao = new productDao();
    return $productDao->getAllEntireProducts();
  }

  public function getProductList($categoryId, $searchTerm, $vid) {
    $productDao = new productDao();
    $query = "";
    if (!empty($categoryId)) {
      $query .= " cid = " . $categoryId;
    }
    if (!empty($searchTerm)) {
      if (empty($query)) {
        $query .= " name like '%" . $searchTerm . "%'";
      }
      else {
        $query .= " AND name like '%" . $searchTerm . "%'";
      }
    }
    if (!empty($vid)) {
      if (empty($query)) {
        $query .= " vid = " . $vid;
      }
      else {
        $query .= " AND vid = " . $vid;
      }
    }
    echo '{"results": ' . json_encode($productDao->getAllProducts($query)) . '}';
  }

  public function getCategories() {
    $productDao = new productDao();
    echo '{"results": ' . json_encode($productDao->getCategories()) . '}';
  }

  public function getAllProductsRendered() {
    $allProducts = $this::getProductListArray();
    $output = '';
    $output.= $this->getActionButtons();
    $output.= '<table id="example" class="display" cellspacing="0" width="100%"><thead>
        <tr>
            <th>Pid</th>
            <th>Nombre</th>
            <th>Vendedor</th>
            <th>Year</th>
            <th>Descripcion</th>
            <th>Precio</th>
            <th>Imagen</th>
        </tr>
    </thead><tbody>';
    foreach ($allProducts as $product) {
      $output .= '<tr id = '.$product['pid'].'>
            <td>'.$product['pid'].'</td>
            <td>'.$product['name'].'</td>
            <td>'.$product['vendor'].'</td>
            <td>'.$product['year'].'</td>
            <td>'.$product['description'].  '</td>
            <td>'.$product['price'].'</td>
            <td>'.$product['picture'].'</td>
        </tr>';
    }
    $output .= '</tbody>
</table>';
    return $output;
  }
  public function getProductView($pid){
    $productDao = new productDao();
    $output = '';
    $product = $productDao->getProductByPid($pid);
    $output .= "<div class = 'single_product_container'>";
    $output.="<div>".$product[0]['pid']."</div>";
    $output.="<div>".$product[0]['name']."</div>";
    $output.="<div>".$product[0]['description']."</div>";
    $output.="<div>".$product[0]['price']."</div>";
    $output.="<div>".$product[0]['picture']."</div>";
    $output .= "</div>";
    return $output;
  }
  public function getActionButtons(){
    $output = '<div class="actionButtonContainer">';
    $output .= '<button id="deleteProduct">Borrar el producto seleccionado</button>';
    $output .= '<button id="addProduct">Nuevo Producto</button>';
    $output .= '<button id="editProduct">Editar producto seleccionado</button>';
    $output .= '</div>';
    return $output;
  }
  public function addProduct($request){
    $productDao = new productDao();
    $product = json_decode($request->getBody());
    if(!empty($product->pid)){
      $productDao->editProduct($product);
    }
    else {
      $productDao->addProduct($product);
    }
  }
}