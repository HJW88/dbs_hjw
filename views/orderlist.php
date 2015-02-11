<?php
/**
 * Date: 11/02/15
 * Time: 19:05
 * Author: HJW88
 */

$title_normal = <<<EOD
<hr/>
<h3 id="orders">Your Orders</h3>
EOD;


$table_head_normal = <<<EOD
<table>
  <thead>
    <tr>
      <th>OrderID</th>
      <th>Product</th>
      <th>Size</th>
      <th>StartDate</th>
      <th>EndDate</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
EOD;


$table_body_normal = <<<EOD

    <tr>
      <td>{orderid}</td>
      <td>{product}</td>
      <td>{size}</td>
      <td>{startDate}</td>
      <td>{endDate}</td>
    </tr>

EOD;


$table_tail = <<<EOD
</tbody>
</table>
EOD;


require_once('helper.php');


if (isset($admin)){
    // admin model




} else {
    echo $title_normal;
    echo $table_head_normal;

    if (isset($orderlist) && !empty($orderlist)){
        foreach($orderlist as $order){
            echo format($table_body_normal, $order);
        }
    }
    echo $table_tail;
}
