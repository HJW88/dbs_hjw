<?php
/**
 * Date: 13/02/15
 * Time: 01:06
 * Author: HJW88
 */


$comment_panel = <<<EOD

<div class="panel callout radius small-5">
  <p>{username}: <span class="button radius tiny right">{rating}<span></p>
  <p class="panel">{text}</p>
</div>

EOD;


$comment_form = <<<EOD

<form class="panel radius small-6 columns" action="?rt=comment/add" method="post" enctype="multipart/form-data">


    <input name="product" type="hidden" value="{productID}">
    <input name="user" type="hidden" value="{userID}">

    <div class="row">
    <input name="rating" type="number" step="1"  placeholder="Rating" required>
    </div>

    <div class="row">
    <textarea name="text" type="text"  placeholder="Comment" required></textarea>
    </div>


    <div class="row">
        <div class="small-3 columns">
            <input class="button small success" type="submit" value="Submit">
        </div>
    </div>

</form>
EOD;


require_once('helper.php');

echo '<hr/><h3>Product Comments</h3>';

if (!empty($comments)) {
    foreach ($comments as $comment) {
        echo format($comment_panel, array('username' => $comment['username'], 'rating' => $comment['rating'], 'text' => $comment['text']));
    }
}

echo format($comment_form, array('productID' => $product['id'], 'userID' => $user['id']));
