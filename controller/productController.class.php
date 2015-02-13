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
        if (isset($_GET['id'])) {
            if ($product = ProductModel::getProductByID($_GET['id'])) {
                $this->showHeader($product['name']);
                $this->showAlert();
                // show product box
                $productOverview = ProductModel::getAllProducts('id = ' . $product['id']);
                $this->registry->template->products = $productOverview;
                $this->registry->template->show('product_box');

                // if admin show product edit form
                if (userController::isAdmin()) {
                    $this->showProductForm('Edit Product', 'product/edit&id=' . $product['id'], true, $product);
                } else {
                    $this->showOrderForm($product);
                    $this->registry->template->description = $product['description'];
                    $this->registry->template->show('product_description');
                }

                // image pannel
                $this->showImagesPanel($product);

                // event and themes
                $this->showEventOrThemeTable($product['id']);

                // recommend products
                $this->showRecommendsProductsPanel($product['id']);

                // comments
                $this->showProductComments($product);


                $this->showFooter();
            } else {
                $this->setSesstion('alert', 'warning', 'Product does not exist');
                $this->redirectTo('product');
            }
        } else {
            $this->setSesstion('alert', 'warning', 'Permision Denney');
            $this->redirectTo('index');
        }
    }

    public function delete()
    {
        //@todo
    }


    public function related()
    {
        if (!userController::isAdmin()) {
            $this->setSesstion('alert', 'warning', 'Permission Denney');
            $this->redirectTo('product');
        } else {
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                if (isset($_GET['id1']) && isset($_GET['id2']) && isset($_GET['action'])) {
                    if (ProductModel::doRelatedProduct($_GET['id1'], $_GET['id2'], $_GET['action'])) {
                        $this->setSesstion('alert', 'success', 'Modify Related Product Success');
                    } else {
                        $this->setSesstion('alert', 'success', 'Modify Related Product Failed');
                    }
                    $this->redirectTo('product/view&id=' . $_GET['id1'] . '#related');
                }
            } else {
                $this->setSesstion('alert', 'warning', 'Parameter wrong');
                $this->redirectTo('product');
            }
        }
    }


    public function edit()
    {
        if (!userController::isAdmin()) {
            $this->redirectTo('product');
        } else {

            switch ($_SERVER['REQUEST_METHOD']) {

                case 'GET':
                    $product = ProductModel::getProductByID($_GET['id']);

                    if (!$product) {
                        $this->setSesstion('alert', 'alert', 'Product does not exist');
                        $this->redirectTo('product/view&id=' . $_GET['id']);
                        break;

                    } else {
                        $this->showHeader('Edit Product: ' . $product['name']);
                        $this->showAlert();
                        $this->showProductForm('Product Detail', 'product/edit', false, $product);
                        $this->showFooter();
                        break;
                    }


                case 'POST':
                    $id = $_POST['id'];
                    $data = $this->getProductDataFromPost($_POST);

                    if (ProductModel::updateProduct($id, $data)) {
                        $exemplar = explode(',', $_POST['exemplar']);
                        ProductModel::doUpdateProductExemplar($exemplar, $_POST['id']);
                        $this->setSesstion('alert', 'success', 'Product Updated Successful!');
                        $this->redirectTo('product/view&id=' . $id);
                    } else {
                        $this->setSesstion('alert', 'alert', 'Product Updated Failed!');
                        $this->redirectTo('product/view&id=' . $id);
                    }

                    break;

            }
        }
    }

    /**
     * Order product
     */
    public function order()
    {
        if ($user = userController::getLoginUser()) {
            if (isset($_POST['id']) && isset($_POST['size']) && ($_POST['startDate']) && ($_POST['endDate'])) {
                if(ProductModel::doOrder($user['id'], $_POST['id'], $_POST['size'], $_POST['startDate'], $_POST['endDate'], 'add')){
                    $this->setSesstion('alert','success','Order Succeed, Thank you!');
                    $this->redirectTo('user/index');
                }
            }
        } else {
            $this->setSesstion('alert', 'warning', 'Please login');
            $this->redirectTo('user/login');
        }
    }

    /**
     * Action: add product
     */
    public function add()
    {
        if (!userController::isAdmin()) {
            $this->redirectTo('product');
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
                        $data = $this->getProductDataFromPost($_POST);

                        if ($product = ProductModel::addProduct($data, $url)) {

                            $exemplar = explode(',', $_POST['exemplar']);
                            ProductModel::doUpdateProductExemplar($exemplar, $product['id']);

                            $this->setSesstion('alert', 'success', 'Product Add Ok!');
                            $this->redirectTo('product/view&id=' . $product['id']);
                        } else {
                            $this->setSesstion('alert', 'alert', 'Product Add failed!');
                            $this->redirectTo('product/add');
                        }
                    }
                    break;
            }
        }
    }


    /**
     * Show a form for product adding or editing
     * @param $title , form title
     * @param $action , the action
     * @param $admin , if in admin/edit model
     * @param null $product , if adding new product, set this to null
     */
    protected function showProductForm($title, $action, $admin, $product = null)
    {

        $form = new formViewController($title, $action, $admin);

        // old product has id
        if ($product) {
            $form->addFromNormalInput('input', 'hidden', 'id', '', $product['id'], $product['id'], true, false);
        }

        $form->addFromNormalInput('input', 'text', 'name', 'Product Name', $product ? $product['name'] : null, $product ? $product['name'] : null);
        $form->addFromNormalInput('textarea', 'text', 'description', 'Product Description', null, $product ? $product['description'] : null);

        // new adding product can add image
        if (!$product) {
            $form->addFromNormalInput('input', 'file', 'image', 'Product Image', $product ? $product['url'] : null, $product ? $product['url'] : null, false);
        }

        $form->addFromNormalInput('input', 'text', 'exemplar', 'Exemplars,Use <kbd>,</kbd> as delimeter', $product ? $product['exemplar'] : null, $product ? $product['exemplar'] : null);
        $form->addFromNormalInput('input', 'number', 'price', 'Price', $product ? $product['price'] : null, $product ? $product['price'] : null);
        $form->addFromNormalInput('input', 'number', 'shipping', 'Shipping Cost:', $product ? $product['shipping'] : null, $product ? $product['shipping'] : null);
        $form->addFormSelection('radio', 'gender', 'Gender', array('Male' => 'Male', 'Female' => 'Female', 'Natural' => 'Natural'));
        $form->addFormSelection('radio', 'type', 'Type', array('Costume' => 'Costume', 'Accessory' => 'Accessory'));

        $form->showForm();
    }


    /**
     * Helper, to get product data from post
     * @param $post
     * @return array
     */
    private function getProductDataFromPost($post)
    {
        $data = array();
        $data['name'] = $post['name'];
        $data['description'] = $post['description'];
        $data['price'] = $post['price'];
        $data['shipping'] = $post['shipping'];
        $data['gender'] = $post['gender'];
        $data['type'] = $post['type'];
        return $data;
    }


    private function showOrderForm($product)
    {
        $form = new formViewController('Borrow This Product', 'product/order', true);

        $form->addFromNormalInput('input', 'hidden', 'id', '', '', $product['id']);
        $exemplar = array();
        foreach (explode(',', $product['exemplar']) as $size) {
            $exemplar[$size] = $size;
        }
        $form->addFormSelection('select', 'size', 'Size', $exemplar);
        $form->addFromNormalInput('input', 'date', 'startDate', 'Start Date');
        $form->addFromNormalInput('input', 'date', 'endDate', 'End Date');
        $form->showForm();

    }

    /***
     * Show the related products panel,
     * if in admin model, then split the panel in two columns
     * @param $productID
     */
    private function showRecommendsProductsPanel($productID)
    {

        $releated = ProductModel::getAllRelatedProductByProductID($productID);
        $this->registry->template->related = $releated;

        if (userController::isAdmin()) {
            $this->registry->template->admin = true;
            $this->registry->template->id1 = (int)$productID;
            $this->registry->template->norelated = ProductModel::getAllRelatedProductByProductID($productID, false);
        }

        $this->registry->template->show('related');

    }


    private function showEventOrThemeTable($productID){

        $events = ETModel::getAllETByProductID('event',$productID);
        $themes = ETModel::getAllETByProductID('theme',$productID);
        $this->registry->template->productID = $productID;
        $this->registry->template->admin = userController::isAdmin();

        // show events
        $this->registry->template->type = 'event';
        $this->registry->template->objects = $events;
        $this->registry->template->show('eventtheme');

        // show themes
        $this->registry->template->type = 'theme';
        $this->registry->template->objects = $themes;
        $this->registry->template->show('eventtheme');
    }


    private function showImagesPanel($product){
        $this->registry->template->product = $product;
        $images = ProductModel::getAllImageByProductID($product['id']);
        $this->registry->template->alt = $product['name'];
        $this->registry->template->images = $images;
        $this->registry->template->admin = userController::isAdmin();
        $this->registry->template->show('imagepanel');
    }


    private function showProductComments($product){
        $comments = ProductModel::getAllProductCommentsByProductID($product['id']);
        $this->registry->template->comments = $comments;
        $this->registry->template->product = $product;
        $this->registry->template->user = userController::getLoginUser();
        $this->registry->template->show('commentpanel');
    }
}