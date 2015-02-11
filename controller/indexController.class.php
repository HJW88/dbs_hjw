<?php
/**
 * Date: 06/02/15
 * Time: 19:51
 * Author: HJW88
 */

Class indexController Extends BaseController
{

    public function index()
    {
        /*** set a template variable ***/
        $this->registry->template->title = 'HWJ88::HHU';

        /*** load the index template ***/
        $this->showHeader('Homepage');
        $this->showAlert();
        $this->showFooter();
        
    }
}


