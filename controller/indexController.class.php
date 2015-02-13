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
       // REDIRECT TO PRODUCT
        $this->redirectTo('product');
    }
}


