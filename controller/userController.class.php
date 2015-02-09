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
        echo "User";
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
        $this->setSesstion('alert','success','Logout success! Hope to see you again!');
        $this->unsetSesstion('user');
        $this->redirectTo('index');
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

    public static function isCustomer(){
        if (isset($_SESSION['user']))
            if ($_SESSION['user']['customernr']) {
                return true;
            } else {
                return false;
        } else {
            return false;
        }
    }

}