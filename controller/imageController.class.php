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

    /**
     * Delete image with product ID
     */
    public function delete()
    {
        if (userController::isAdmin() && isset($_GET['id'])){
            if (ProductModel::deleteProductImage($_GET['id'])){
                try{
                    unlink(__SITE_PATH.'/'.$_GET['url']);

                } catch (ErrorException $e){
                    error_log('Delete Image:'.__UPLOADS.$_GET['url']);
                }
                $this->setSesstion('alert', 'success', 'Image Delete Success');
            } else {
                $this->setSesstion('alert', 'alert', 'Image Delete Failed');
            }
        } else {
            $this->setSesstion('alert', 'warning', 'Permission Denney');
        }
        $this->redirectTo('product/view&id=' . $_GET['product']);
    }


    /**
     * Add image after uploader returning url
     */
    public function add()
    {

        if (userController::isAdmin()) {

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product'])) {
                // get uploader returned url
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