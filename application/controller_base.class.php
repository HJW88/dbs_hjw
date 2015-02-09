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


    function setSesstion($name, $key, $value){
        $_SESSION[$name][$key] = $value;
    }

    function unsetSesstion($name){
        unset($_SESSION[$name]);
    }

    function showAlert(){
        $this->registry->template->show('alert');
    }

    function showHeader($title){
        $this->registry->template->title = $title;
        $this->registry->template->show('header');
    }

    function showFooter(){
        $this->registry->template->show('footer');
    }


    function goBack(){
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    /**
     * @all controllers must contain an index method
     */
    abstract function index();
}


