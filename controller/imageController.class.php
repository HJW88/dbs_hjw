<?php

/**
 * Date: 13/02/15
 * Time: 00:18
 * Author: HJW88
 */
class imageController extends BaseController
{

    public function index()
    {

    }


    public function delete()
    {
        if (userController::isAdmin() && isset($_GET['id'])){
            if (ProductModel::deleteProductImage($_GET['id'])){
                $this->setSesstion('alert', 'success', 'Image Delete Success');
            } else {
                $this->setSesstion('alert', 'alert', 'Image Delete Failed');
            }
        } else {
            $this->setSesstion('alert', 'warning', 'Permission Denney');
        }
        $this->redirectTo('product/view&id=' . $_POST['product']);
    }

    public function add()
    {

        if (userController::isAdmin()) {

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product'])) {
                $url = uploader::getUploadImageUrl();
                if ($url) {
                    if (ProductModel::addProductImage($_POST['product'], $url)) {
                        $this->setSesstion('alert', 'success', 'Image Uploaded Success');
                    } else {
                        $this->setSesstion('alert', 'alert', 'Image Uploaded Failed');
                    }
                }
            }

        } else {
            $this->setSesstion('alert', 'warning', 'Permission Denney');
        }
        $this->redirectTo('product/view&id=' . $_POST['product']);
    }

}