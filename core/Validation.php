<?php

namespace Core;

use Core\Database;
use Core\Input;

class Validation {

    private $_passed = false, $_errors = [], $_database = NULL;

    public function __construct() {
        $this->_database = Database::instance();
    }

    /* Method takes $source originating from $_POST[...] and $items[] is a large array containing form validation rules. 
       Note that multiple foreach loops are required to unpack data in $items as $items array contains other arrays. 
       The $source argument is often a $_POST array, and $items is a multidimensional array with validation rules. */
    public function validate($source, $items = []) {
        /* Reset the $_errors property as this validation may have been run before during a user's session. */
        $this->_errors = [];
        /* First of two nested foreach() loops. Method check() takes $  */
        foreach ($items as $item => $rules) {
            /* Within foreach(), run $_POST values through htmlentities() to ensure HTML characters are converted into 'entities' 
               that can't be used to inject <script> tags into the application. */
            $item = Input::sanitize($item);
            /* Grab th  */
            $display = $rules['display'];
            /* Loop through each of the $rules. On each loop, set $value to sanitized and trimmed $source[$item]. Note that 
               $rules is itself an array, hence necessity of a further foreach() loop. The array data in loop looks like this:
               ['display' => "Username", 'require' => true] */
            foreach ($rules as $rule => $rule_value) {
                $value = Input::sanitize(trim($source[$item]));
                /* If the 'required' rule is set to rule_value of true and no value is provided, execute setError() and return to 
                   the Register controller. */
                if ($rule === 'required' && empty($value)) {
                    $this->setError(["{$display} is required.", $item]);
                } else if (!empty($value)) {
                    switch ($rule) {
                        case 'min' :
                            if (strlen($value) < $rule_value) {
                                $this->setError(["{$display} must be a minimum of {$rule_value} characters.", $item]);
                            }
                            break;
                        case 'max' :
                            if (strlen($value) > $rule_value) {
                                $this->setError(["{$display} cannot contain more than {$rule_value} characters.", $item]);
                            }
                            break;
                        case 'matches' :
                            if ($value != $source[$rule_value]) {
                                $matchDisplay = $items[$rule_value]['display'];
                                $this->setError(["{$matchDisplay} and {$display} must match.", $item]);
                            }
                            break;
                        case 'unique' :
                            /* Unique email example: "SELECT 'email' from 'table' WHERE 'email' = 'value'" 
                               For the 'unique' rule, the $rule_value is the table name, like 'users' */
                            $check = $this->_database->query("SELECT {$item} FROM {$rule_value} WHERE {$item} = ?", [$value]);
                            if ($check->count()) {
                                $this->setError(["{$display} already exists. Please choose another {$display}.", $item]);
                            }
                            break;
                        case 'unique_update' :
                            $exploded = explode(',', $rule_value);
                            $table = $exploded[0];
                            $id = $exploded[1];
                            $query = $this->_database->query("SELECT * FROM {$table} WHERE id != ? AND {$item} = ?", [$id, $value]);
                            if ($query->count()) {
                                $this->setError(["{$display} already exists. Please choose another {$display}.", $item]);
                            }
                            break;
                        case 'is_numeric' :
                            if (!is_numeric($value)) {
                                $this->setError(["{$display} must be a number. Please provide a numeric value.", $item]);
                            }
                            break;
                        case 'valid_email' :
                            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                                $this->setError(["{$display} must be a valid email address.", $item]);
                            }
                            break;
                        case 'valid_url' :
                            if (!filter_var($value, FILTER_VALIDATE_URL)) {
                                $this->setError(["{$display} must be a valid URL.", $item]);
                            }
                            break;
                    }
                }
            }
        }
        if (empty($this->_errors)) {
            $this->_passed = true;
        }
        return $this;
    }

    /* This method will accept an $error value from other methods in the Validate class. The typical call to this method: 
       $this->setError(["{display} is required", $item]); Note setError() accepts an error string and a data $item. */
    public function setError($error) {
        $this->_errors[] = $error;
        if (empty($this->_errors)) {
            $this->_passed = true;
        } else {
            $this->_passed = false;
        }
    }

    /* Simple getter method that returns the $_errors property. */
    public function errors() {
        return $this->_errors;
    }

    /* Evaluates to true or false based on whether any of the  */
    public function passed() {
        return $this->_passed;
    }

    public function displayErrors() {
        if ($this->_errors) {
            $html = '<div><ul>';
            foreach ($this->_errors as $error) {
                if (is_array($error)) {
                    $html .= '<li>' . $error[0] . '</li>';
                } else {
                    $html .= '<li>' . $error . '</li>';
                }
            }
            $html .= '</ul></div><br>';
            return $html;
        }
    }

}
