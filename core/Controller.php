<?php

class Controller {

    protected $_controller;
    protected $_method;
    public $view;

    /* Use constructor to set the controller and method values coming from Router.php. Also generates new View object. */
    public function __construct($controller, $method) {
        $this->_controller = $controller;
        $this->_method = $method;
        $this->view = new View();
    }

    /* Define function that loads a model when called from extended controllers. */
    protected function loadModel($model) {
        if (class_exists($model)) {
            /* Dynamically create a property to store a newly-instantiated model. Pass in 'users' to get Model Users. 
               The value returned from strtolower($model) should equate to the desired database table name, such as 'users' */
            $this->{$model} = new $model(strtolower($model));
        }
    }

}
