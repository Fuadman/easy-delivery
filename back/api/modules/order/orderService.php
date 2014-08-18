<?php
/**
 * Created by PhpStorm.
 * User: fsalomon
 * Date: 7/14/14
 * Time: 9:24 AM
 */

include_once 'orderDao.php';
include_once 'orderSettings.php';

class orderService {
  public function getCartProductsByUser($uid) {
    $orderDao = new orderDao();
    echo '{"products": ' . json_encode($orderDao->getOrderProductsByUser($uid)) . '}';
  }

  public function updateOrderStatus($request) {
    $orderDao = new orderDao();
    $order = json_decode($request->getBody());
    $orderDao->updateOrderStatus($order->status, $order->oid);
  }

  public function addProductToOrder($request) {
    $orderDao = new orderDao();
    $order = json_decode($request->getBody());
    $orderProductTransaction = json_encode($orderDao->addProductToOrder($order));
    $this->updateOrder($order->oid);
    echo $orderProductTransaction;
  }

  public function getAllOrdersRendered() {
    $orderDao = new orderDao();
    $allOrders = $orderDao->getEntityOrdersArray();
    $output = '';
    $output .= $this->getActionButtons();
    $output .= '<table id="example" class="display" cellspacing="0" width="100%"><thead>
        <tr>
            <th>Oid</th>
            <th>Dirección</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Correo</th>
            <th>Estado</th>
        </tr>
    </thead><tbody>';
    foreach ($allOrders as $order) {
      $style = '';
      switch ($order['status']) {
        case 'nueva':
          $style = 'style="background: #ff173b";';
          break;
        case 'activa':
          $style = 'style="background: #2cff44";';
          break;
        case 'eliminada':
          $style = 'style="background: #6e73ff";';
          break;
      }
      $output .= '<tr id = ' . $order['oid'] . '>
            <td>' . $order['oid'] . '</td>
            <td>' . $order['description'] . '</td>
            <td>' . $order['name'] . '</td>
            <td>' . $order['lastname'] . '</td>
            <td>' . $order['mail'] . '</td>
            <td '.$style.'>' . $order['status'] . '</td>
        </tr>';
    }
    $output .= '</tbody>
</table>';
    return $output;
  }

  public function updateOrder($oid) {
    $orderDao = new orderDao();
    $database = new database();
    $allProductsFromOrder = $orderDao->getCompleteOrderProductsByOid($oid);
    $totalOrder = 0;
    $totalDelivery = 0;
    foreach ($allProductsFromOrder as $product) {
      $totalOrder += $product['price'] * $product['quantity'];
    }

    if ($totalOrder < 100) {
      $totalDelivery = $totalOrder * FACTOR100;
    }
    else {
      if ($totalOrder >= 100 && $totalOrder < 200) {
        $totalDelivery = $totalOrder * FACTOR200;
      }
      else {
        $totalDelivery = $totalOrder * FACTOR;
      }
    }
    $database->connect();
    $database->update($orderDao::ORDERS_TABLE, array(
        'totalproducts' => $totalOrder,
        'totaldelivery' => $totalDelivery
      ), 'oid = ' . $oid);
    $database->disconnect();
  }

  public function getNewOrderArrived() {
    $orderDao = new orderDao();
    if (count($orderDao->getOrderByStatus('nueva')) > 0) {
      echo TRUE;
    }
    else {
      echo FALSE;
    }
  }

  public function getAllOrderProductsRendered($oid) {
    $output = '';
    $orderDao = new orderDao();
    $allProducts = $orderDao->getCompleteOrderProductsByOid($oid[0]['oid']);
    $output .= '<div class = "totalService">';
    $output .= 'Total a cobrar ';
    $output .= $oid[0]['totaldelivery']+$oid[0]['totalproducts'];
    $output .= '</div>';
    $output .= '<div class = "totalproducts">';
    $output .= 'Costo total de los productos: ' . $oid[0]['totalproducts'];
    $output .= '</div>';
    $output .= '<div class = "totalDelivery">';
    $output .= 'Costo total del servicio: ' . $oid[0]['totaldelivery'];
    $output .= '</div>';

    $output .= '<table id="example" class="display" cellspacing="0" width="100%"><thead>
        <tr>
            <th>Pid</th>
            <th>Nombre</th>
            <th>Descripcion</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Total</th>
        </tr>
    </thead><tbody>';
    foreach ($allProducts as $product) {
      $output .= '<tr id = ' . $product['pid'] . '>
            <td>' . $product['pid'] . '</td>
            <td>' . $product['name'] . '</td>
            <td>' . $product['description'] . '</td>
            <td>' . $product['quantity'] . '</td>
            <td>' . $product['price'] . '</td>
            <td>' . $product['price'] * $product['quantity'] . '</td>
        </tr>';
    }
    $output .= '</tbody>
</table>';
    return $output;
  }

  public function getActionButtons() {
    $output = '<div class="actionButtonContainer">';
    $output .= '<button id="deleteOrder">Borrar la orden seleccionada</button>';
    $output .= '<button id="editOrder">Editar la orden seleccionada</button>';
    $output .= '<button id="viewOrder">Ver detalles de la orden seleccionada</button>';
    $output .= '</div>';
    return $output;
  }
} 