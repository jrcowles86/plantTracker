<?php

namespace Core;

class View {

    protected $_head, $_body, $_title = SITE_TITLE, $_outputBuffer, $_layout = DEFAULT_LAYOUT, $_post, $_data, $_errors = []; 

    /* Method render() takes in view name and locates the appropriate view and layout files. This layout is set to a 
       global default.*/
    public function render($view) {
        if (file_exists(ROOT . DS . 'views' . DS . 'home' . DS . $view . '.php')) {
            include(ROOT . DS . 'views' . DS . 'home' . DS . $view . '.php');   /* Include view file matching provided $view string. */
            include(ROOT . DS . 'views' . DS . 'layouts' . DS . $this->_layout . '.php');   /* Include layout determined by this class. */
        } else if (file_exists(ROOT . DS . 'views' . DS . 'register' . DS . $view . '.php')) {
            include(ROOT . DS . 'views' . DS . 'register' . DS . $view . '.php');
            include(ROOT . DS . 'views' . DS . 'layouts' . DS . $this->_layout . '.php');
        } else if (file_exists(ROOT . DS . 'views' . DS . 'plants' . DS . $view . '.php')) {
            include(ROOT . DS . 'views' . DS . 'plants' . DS . $view . '.php');
            include(ROOT . DS . 'views' . DS . 'layouts' . DS . $this->_layout . '.php');
        }
    }

    /* Return a certain kind of content based on the $type value provided. More $type possibilies can be added on. */
    public function content($type) {
        if ($type == 'head') {
            return $this->_head;
        } else if ($type == 'body') {
            return $this->_body;
        }
        return false;    /* This is the else clause; if $type doesn't match 'head' or 'body', then return false. */
    }

    public function start($type) {
        $this->_outputBuffer = $type;
        ob_start();
    }

    public function end() {
        if ($this->_outputBuffer == 'head') {
            $this->_head = ob_get_clean();
        } else if ($this->_outputBuffer == 'body') {
            $this->_body = ob_get_clean();
        } else {
            die('You must first run the start() method.');
        }
    }

    public function setTitle($title) {
        $this->_title = $title;
    }

    public function getTitle() {
        return $this->_title;
    }

    public function setLayout($path) {
        $this->_layout = $path;
    }

    public function getlayout() {
        return $this->_layout;
    }

    public function setData($data) {
        $this->_data = $data;
    }

    public function getData() {
        return $this->_data;
    }

    public function setPost($post) {
        $this->_post = $post;
    }

    public function getPost() {
        return $this->_post;
    }

    public function setErrors($errors) {
        $this->_errors = $errors;
    }

    public function getErrors() {
        return $this->_errors;
    }

}
