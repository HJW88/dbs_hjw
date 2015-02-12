<?php
/**
 * Date: 12/02/15
 * Time: 21:21
 * Author: HJW88
 */

$title_normal = <<<EOD
<table class="large-8 colums" id="{type}">
<caption>Related {type}</caption>
EOD;


$title_admin = <<<EOD
<hr/>
<h3 id="{type}">Modify Related {type}</h3>
EOD;


$table_head_normal = <<<EOD
  <thead>
    <tr>
      <th width="200";>Name</th>
      <th>Description</th>
    </tr>
  </thead>
  <tbody>
EOD;



$table_head_admin = <<<EOD
<table>
  <thead>
    <tr>
      <th width="200">Name</th>
      <th>Description</th>
      <th width="100">Operation</th>
      <th width="100">Edit</th>
    </tr>
  </thead>
  <tbody>
EOD;


$table_body_normal = <<<EOD
    <tr>
      <td>{name}</td>
      <td witdh="200">{description}</td>
    </tr>
EOD;


$table_body_admin_isrelated = <<<EOD
    <tr>
      <td>{name}</td>
      <td>{description}</td>
      <td><a class="button tiny alert" href="?rt=et/dorelated&id={id}&productID={productID}&action=delete&type={type}">Delete Related</a></td>
      <td><a class="button tiny warning" href="?rt=et/edit&id={id}&type={type}">Edit</a></td>
    </tr>
EOD;

$table_body_admin_notrelated = <<<EOD
    <tr>
      <td>{name}</td>
      <td>{description}</td>
      <td><a class="button tiny success" href="?rt=et/dorelated&id={id}&productID={productID}&action=add&type={type}">ADD Related</a></td>
      <td><a class="button tiny warning" href="?rt=et/edit&id={id}&type={type}">Edit</a></td>
    </tr>
EOD;


$table_tail = <<<EOD
</tbody>
</table>
EOD;


require_once('helper.php');

// show events
if (!empty($objects)){

  if ($admin){
    echo format($title_admin, array('type'=>$type));
    echo $table_head_admin;

  } else {
    echo format($title_normal, array('type'=>$type));
    echo $table_head_normal;
  }



  foreach($objects as $object){
    if ($admin){

      if ($object['isRelated']){
        echo format($table_body_admin_isrelated, array('name'=>$object['name'],'description'=>$object['description'],'id'=>$object['id'],'productID'=>$productID,'type'=>$type));
      } else {
        echo format($table_body_admin_notrelated, array('name'=>$object['name'],'description'=>$object['description'],'id'=>$object['id'],'productID'=>$productID,'type'=>$type));
      }

    } else {
      if ($object['isRelated']) {
        echo format($table_body_normal, array('name' => $object['name'], 'description' => $object['description']));
      }
    }
  }

  echo $table_tail;

}




