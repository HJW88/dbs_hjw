<?php
/**
 * Date: 08/02/15
 * Time: 02:35
 * Author: HJW88
 */


require_once('helper.php');


echo <<<EOD
<h3>{$title}</h3>
    <form action="?rt={$action}" method="post" enctype="multipart/form-data">
EOD;



$inputtag = <<<EOD

    <div class="row">
        <div class="small-3 columns">
          <label for="{name}" class="right inline">{label}</label>
        </div>
        <div class="small-9 columns">
        <input name="{name}" type="{type}" placeholder="{placeholder}" value="{value}" {step} {required}>
        </div>
    </div>

EOD;

$textareatag = <<<EOD

    <div class="row">
        <div class="small-3 columns">
          <label for="{name}" class="right inline">{label}</label>
        </div>
        <div class="small-9 columns">
        <textarea name="{name}" type="{type}" placeholder="{placeholder}" value="{value}" {required}></textarea>
        </div>
    </div>

EOD;


$selecttag_head = <<<EOD

<div class="row">
    <div class="small-3 columns">
          <label for="{name}" class="right inline">{label}</label>
    </div>
     <div class="small-9 columns">
        <select name={name} {required}>
EOD;


$selecttag_option = <<<EOD
<option value="{value}">{text}</option>
EOD;


$selecttag_footer = <<<EOD
 </select>
 </div>

</div>

EOD;


$rediohead = <<<EOD

<div class="row">
    <div class="small-3 columns">
          <label for="{name}" class="right inline">{label}</label>
    </div>
     <div class="small-9 columns">

EOD;

$rediocontent = <<<EOD

      <input type="radio" name="{name}" value="{value}" {required}><label for="{name}">{text}</label>

EOD;


$rediofooter = <<<EOD
</div>
</div>

EOD;






foreach ($tags as $name=>$data){
    switch ($data['tag']){

        case 'input':
            echo format($inputtag, $data);
            break;

        case 'textarea':
            echo format($textareatag, $data);
            break;

        case 'select':
            echo format($selecttag_head, $data);

            foreach($data['options'] as $key=>$option){
                echo format($selecttag_option, array('value'=>$key, 'text'=>$option));
            }

            echo $selecttag_footer;
            break;

        case 'radio':
            echo format($rediohead, $data);

            foreach($data['options'] as $value=>$text){
                echo format($rediocontent, array('name'=>$name , 'required'=>$data['required'], 'value'=> $value, 'text'=>$text));
            }

            echo $rediofooter;

            break;
    }
}


echo <<<EOD
    <div class="row">

        <div class="small-3 columns">
        </div>

        <div class="small-9 columns">
            <input class="button small" type="submit" value="submit">
        </div>

    </div>
</form>
EOD;



