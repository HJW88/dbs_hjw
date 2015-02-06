<?php
/**
 * Date: 06/02/15
 * Time: 19:51
 * Author: HJW88
 */

/**
 * Class baseController,
 *
 * All other controller must extended from this class,
 * and implement the index() function.
 *
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


