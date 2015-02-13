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
class userController extends BaseController
{

    public function index()
    {
        if ($user = userController::getLoginUser()) {
            $this->showHeader('My Account');
            $this->showAlert();


            // update form
            $this->showUpdateUserForm($user);
            // order list
            $this->showOrderList();

            $this->showFooter();
        } else {
            $this->setSesstion('alert','warning','Please Login');
            $this->redirectTo('user/login');
        }
    }

    public function signup()
    {

        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->showHeader('SignUp');
                $this->showAlert();
                $this->showSignupForm();
                $this->showFooter();
                break;

            case 'POST':
                // check password
                if ($_POST['password1'] != $_POST['password2']) {
                    $this->setSesstion('alert', 'warning', 'Password must be the same');
                    $this->redirectTo('user/signup');
                    break;
                }
                // check username
                if ($user = UserModel::getUserByUsername($_POST['username'])) {
                    $this->setSesstion('alert', 'alert', 'Username already exists, Use a new one');
                    $this->redirectTo('user/signup');
                    break;
                } else {
                    $_POST['is_admin'] = $_POST['type'] =='Admin'? true : false;
                    $user = UserModel::createUser($_POST);
                    $this->setSesstion('alert', 'success', 'Sign Up success!');
                    $this->loginUser($user);
                }
                break;
        }
    }

    public function login()
    {

        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->showHeader('Login');
                $this->showAlert();
                $this->showLoginForm();
                $this->showFooter();
                break;

            case 'POST':
                if ($user = UserModel::getUserByUsername($_POST['username'], $_POST['password'])) {
                    $this->loginUser($user);
                } else {
                    $this->setSesstion('alert', 'alert', 'Login failed');
                    $this->redirectTo('user/login');
                }
                break;
        }

    }

    public function logout()
    {
        error_log('User Logout'. $_SESSION['user']['username']);
        $this->setSesstion('alert','success','Logout success! Hope to see you again!');
        $this->unsetSesstion('user');
        $this->redirectTo('index');
    }


    public function update(){

        if (!userController::isRoot() && !userController::isTestUser()){

            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                // todo
                if ($_POST['password1'] != $_POST['password2']) {
                    $this->setSesstion('alert', 'warning', 'Password must be the same');
                    $this->redirectTo('user/signup');
                    return;
                }

                $data = array('email'=>$_POST['email'], 'password'=>$_POST['password1'], 'firstname'=>$_POST['firstname'], 'lastname'=>$_POST['lastname'],'gender'=>$_POST['gender']);

                if ($user = UserModel::updateUser($_POST['id'],$data)){

                    // update session
                    foreach($user as $key => $value){
                        $this->setSesstion('user',$key,$value);
                    }
                    $this->setSesstion('alert','success','User successfully modified');
                }


            }

        } else {
            $this->setSesstion('alert','alert','Permission Denney, this default user can not be modified');
        }
        $this->redirectTo('user');
    }


    /**
     * @param $user
     * @return bool
     */
    private function loginUser($user)
    {
        foreach ($user as $key => $value) {
            if ($key != 'password') {
                $this->setSesstion('user', $key, $value);
            }
        }
        error_log('User Login'.json_encode($_SESSION['user']));
        $this->setSesstion('alert', 'success', 'Thanks for your Login!');
        $this->redirectTo('index');
    }

    /**
     * Show singupForm
     */
    private function showSignupForm()
    {

        $form = new formViewController('Welcome to create a new account', 'user/signup');
        $form->addFromNormalInput('input', 'text', 'username', 'Username', 'Username');
        $form->addFromNormalInput('input', 'email', 'email', 'Email', 'Email');
        $form->addFromNormalInput('input', 'password', 'password1', 'Password1', 'Password1');
        $form->addFromNormalInput('input', 'password', 'password2', 'Password2', 'Password2');

        $form->addFromNormalInput('input', 'text', 'firstname', 'Firstname');
        $form->addFromNormalInput('input', 'text', 'lastname', 'Lastname');

        $form->addFormSelection('select', 'gender', 'Gender', array('Male' => 'Male',
            'Female' => 'Female'));

        $form->addFormSelection('select', 'type', 'Account Type', array('Admin' => 'Admin',
            'Customer' => 'Customer'));
        $form->showForm();
    }


    private function showUpdateUserForm($user){

        $form = new formViewController('Update your information','user/update');

        $form->addFromNormalInput('input','hidden','id','',$user['id'],$user['id']);
        $form->addFromNormalInput('input', 'email', 'email', 'Email', $user['email']);
        $form->addFromNormalInput('input', 'password', 'password1', 'Password1', 'Password1');
        $form->addFromNormalInput('input', 'password', 'password2', 'Password2', 'Password2');

        $form->addFromNormalInput('input', 'text', 'firstname', 'Firstname', $user['firstname']);
        $form->addFromNormalInput('input', 'text', 'lastname', 'Lastname',$user['lastname']);

        $form->addFormSelection('select', 'gender', 'Gender', array('Male' => 'Male',
            'Female' => 'Female'));

        $form->showForm();

    }

    /**
     * Show login form
     */
    private function showLoginForm()
    {
        $form = new formViewController('Welcome to Login', 'user/login');
        $form->addFromNormalInput('input', 'text', 'username', 'Username', 'Username');
        $form->addFromNormalInput('input', 'password', 'password', 'Password', 'Password');
        $form->showForm();
    }


    private function showOrderList(){

        if (self::isAdmin()){

        } else {
        if ($user = self::getLoginUser()){
            if ($orderlist = ProductModel::getOrderList($user['id'])){
                $this->registry->template->orderlist = $orderlist;
                $this->registry->template->show('orderlist');
            }
        }
        }
    }

    /**
     * Test if user is superuser/root
     * @return bool
     */
    public static function isRoot(){
        if (isset($_SESSION['user'])){
            if ($_SESSION['user']['username'] == __ROOT){
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function isTestUser(){
        if (isset($_SESSION['user'])){
            if ($_SESSION['user']['username'] == 'testuser'){
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function isAdmin(){

        if (isset($_SESSION['user']))
            if ($_SESSION['user']['is_admin']) {
                return true;
            } else {
                return false;
        } else {
            return false;
        }
    }

    public static function getLoginUser(){
        if (isset($_SESSION['user'])){
            return $_SESSION['user'];
        } else {
            return null;
        }
    }


}