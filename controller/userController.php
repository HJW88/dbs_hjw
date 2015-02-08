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
class userController extends  baseController{

    public function index(){
        echo "User";
    }

    public function signup(){
        switch ($_SERVER['REQUEST_METHOD']){
            case 'GET':
                $this->registry->template->title = 'Signup';
                $this->registry->template->show('header');

                $form = new formViewController('Sign Up New Account', 'user/signup');
                $form->addFromNormalInput('input','text','name','Username','Username');
                $form->addFromNormalInput('input','email','email','Email','Email');
                $form->addFromNormalInput('input','password','password1','Password1','Password1');
                $form->addFromNormalInput('input','password','password2','Password2','Password2');

                $form->addFromNormalInput('input','text','firstname','Firstname');
                $form->addFromNormalInput('textarea','text','lastname','Lastname');

                $form->addFormSelection('radio','gender','Gender',array('Male','Female','Natural'));
                $form->show();

                $this->registry->template->show('footer');

                break;

            case 'POST':
                echo(json_encode($_POST));
                break;
        }
    }

    public function login(){
        echo "login";
    }

    public function logout(){
        echo "logout";
    }

}