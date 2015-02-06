<?php
/**
 * Date: 06/02/15
 * Time: 19:51
 * Author: HJW88
 */
Abstract Class baseController
{

    /*
     * @registry object
     */
    protected $registry;

    function __construct($registry)
    {
        $this->registry = $registry;
    }

    /**
     * @all controllers must contain an index method
     */
    abstract function index();
}


