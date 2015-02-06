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
        $_SESSION['user']['username'] = 'HWJ';
        /*** set a template variable ***/
        $this->registry->template->title = 'HWJ88::HHU';
        /*** load the index template ***/
        $this->registry->template->show('header');
        $this->registry->template->show('index');
        $this->registry->template->show('footer');
    }

    public function sayHi(){
        echo 'Hi';
    }

}


