<?php
/**
 * Date: 12/02/15
 * Time: 20:29
 * Author: HJW88
 */

class adminController extends BaseController{


    public function index(){

        $this->showHeader('Admin');
        $this->showAlert();
        //todo

        $this->showFooter();


    }
}