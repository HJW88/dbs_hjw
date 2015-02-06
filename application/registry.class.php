<?php
/**
 * Date: 06/02/15
 * Time: 19:51
 * Author: HJW88
 */
Class Registry
{

    /*
    * @the vars array
    * @access private
    */
    private $vars = array();


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

