<?php
/**
 * Date: 14/02/15
 * Time: 00:17
 * Author: HJW88
 */

/**
 * Class tableViewController
 * This class build a table for an array
 */
class tableViewController extends Template {

    private $vars = array();

    /**
     * Need three things to build tables
     * @param $title, title as <h3>
     * @param $caption, the table caption
     * @param $data, an assoc array
     */
    public function __construct($title, $caption = null, $data){
        $this->vars['title'] = $title;
        $this->vars['caption'] = $caption;
        $this->vars['data'] = $data;
    }

    /**
     * Default view is 'table'
     * @param string $view
     */
    public function showTable($view = 'table'){
        $path = $this->loadViewPath($view);
        extract($this->vars);
        include($path);
    }


}