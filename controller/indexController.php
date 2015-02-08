<?php
/**
 * Date: 06/02/15
 * Time: 19:51
 * Author: HJW88
 */

require_once('formViewController.php');
Class indexController Extends baseController
{

    public function index()
    {
        /*** set a template variable ***/
        $this->registry->template->title = 'HWJ88::HHU';

        /*** load the index template ***/
        $this->registry->template->show('header');
        //$this->registry->template->show('index');


        $form = new formViewController('Sign','hi');
        $form->addFromNormalInput('input','text','name','Name','name');
        $form->show();

        $this->registry->template->show('footer');

        
    }
}


