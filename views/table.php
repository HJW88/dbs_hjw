<?php
/**
 * Date: 14/02/15
 * Time: 00:14
 * Author: HJW88
 */



require_once('helper.php');

echo <<<EOD

<h3 id="{$title}">{$title}</h3>
<table class="large-12 columns" role="grid">
<caption>{$caption}</caption>
<thead>
    <tr>
EOD;

if (!empty($data)){

    // Do table header

    $header = array_keys($data[0]);

    foreach($header as $index=>$key){
        echo '<th>'.$key.'</th>';
    }
    echo <<<EOD
</tr>
  </thead>
  <tbody>

EOD;

    // Do table body
    foreach($data as $row){
        echo '<tr>';
        foreach($header as $index=>$key){
            echo '<td>' . $row[$key] . '</td>';
        }
        echo '</tr>';
    }

}

echo '</tbody></table>';



