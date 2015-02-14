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

        // Show all users
        if ($users = UserModel::getUsersByCondition()){
            $table = new tableViewController('Users','All Users',$users);
            $table->showTable();
        }

        echo '<hr/>';

        // Show all Products, only some import infomation
        if ($products = ProductModel::getAllProducts()){
            $new = array();
            foreach($products as $product){
                $nt = array();
                $nt['id'] = $product['id'];
                $nt['name'] = $product['name'];
                $nt['type'] = $product['type'];
                $nt['price'] = $product['price'];
                $nt['gender'] = $product['gender'];
                $id = $product['id'];
                $nt['operation'] = '<a class="button tiny alert" href="?rt=product/delete&id='.$id.'">Delete</a>';
                $nt['operation'] .= '<a class="button tiny warning" href="?rt=product/view&id='.$id.'">Edit</a>';
                $new[] = $nt;
            }

            $table = new tableViewController('Product','All Products',$new);
            $table->showTable();
        }
        echo '<a class="button success large right" href="?rt=product/add">Add New Product</a><hr/>';

        // Show all themes
        if ($themes = ETModel::getAllETByCondition('theme',null)){
            $new = array();
            foreach($themes as $theme){
                $nt = array();
                $id = $theme['id'];
                $nt['operation'] = '<a class="button tiny alert" href="?rt=et/delete&id='.$id.'&type=theme">Delete</a>';
                $nt['operation'] .= '<a class="button tiny warning" href="?rt=et/edit&id='.$id.'&type=theme">Edit</a>';
                $nt = array_merge( $theme, $nt);
                $new[] = $nt;
            }

            $table = new tableViewController('Theme','All Themes',$new);
            $table->showTable();
        }

        echo '<a class="button success large right" href="?rt=et/add">Add New Theme</a><hr/>';


        // Show All Events

        if ($themes = ETModel::getAllETByCondition('event',null)){
            $new = array();
            foreach($themes as $theme){
                $nt = array();
                $id = $theme['id'];
                $nt['operation'] = '<a class="button tiny alert" href="?rt=et/delete&id='.$id.'&type=event">Delete</a>';
                $nt['operation'] .= '<a class="button tiny warning" href="?rt=et/edit&id='.$id.'&type=event">Edit</a>';
                $nt = array_merge($theme, $nt);
                $new[] = $nt;
            }

            $table = new tableViewController('Event','All Events',$new);
            $table->showTable();
        }

        echo '<a class="button success large right" href="?rt=et/add">Add New Event</a><hr/>';


        // Show All Orders
        if ($orders = ProductModel::getAllOrderByUserID()){
            $table = new tableViewController('Orders','All Orders',$orders);
            $table->showTable();
        }


        // Show Comments
        if ($comments = ProductModel::getAllProductCommentsByProductID()){
            $table = new tableViewController('Comments','All Comment',$comments);
            $table->showTable();
        }


        $this->showFooter();

    }
}