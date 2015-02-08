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
     * Render view from html template file
     *
     * @param $name
     * @return bool
     * @throws Exception
     */
    function show($name)
    {
        $path = __SITE_PATH . '/views' . '/' . $name . '.html';

        if (file_exists($path) == false) {
            error_log('Template not found in ' . $path);
            return false;
        }
        /*** Import variables into the current
         * symbol table from an array
         ***/
        extract($this->vars);
        include($path);
    }

}


