<?php
/**
 * Date: 08/02/15
 * Time: 01:46
 * Author: HJW88
 */


/**
 * Class formViewController
 * This controller help to build html form quickly
 * It generate all useful elements
 */
class formViewController extends Template{

    private $vars = array();


    /**
     * @param $title, the form has a title
     * @param $action, the url to post
     * @param $small, boolean, denote if in small model
     */
    public function __construct($title,$action, $small=false){
        $this->vars['title'] = $title;
        $this->vars['action'] = $action;
        $this->vars['small'] = $small;
        $this->vars['tags'] = array();
    }


    /**
     *
     *
     * @param $tag, can be input, textarea,
     * @param $type, can be text, password, date, email, hidden
     * @param $name, element name
     * @param $label, element string
     * @param null $placeholder, element placeholder
     * @param null $value, value
     * @param bool $required
     * @param bool $disabled, if this disabled, then no data will be retrieved
     */
    public function addFromNormalInput($tag, $type, $name, $label, $placeholder=null, $value = null, $required = true, $disabled=false){
        $this->vars['tags'][$name] = array();
        $this->vars['tags'][$name]['tag'] = $tag;
        $this->vars['tags'][$name]['label'] = $label;
        $this->vars['tags'][$name]['name'] = $name;
        $this->vars['tags'][$name]['type'] = $type;
        // html5 step attribut for type number
        $this->vars['tags'][$name]['step'] = $type=='number'? 'step="0.01"' : null;
        $this->vars['tags'][$name]['value'] = $value;
        $this->vars['tags'][$name]['placeholder'] = $placeholder ? $placeholder : $label;
        $this->vars['tags'][$name]['required'] = $required? 'required' : '';
        $this->vars['tags'][$name]['disabled'] = $disabled? 'disabled' : '';
    }

    /**
 * @param $tag, can be select or radio
 * @param $name, the element name
 * @param $label, element label
 * @param array $options, array of {value:text}
 * @param bool $required, if required
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
     * @param string $view
     */
    public function showForm($view='form'){
        $path = $this->loadViewPath($view);
        extract($this->vars);
        include($path);
    }

}