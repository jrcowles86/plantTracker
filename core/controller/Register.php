<?php

namespace Core\Controller;

use Core\Model\Users;
use Core\Controller;
use Core\Validate;
use Core\View;
use Core\Router;
use Core\Input;

class Register extends Controller {

    /* Every controller extended from base will require constructor to use $contoller and $method values from URL. 
       Users model is loaded in the Register constructor method. Users model will be used by the login() method below. */
    public function __construct($controller, $method) {
        parent::__construct($controller, $method);
        $this->loadModel('Users');
        $this->view->setLayout('default');
    }

    public function index() {
        $this->view->render('login');
    }

    public function login() {
        /* Begin by instantiating new Validation object. */
        $validation = new Validate();
        if (filter_has_var(INPUT_POST, 'username')) {
            /* Initial validation for login form user submissions. Run check() method on Validate and pass-in array of
               all the data elements that we want to check. Provide check() with the $_POST superglobal and specify each 
               array key in $_POST that is needed, along with an array of rules to apply. The array key => value pair
               'display' => "Username" ensures word 'username' is used in any error messages instead of 'login_username' */
            $validation->check($_POST, [
                'username' => [
                    'display' => "Username",
                    'require' => true
                ],
                'password' => [
                    'display' => "Password",
                    'required' => true,
                    'min' => 6
                ]
            ]); 
            if ($validation->passed()) {
                /* Assuming the Users model loaded in the __construct, execute the Model findByUsername() method to using
                   the Login Page submitted username/email input field. */
                $username = $_POST['username'];
                /* Execute findByUserName() in attempt to find a match on email or username. */
                $user = $this->Users->findByUsername($username);
                /* If a $username match exists, and the password provided matches... */
                if ($user && password_verify(Input::get('password'), $user->password)) {
                    /* Ternary operator evaluates if Remember Me on login form is checked; returns boolean into $rememberMe. The 
                       method Input::get() determines if origin is $_GET or $_POST, then runs the sanitize() method on the... */
                    $rememberMe = (isset($_POST['remember_me']) && Input::get('remember_me')) ? true : false ;
                    $user->login($rememberMe);
                    Router::redirect('/home/index');
                } else {
                    /* If validation does not pass, set an error on the View object so it is can be made available to view on 
                       login page. */
                    $validation->setError("There is an error with your username or password.");
                }
            }
        }
        $errors = $validation->displayErrors();
        $this->view->setErrors($errors);
        $this->view->render('login');
    }

    /* Method logout() calls function currentUsers() from helpers.php file, which in-turn calls static method on Users
       Users::currentLoggedInUser() */
    public function logout() {
        if (currentUser()) {
            currentUser()->logout();
        }
        router::redirect('/register/login');
    }

    public function register() {
        /* Instantiate a new instance of the Validate object. */
        $validation = new Validate;
        /* Note: per author, this empty assoc array fixes the problem of the PHP echo built into value="" attribute of input HTML 
           tags filling with PHP notices and errors when users first load /register/register. Ensures nothing returned in $_POST 
           until user actually submits data through the Register form. */
           $postedValues = [
               'first_name' => '',
               'last_name' => '',
               'email' => '',
               'username' => '',
               'password' => '',
               'password_confirm' => '',
               'use_case' => ''
           ];
        if ($_POST) {
            /* Function postedValues() defined in helper.php, iterates through $_POST array and runs sanitize() function on 
               each $value. */
            $postedValues = postedValues($_POST);
            $validation->check($_POST, [
                'first_name' => [
                    'display' => 'First Name',
                    'required' => true
                ],
                'last_name' => [
                    'display' => 'Last Name',
                    'required' => true
                ],
                'email' => [
                    'display' => 'Email Address',
                    'unique' => 'users',
                    'max' => 150,
                    'required' => true
                ],
                'username' => [
                    'display' => 'Username',
                    'unique' => 'users',      /* Specify which table the value must be unique to. */
                    'min' => 6,
                    'max' => 150,
                    'required' => true
                ],
                'password' => [
                    'display' => 'Password',
                    'min' => 8,
                    'required' => true
                ],
                'password_confirm' => [
                    'display' => 'Confirm Password',
                    'matches' => 'password',
                    'min' => 8,
                    'required' => true
                ],
                'use_case' => [
                    'display' => 'Use Case',
                    'required' => true
                ]
            ]);
            /* Set up a new Users object if validation is passed. */
            if ($validation->passed()) {
                $newUser = new Users();
                $newUser->registerNewUser($_POST);
                $newUser->login();
                Router::redirect('/home/index');
            }
        }
        $this->view->setPost($postedValues);
        $errors = $validation->displayErrors();
        $this->view->setErrors($errors);
        $this->view->render('register');
    }

}
