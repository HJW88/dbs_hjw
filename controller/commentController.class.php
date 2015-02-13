<?php
/**
 * Date: 13/02/15
 * Time: 01:24
 * Author: HJW88
 */

class commentController extends BaseController{

    public function index(){

    }


    public function add(){
        if (userController::getLoginUser() && $_SERVER['REQUEST_METHOD'] == 'POST'){
            if (ProductModel::addProductComment($_POST['product'], $_POST['user'],$_POST['rating'], $_POST['text'])){
                $this->setSesstion('alert','success','Comment adding success');
            } else {
                $this->setSesstion('alert','alert','Comment adding failed');
            }
        } else {
            $this->setSesstion('alert','alert','Permission Denney');
        }
        $this->redirectTo('product/view&id='.(int)$_POST['product']);
    }

}