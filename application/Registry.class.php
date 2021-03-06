<?php
/**
 * Date: 06/02/15
 * Time: 19:51
 * Author: HJW88
 */


/**
 * Class Registry
 * The registry is an object
 * where site wide variables can be stored without the use of globals.
 */
Class Registry
{

    /*
    * @the vars array
    * @access private
    */
    private $vars = array();


    public function __construct(){
        session_start();
    }

    /**
     * @param $index
     * @param $value
     */
    public function __set($index, $value)
    {
        $this->vars[$index] = $value;
    }

    /**
     * @param $index
     * @return mixed
     */
    public function __get($index)
    {
        return $this->vars[$index];
    }


}

