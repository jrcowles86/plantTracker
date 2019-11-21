<?php

namespace Core\Model;

use Core\Database;
use Core\Model;

class Plants extends Model {
    
    public function __construct() {
        $table = 'plants';
        parent::__construct($table);
    }

    public function insert($columns) {
        $this->_database->insert($columns);
    }

}