<?php
/**
 * Date: 13/02/15
 * Time: 02:04
 * Author: HJW88
 */

class searchController extends BaseController {

    public function index(){

        $this->showHeader('Search');

        switch($_SERVER['REQUEST_METHOD']){

            case 'GET':
                break;


            case 'POST':
                break;
        }



        $this->showFooter();

    }


}