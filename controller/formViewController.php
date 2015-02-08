<?php
/**
 * Date: 08/02/15
 * Time: 01:46
 * Author: HJW88
 */


/**
 * Class formViewController
 * This controller help to build html form quickly
 */
class formViewController {

    private $vars = array();


    public function __construct($title,$action){
        $this->vars['title'] = $title;
        $this->vars['action'] = $action;
        $this->vars['tags'] = array();
    }


    /**
     *
     *
     * @param $tag
     * @param $type
     * @param $name
     * @param $label
     * @param null $placeholder
     * @param null $value
     * @param bool $required
     */
    public function addFromNormalInput($tag, $type, $name, $label, $placeholder=null, $value = null, $required = true){
        $this->vars['tags'][$name] = array();
        $this->vars['tags'][$name]['tag'] = $tag;
        $this->vars['tags'][$name]['label'] = $label;
        $this->vars['tags'][$name]['name'] = $name;
        $this->vars['tags'][$name]['type'] = $type;
        $this->vars['tags'][$name]['value'] = $value;
        $this->vars['tags'][$name]['placeholder'] = $placeholder ? $placeholder : $label;
        $this->vars['tags'][$name]['required'] = $required? 'required' : '';
    }

    /**
     * Add select/radio form data
     *
     * @param $name
     * @param array $options, array of values
     * @param $required
     */
    public function addFormSelection($tag, $name, $label, $options=array(), $required=true){
        $this->vars['tags'][$name] = array();
        $this->vars['tags'][$name]['tag'] = $tag;
        $this->vars['tags'][$name]['label'] = $label;
        $this->vars['tags'][$name]['name'] = $name;
        $this->vars['tags'][$name]['required'] = $required? 'required' : '';
        $this->vars['tags'][$name]['options'] = $options;
    }

    /**
     * Load html view view
     *
     * @param $view
     * @return bool|string
     * @throws Exception
     */
    private function loadViewPath($view){
        $path = __SITE_PATH . '/views' . '/'. $view .'.php';
        if (file_exists($path) == false) {
            error_log('Template not found in ' . $path);
            return false;
        } else {
            return $path;
        }
    }

    /**
     * Render view with data stored in vars
     * @param string $view
     */
    public function show($view='form'){
        $path = $this->loadViewPath($view);
        extract($this->vars);
        include($path);
    }

}