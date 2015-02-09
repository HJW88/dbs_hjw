<?php
/**
 * Date: 06/02/15
 * Time: 21:02
 * Author: HJW88
 */


/**
 * Class userController
 * Do all the logic thing about user
 */
require_once('formViewController.php');
require_once(__SITE_PATH.'/model/userModel.php');

class userController extends  baseController{

    public function index(){
        echo "User";
    }

    public function signup(){

        $this->showHeader('SignUp');

        switch ($_SERVER['REQUEST_METHOD']){
            case 'GET':
                $this->showAlert();
                $this->showSignupForm();

                break;

            case 'POST':
                $this->unsetSesstion('alert');
                // check password
                if ($_POST['password1'] != $_POST['password2']){
                    $this->setSesstion('alert', 'warning','Password must be the same');
                }
                // check username
                if ($user = userModel::getUserByUsername($_POST['username'])){
                    $this->setSesstion('alert','alert', 'Username already exists, Use a new one');
                } else {
                    $user = userModel::createUser($_POST);
                }
                //$this->goBack();
                break;
        }

        $this->showFooter();
    }

    public function login(){
        echo "login";
    }

    public function logout(){
        echo "logout";
    }


    /**
     * Show singupForm
     */
    private function showSignupForm(){

        $form = new formViewController('Welcome to create a new account', 'user/signup');
        $form->addFromNormalInput('input','text','username','Username','Username');
        $form->addFromNormalInput('input','email','email','Email','Email');
        $form->addFromNormalInput('input','password','password1','Password1','Password1');
        $form->addFromNormalInput('input','password','password2','Password2','Password2');

        $form->addFromNormalInput('input','text','firstname','Firstname');
        $form->addFromNormalInput('input','text','lastname','Lastname');

        $form->addFormSelection('select','gender','Gender',array('Male'=>'Male',
            'Female'=>'Female'));

        $form->addFormSelection('select','type','Account Type',array('Admin'=>'Admin',
            'Customer'=>'Customer'));
        $form->showForm();
    }

}