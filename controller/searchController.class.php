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

                $form = new formViewController('','search');
                $form->addFromNormalInput('input','text','name','Name',null,null,false);
                $form->addFromNormalInput('input','text','event','Event',null,null,false);
                $form->addFromNormalInput('input','text','theme','theme',null,null,false);

                $form->addFromNormalInput('input','number','pricefrom','Price From',null,null,false);
                $form->addFromNormalInput('input','number','priceto','Price To',null,null,false);

                $form->addFormSelection('select','gender','Gender',array('Male'=>'Male','Female'=>'Female','Natural'=>'Natural'));
                $form->addFormSelection('radio','image','With Image',array('yes'=>'Yes','no'=>'No'));

                $form->showForm();

                break;

            case 'POST':
                
                $name = $_POST['name'] != '' ? $_POST['name'] : null;
                $theme = $_POST['theme'] != '' ? $_POST['theme'] : null;
                $event = $_POST['event'] != '' ? $_POST['event'] : null;
                $pricefrom = $_POST['pricefrom'] != '' ? $_POST['pricefrom'] : null;
                $priceto = $_POST['priceto'] != '' ? $_POST['priceto'] : null;
                $gender = $_POST['gender'] != '' ? $_POST['gender'] : null;
                $image = $_POST['image'] == 'yes' ? true : false;

                $condition = array();

                // use lowercase to
                if ($name){
                    $condition[] = ' LOWER(name) LIKE "%'.$name.'%"';
                }
                if ($theme){
                    $condition[] = ' LOWER(themes) LIKE "%'.$theme.'%"';
                }
                if ($event){
                    $condition[] = ' LOWER(events) LIKE "%'.$event.'%"';
                }
                if ($pricefrom){
                    $condition[] = ' price >= ' . $pricefrom;
                }
                if ($priceto){
                    $condition[] = ' price <= ' . $priceto;
                }
                if ($gender){
                    $condition[] = ' gender = "'.$gender.'"';
                }
                if ($image){
                    $condition[] = ' url IS NOT NULL';
                } else {
                    $condition[] = ' url IS NULL ';
                }

                $condition =  ' ' . implode(' AND ', $condition);

                error_log($condition);

                $products = ProductModel::getAllProducts($condition);

                if ($products){

                    $this->registry->template->products = $products;
                    $this->registry->template->show('product_box');

                } else {
                    echo 'No matched Products';
                }

                break;

        }



        $this->showFooter();

    }


}