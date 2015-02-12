<?php
/**
 * Date: 13/02/15
 * Time: 00:05
 * Author: HJW88
 */


$thmbnail_normal = <<<EOD
<div class="small-4 columns">

<a class="th" href="{url}">
  <img src="{url}" alt="{alt}">
</a>

</div>

EOD;


$thmbnail_admin = <<<EOD

<div class="small-4 columns">
<a class="th" href="{url}">
  <img src="{url}" alt="{alt}">
</a>
<br/>
<a class="button alert tiny" href="?rt=image/delete&id={id}">Delete</a>
</div>


EOD;

$uploadButton = <<<EOD
<form class="panel radius small-3 columns" action="?rt=image/add" method="post" enctype="multipart/form-data">

        <input name="image" type="file" placeholder="Product Image" value="" required>
        <input name="product" type="hidden" value="{productID}">

    <div class="row">
        <div class="small-3 columns">
            <input class="button small success" type="submit" value="Upload New Image">
        </div>
    </div>

</form>
EOD;


echo '<hr/><h3 id="image">Product Images</h3>';

require_once('helper.php');
if (!empty($images)) {



    foreach($images as $image){

        if ($admin){

            echo format($thmbnail_admin,array('url'=>$image['url'], 'alt'=>$alt, 'id'=>$image['id']));

        } else {
            echo format($thmbnail_normal,array('url'=>$image['url'], 'alt'=>$alt, 'id'=>$image['id']));

        }

    }

}

if ($admin){
    echo format($uploadButton, array('productID'=>$product['id']));
}