<?php
/**
 * Created by PhpStorm.
 * User: fsalomon
 * Date: 7/23/14
 * Time: 4:02 PM
 */
include_once 'vendorDao.php';
class vendorService {
  public function getAllVendorsRendered(){
    $vendorDao = new vendorDao();
    $allVendors = $vendorDao->getEntityVendorsArray();
    $output = '<table id="example" class="display" cellspacing="0" width="100%"><thead>
        <tr>
            <th>Vid</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Dirección</th>

        </tr>
    </thead><tbody>';
    foreach ($allVendors as $vendor) {
      $output .= '<tr>
            <td>'.$vendor['vid'].'</td>
            <td>'.$vendor['name'].'</td>
            <td>'.$vendor['description'].'</td>
            <td>'.$vendor['address'].'</td>

        </tr>';
    }
    $output .= '</tbody>
</table>';
    return $output;
  }
} 