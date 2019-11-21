<?php

/* The Home controller will route and return pages for index, contact, about and other static, information-only pages
   that constitute the in 'welcoming' part of the web application. Sets of related pages that manage CRUD functionality,
   like the index, create, show and delete parts of a blog or a login system, for example, would share a single 
   controller with multiple methods corresponding to each CRUD action. */

namespace Core\Controller;

use Core\Controller;

class Home extends Controller {

    /* Run the parent's constructor and set it's values for _controller and _method properties. */
    public function __construct($controller, $method) {
        parent::__construct($controller, $method);     /* View object is instanciated by the parent Controller class. */
        $this->view->setLayout('default');
    }

    /* Default controller and method for the application. Take users to home via index.php view under home directory. */
    public function index() {
        $this->view->render('index');
    }

    public function vue() {
        $this->view->render('app');
    }

}
