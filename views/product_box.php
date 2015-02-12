<?php
/**
 * Date: 10/02/15
 * Time: 00:21
 * Author: HJW88
 */

$image = <<<EOD

  <li><a class="th" href="?rt=product/view&id={id}"><img src="{url}" style="width:100%;height:250px;"></a></li>

EOD;

$head = <<<EOD

<!-- product box start -->
<div class="small-4 columns">
<ul class="pricing-table">
  <li class="title">{name}<li>

EOD;

$tail = <<<EOD

  <li class="price">{price} <span class="label radius">Shipping: {shipping}</span> </li>

  <li class="bullet-item">
  <span class="label success radius">{gender}</span>
  <span class="label radius">{type}</span>
  </li>

  <li class="bullet-item"><span class="label warning radius">Exemplaes:</span> {exemplars}</li>
  <li class="bullet-item"><span class="label warning radius">Events:</span> {events}</li>
  <li class="bullet-item"><span class="label alert radius">Themes:</span> {themes}</li>
  <li class="bullet-item"><span class="label radius">Average Rating By {reviews} Users</span> {rating}</li>
  <li class="cta-button"><a class="button" href="?rt=product/view&id={id}">Borrow Now</a></li>
</ul>
</div>

<!-- product box over -->

EOD;

require_once('helper.php');

if (isset($products) and !empty($products)) {
    foreach ($products as $product) {
        echo format($head, $product);

        if (isset($product['url'])){
            echo format($image, $product);
        }

        echo format($tail, $product);
    }
}