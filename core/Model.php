<?php

class Model {

    protected $_database, $_table, $_modelName, $_softDelete = false, $_columnNames = [];
    public $id;

    public function __construct($table) {
        $this->_database = Database::instance();
        $this->_table = $table;
        /* Run method defined below immediately on instantiation. */
        $this->setColumns();
        /* Populate _modelName property with the $table name, after some cleanup is done to it. The expression can, for
           example, convert table user_sessions to model UserSessions. */
        $this->_modelName = str_replace(' ', '', ucwords(str_replace('_', ' ', $this->_table)));
    }

    /* Fetches the table's column info using MySQL statement, sets property _columns with results. */
    protected function setColumns() {
        $columns = $this->getColumns();
        foreach ($columns as $column) {
            $columnName = $column;
            $this->_columnNames[] = $column;    /* Adding to the _columnNames array w/ each foreach() pass. */
            $this->{$columnName} = null;        /* Set the newly-created $_columnNames array value to null. */
        }
    }

    /* Now to get the columns from the Database class columns() method. This method is used by setColumns() above. 
       Note that unlike working directly with Database, the Database object is now loaded into Model property _database. */
    public function getColumns() {
        return $this->_database->columns($this->_table);   /* Property _table is already populated by __construct. */
    }

    /* This method assumes there is an instantiated object ready to perform save() on. */
    public function save() {
        $fields = [];
        foreach ($this->_columnNames as $column) {
            /* Syntax review: $fields['last_name'] = $this->last_name */
            $fields[$column] = $this->$column;
        }
        /* Determine whether appropriate to call insert() or save(). Note: property_exists() checks if the object or 
           class has a property. Unnlike isset(), property_exists returns true even if the property has value NULL. */
        if ( property_exists($this, 'id') && $this->id != '' ) {
            return $this->update($this->id, $fields);
        } else {
            return $this->insert($fields);
        }
    }

    /* Method below generates a new object from each record in $result. Below is an example of how the objects are populated:
       $object->$key = $value --> $object->first_name = 'John', $object->email = 'jrcowles86@gmail.com' */
    protected function resultObjects($resultArray) {
        foreach ($resultArray as $key => $value) {
            $object->$key = $value;
        }
    }

    /* Note: Possible alternate path to build method below--use for findFirst: fetchObject('<Class_name>') and 
       for find: fetch(PDO::FETCH_CLASS, '<Class_name>') instead of populating objects fopr each result manually, as 
       below. In short, PDO can create instances of the existing classes right from the selected data. */
    public function find($params = []) {
        $results = [];
        /* Call the find() method in Database object, pass in Model _table name and parameters.  */
        $resultArray = $this->_database->find($this->_table, $params);
        /* Loop through results, create a new object from each record, then return an array of objects for display. 
           Each new object in results array will have available to it every method defined in this Model class. 
           Example: $object->first_name = 'John', $object->email = 'jrcowles86@gmail.com' */
        foreach ($resultArray as $result) {
            $object = new $this->_modelName($this->_table);  /* $object originally created here, moved to resultObjects(). */
            $object->resultObjects($result);
            $results[] = $object;    /* Place each new object in the $results[] array */
        }
        return $results;
    }

    /* Find first executes the findFirst() method within object stored in _database, passing in _table name from
       the model, and $params.  */
    public function findFirst($params = []) {
        /* The findFirst() method returns to $queryResult one object with $column => $values for a single record. */
        $queryResult = $this->_database->findFirst($this->_table, $params);
        /* Instantiate a new Model based on the $table name first passed into the Model, and save new object into $result. */
        $result = new $this->_modelName($this->_table);
        /* Use the resultObjects() method in Model to assign result keys and values to the Users object we just 
           instantiated. Will only run if $resultQuery returned a result. */
        if ($queryResult) {
            foreach ($queryResult as $key => $value) {
                $result->$key = $value;  
            }
        }
        return $result;
    }

    /* Takes $id for query and executes Model's findFirst() method. */
    public function findById($id) {
        return $this->findFirst(['conditions' => "user_id = ?", 'bind' => [$id]]);
    }

    /* Wrapper for the insert() method defined in the Database class. insert() requires table and columns, table is 
       defined here in the Model property $this->_table. $columns must be populated for INSERT to work, thus return false
       immediately if that is the case. */
    public function insert($columns) {
        if (empty($columns)) {
            return false;
        }
        return $this->_database->insert($this->_table, $columns);
    }

    /* Takes $id and $columns as arguments. Perform validation on $columns and $id; if invalid, return false. If valid, 
       method executes the Database update() method, $table param not required as this Model already contains that value. */
    public function update() {
        if ( empty($columns || $id == '' )) {
            return $this->_database->update($this->_table, $id, $columns);
        }
    }

    /* Delete function will produce a boolean value, with ability to toggle ture/false for future softdelete functionality.
       First, validate $id, return false if invalid. Initially set $id to blank string ''. Use ternary operator to assign 
       $id to value in Model property $this->id. */
    public function delete($id = '') {
        if ($id == '' && $this->id == '') {
            return false;
        }
        $id = ($id == '') ? $this->id : $id ;
        /* If _softDelete evaluates to true, proceed to update() instead of deleting record outright; execute Model update()
           method, pass-in $id and value of true (1) for the 'deleted' column in whatever database table we're dealing with. */
        if ($this->_softDelete) {
            return $this->update($id, ['deleted' => 1]);
        }
        return $this->_database->delete($this->_table, $id);
    }

    /* Extract the query() method from _database so that query() can be run directly from the Model, thus no need for
       syntax $this->_database->query(). Set $bind to empty array so that query() can be run wide-open. */
    public function query($sql, $bind = []) {
        return $this->_database->query($sql, $bind);
    }

    /* The assign() method helps with preparation of insert or update statements. Loop through $params array, for each $key,
       run the sanitize function in helpers.php on the $value. Function santitize() uses the PHP htmlentities() function. 
       This method, much like save(), can be chained-on along with other methods as part of a call to Model. */
    public function assign($params) {
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                if (in_array($key, $this->_columnNames)) {
                    $this->$key = sanitize($value);
                }
            }
            return true;
        }
        return false;
    }

    /* Returns only the data associated with each object, without additional method logic. Useful for debugging. 
       Instantiates a new PHP standard class and adds a new property on this standard object for each _columnName array. */
    public function data() {
        $data = new stdClass();
        foreach ($this->_columnNames as $column) {
            $data->column = $this->column;
        }
        return $data;
    }

}
