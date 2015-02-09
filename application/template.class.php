<?php
/**
 * Date: 06/02/15
 * Time: 19:51
 * Author: HJW88
 */

/**
 * Class Template
 *
 * This class present a view object.
 * The template.class.php file contains the class definition.
 * Like the other classes, it has the registry available to it
 * and also contains a __set() method in which template variables
 * may be set and stored.
 */
Class Template
{

    /*
     * @the registry
     * @access private
     */
    private $registry;

    /*
     * @Variables array
     * @access private
     */
    private $vars = array();

    /**
     * Template Object delegate the viewController
     *
     * @param $registry
     */
    function __construct($registry)
    {
        $this->registry = $registry;
    }


    /**
     * Set template variables
     * @param $index
     * @param $value
     */
    public function __set($index, $value)
    {
        $this->vars[$index] = $value;
    }


    /**
     * Load html view view
     *
     * @param $view
     * @return bool|string
     * @throws Exception
     */
    protected function loadViewPath($view){
        $path1 = __SITE_PATH . '/views' . '/' . $view . '.html';
        $path2 = __SITE_PATH . '/views' . '/' . $view . '.php';
        $path = file_exists($path1)? $path1 : $path2;
        if (file_exists($path) == false) {
            error_log('Template not found in ' . $path);
            return false;
        } else {
            return $path;
        }
    }

    /**
     * Render view from html template file
     *
     * @param $name
     * @return bool
     * @throws Exception
     */
    public function show($name)
    {
        $path = $this->loadViewPath($name);
        /*** Import variables into the current
         * symbol table from an array
         ***/
        extract($this->vars);
        include($path);
    }

}


