<?php
/**
 * Date: 08/02/15
 * Time: 03:37
 * Author: HJW88
 */

/**
 * Help function to print associative array into format string
 *
 * @param $msg
 * @param $vars
 * @return mixed
 */
function format($msg, $vars = null)
{

    if (!$vars) {
        return '';
    }

    $newvars = array();
    foreach($vars as $key=>$value){
        if (!is_array($value)){
            $newvars[$key] = $value;
        }
    }

    $vars = $newvars;

    $vars = (array)$vars;

    $msg = preg_replace_callback('#\{\}#', function ($r) {
        static $i = 0;
        return '{' . ($i++) . '}';
    }, $msg);

    return str_replace(
        array_map(function ($k) {
            return '{' . $k . '}';
        }, array_keys($vars)),
        array_values($vars),
        $msg
    );

}