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
 * This controller do all basis things like session, header setting
 *
 *
 */
Abstract Class BaseController
{

    /*
     * @registry object
     */
    protected $registry;

    function __construct($registry)
    {
        $this->registry = $registry;
    }


    function setSesstion($name, $key, $value){
        $_SESSION[$name][$key] = $value;
    }

    function unsetSesstion($name){
        unset($_SESSION[$name]);
    }

    function showAlert(){
        $this->registry->template->show('alert');
        $this->unsetSesstion('alert');
    }

    function showHeader($title){
        $this->registry->template->title = $title;
        $this->registry->template->show('header');
    }

    function showFooter(){
        $this->registry->template->show('footer');
    }


    function redirectTo($location){
        header('Location: ?rt='.$location);
    }

    /**
     * @all controllers must contain an index method
     */
    abstract function index();
}


