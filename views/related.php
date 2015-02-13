<?php
/**
 * Date: 11/02/15
 * Time: 03:28
 * Author: HJW88
 */



$table_head_normal = <<<EOD
<table>
  <thead>
    <tr>
      <th>Name</th>
      <th>Price</th>
      <th>Type</th>
      <th>Gender</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
EOD;


$table_head_admin = <<<EOD
<table class="large-6 columns">
  <thead>
    <tr>
      <th>Name</th>
      <th>Price</th>
      <th>Type</th>
      <th>Gender</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
EOD;


$table_body_normal = <<<EOD

    <tr>
      <td>{name}</td>
      <td>{price}</td>
      <td>{type}</td>
      <td>{gender}</td>
      <td><a class="button small" href="?rt=product/view&id={id}">View More</a></td>
    </tr>

EOD;

$table_body_add = <<<EOD

    <tr>
      <td><a href="?rt=product/view&id={id}">{name}</a></td>
      <td>{price}</td>
      <td>{type}</td>
      <td>{gender}</td>
      <td><a class="button success tiny" href="?rt=product/related&id1={id1}&id2={id}&action=add">Add Related</a></td>
    </tr>

EOD;

$table_body_delete = <<<EOD

    <tr>
      <td><a href="?rt=product/view&id={id}">{name}</a></td>
      <td>{price}</td>
      <td>{type}</td>
      <td>{gender}</td>
      <td><a class="button alert tiny" href="?rt=product/related&id1={id1}&id2={id}&action=delete">Delete Related</a></td>
    </tr>

EOD;



$table_tail = <<<EOD
</tbody>
</table>
EOD;

$title_normal = <<<EOD

<hr/>
<h3 id="related">Related Product</h3>

EOD;

$title_admin = <<<EOD
<hr/>
<h3 id="related">Modify Related Product</h3>
EOD;






require_once('helper.php');


if (isset($admin) && isset($id1) && isset($norelated)){
    // admin model

    echo $title_admin;

    if (isset($related) && !empty($related)){
        echo $table_head_admin;
        foreach($related as $product){
            $product = array_merge(array('id1'=>$id1), $product);
            echo format($table_body_delete, $product);
        }
        echo $table_tail;
    }

    if (!empty($norelated)){
        echo $table_head_admin;
        foreach($norelated as $product){
            $product = array_merge(array('id1'=>$id1), $product);
            echo format($table_body_add, $product);
        }
        echo $table_tail;
    }


} else {

    echo $title_normal;
    echo $table_head_normal;

    if (isset($related) && !empty($related)){
        foreach($related as $product){
            echo format($table_body_normal, $product);
        }
    }

    echo $table_tail;
}




