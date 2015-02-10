<?php

/**
 * Date: 09/02/15
 * Time: 21:37
 * Author: HJW88
 */
class productController extends BaseController
{

    public function index()
    {
        $allProducts = ProductModel::getAllProducts(null);

        $this->showHeader('All Products');
        $this->showAlert();

        $this->registry->template->products = $allProducts;
        $this->registry->template->show('product_box');

        $this->showFooter();
    }


    public function view()
    {
        echo 'view product' . $_GET['id'];
    }

    public function delete(){
        //@todo
    }

    public function edit()
    {
        switch ($_SERVER['REQUEST_METHOD']) {

            case 'GET':

                if ($product = ProductModel::getProductByID($_GET['id'])){
                    $this->showHeader('Edit Product: ' . $product['name']);
                    $this->showAlert();
                    $this->showProductForm('Product Detail','product/edit',$product);
                    $this->showFooter();
                }
                break;

            case 'POST':

                break;

        }
    }
    public function add()
    {
        if (userController::isCustomer()) {
            $this->setSesstion('alert', 'warning', 'Permission denney!');
            $this->redirectTo('index');
        } else {

            switch ($_SERVER['REQUEST_METHOD']) {

                case 'GET':
                    $this->showHeader('Product Adding');
                    $this->showAlert();
                    $this->showProductForm('Adding New Product', 'product/add', null);
                    $this->showFooter();
                    break;


                case 'POST':
                    // test product already exists
                    if (ProductModel::getAllProducts(' name = "' . $_POST['name'] . '"')) {
                        $this->setSesstion('alert', 'warning', 'Product exists!');
                        $this->redirectTo('product/add');
                    } else {
                        $url = uploader::getUploadImageUrl();

                        if ($url) {
                            if ($product = ProductModel::addProduct($_POST, $url)) {
                                $this->setSesstion('alert', 'success', 'Product Add Ok!');
                                $this->redirectTo('product');
                            } else {
                                $this->setSesstion('alert', 'alert', 'Product Add failed!');
                                $this->redirectTo('product');
                            }
                        } else {
                            $this->redirectTo('product/add');
                        }
                    }
                    break;
            }
        }
    }


    protected function showProductForm($title, $action, $product = null)
    {

        $form = new formViewController($title, $action);

        if ($product) {
            $form->addFromNormalInput('input', 'hidden', 'id', '', $product['id'], $product['id'], true, true);
        }

        $form->addFromNormalInput('input', 'text', 'name', 'Product Name', $product ? $product['name'] : null, $product ? $product['name'] : null);
        $form->addFromNormalInput('textarea', 'text', 'description', 'Product Description', null, $product ? $product['description'] : null);
        if (!$product) {
            $form->addFromNormalInput('input', 'file', 'image', 'Product Image', $product ? $product['url'] : null, $product ? $product['url'] : null);
        }
        $form->addFromNormalInput('input', 'number', 'price', 'Price', $product ? $product['price'] : null, $product ? $product['price'] : null);
        $form->addFromNormalInput('input', 'number', 'shipping', 'Shipping Cost:', $product ? $product['shipping'] : null, $product ? $product['shipping'] : null);
        $form->addFormSelection('radio', 'gender', 'Gender', array('Male' => 'Male', 'Female' => 'Female', 'Natural' => 'Natural'));
        $form->addFormSelection('radion', 'type', 'Type', array('Costume' => 'Costume', 'Accessory' => 'Accessory'));

        $form->showForm();
    }


}