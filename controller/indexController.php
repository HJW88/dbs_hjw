<?php
/**
 * Date: 06/02/15
 * Time: 19:51
 * Author: HJW88
 */
Class indexController Extends baseController
{

    public function index()
    {
        /*** set a template variable ***/
        $this->registry->template->welcome = 'Welcome to PHPRO MVC';
        /*** load the index template ***/
        $this->registry->template->show('index');
    }

}


