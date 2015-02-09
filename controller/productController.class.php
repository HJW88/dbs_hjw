<?php
/**
 * Date: 09/02/15
 * Time: 21:37
 * Author: HJW88
 */


class productController extends BaseController{

    public function index(){
        echo 'product';
    }


    public function add(){
        if (userController::isCustomer()){
            $this->setSesstion('alert','warning','Permission denney!');
            $this->redirectTo('index');
        } else {

            switch ($_SERVER['REQUEST_METHOD']){

                case 'GET':
                    $this->showHeader('Product Adding');
                    $this->showAlert();
                    $this->showProductForm('Product Adding', 'product/add',null);
                    $this->showFooter();
                    break;


                case 'POST':

                    echo json_encode($_POST);
                    break;

            }

        }
    }


    protected function showProductForm($title, $action, $product = null){

        $form = new formViewController($title, $action);

        if ($product){
            $form->addFromNormalInput('input','number','id','',$product['id'],$product['id'], true, false);
        }
        $form->addFromNormalInput('input','text','name','Product Name',$product?$product['name']:null, $product?$product['name']:null);
        $form->addFromNormalInput('textarea','text','description','Product Description',$product?$product['description']:null, $product?$product['description']:null);
        $form->addFromNormalInput('input','number','price','Price',$product?$product['price']:null, $product?$product['price']:null);
        $form->addFromNormalInput('input','number','shipping','Shipping Cost:',$product?$product['shipping']:null, $product?$product['shipping']:null);
        $form->addFormSelection('radio','gender','Gender',array('Male'=>'Male', 'Female'=>'Female', 'Natural'=>'Natural'));
        $form->addFormSelection('radion','type','Type', array('Costume'=>'Costume', 'Accessory'=>'Accessory'));

        $form->showForm();
    }



}