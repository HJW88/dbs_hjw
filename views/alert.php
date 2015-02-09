<?php
/**
 * Date: 09/02/15
 * Time: 17:17
 * Author: HJW88
 */

require_once('helper.php');


$alert = <<<EOD
<div data-alert class="alert-box {type} radius">
    {msg}
</div>
EOD;


if (isset($_SESSION['alert'])){
    foreach($_SESSION['alert'] as $key=>$value){
        echo format($alert, array('type' => $key, 'msg' => $value));
    }
}


