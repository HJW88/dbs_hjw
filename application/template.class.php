<?php
/**
 * Date: 06/02/15
 * Time: 19:51
 * Author: HJW88
 */

/**
 * Class Template
 *
 * This class present a view object
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
     * @param $registry
     */
    function __construct($registry)
    {
        $this->registry = $registry;

    }


    /**
     * @param $index
     * @param $value
     */
    public function __set($index, $value)
    {
        $this->vars[$index] = $value;
    }


    function show($name)
    {
        $path = __SITE_PATH . '/views' . '/' . $name . '.html';

        if (file_exists($path) == false) {
            throw new Exception('Template not found in ' . $path);
            return false;
        }

        // Load variables
        foreach ($this->vars as $key => $value) {
            $$key = $value;
        }

        include($path);
    }

}


