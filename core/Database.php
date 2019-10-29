<?php

namespace Core;

use \PDO;

class Database {

    private static $_instance = null;
    private $_pdo, $_stmt, $_error = false, $_result, $_count = 0, $_lastInsertId = null;

    /* Constructor method instantiates a PDO object and logs the application in to the MySQL database. */
    public function __construct() {
        try {
            $this->_pdo = new PDO(DSN, USERNAME, PASSWORD, 
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ]);
        } catch (PDOException $exception) {
            die('Error: ' . $exception->getMessage());
        }
    }

    public static function instance() {
        if (!isset(self::$_instance)) {     /* Note the special self::$_ syntax for calling static properties. */
            self::$_instance = new Database();
        }
        return self::$_instance;  /* If Database object already exists, return the object to the code that called for it. */
    }

    public function result() {
        return $this->_result;
    }

    public function count() {
        return $this->_count;
    }

    /* Fetch column metadata from MySQL database. Returns an object. Extracts the Field property out of each object in 
       array. $columnArray is an array of objects, hence $column->Field in the foreach() loop. Use this to fetch column 
       names for table headers. Appears to work properly as of Thurs, 17 Oct. */
    public function columns($table) {
        $columnArray = $this->query("SHOW COLUMNS FROM {$table}")->result();
        foreach ($columnArray as $column) {
            $columns[] = $column->Field;
        }
        return $columns;
    }

    /* The query() method stores the foundational logic that most methods in class Database use to execute SQL statements.
       Resolved issues with query() on Thurs, 17 Oct. */
    public function query($sql, $params = []) {
        $this->_stmt = $this->_pdo->prepare($sql);
        $counter = 1;
        if (count($params)) {
            foreach ($params as $param) {
                $this->_stmt->bindValue($counter, $param);
                $counter++;
            }
        }
        $this->_stmt->execute();
        /* PDO method fetchAll(PDO::FETCH_OBJ) returns an array of objects. Access object elements: $columns[0]->Field.
           Below, only allow Database properties $_result and $_count to be populated if SQL command is SELECT or SHOW.
           Commands UPDATE, INSERT and DELETE do not provide results from PDO, thus the query() method would fail here. */
        $sqlTerm = ( stristr($sql, 'SELECT') || stristr($sql, 'SHOW') );
        if ($sqlTerm) {
            $this->_result = $this->_stmt->fetchAll();
            $this->_count = $this->_stmt->rowCount();
        }
        /* Use this return expression to test whether query() works from a controller. */
        return $this;   /* Required to pass along results of query() to other methods in this class. */    
    }

    /* Example of $sql string dynamically created (below). Takes $columns array which is pair column name => column value.
       "INSERT INTO Customers (user_name, city, country) VALUES (?, ?, ?)" */
    public function insert($table, $columns = []) {
        $columnString = '';
        $valueString = '';
        $fields = array_keys($columns);
        $values = array_values($columns);     /* $values will hold the 'value' elements from the $columns assoc. array passed into insert(). */
        foreach ($fields as $field) {
            $columnString .= '`' . $field . '`,'; /* Backticks needed if table & field names collide w/ SQL reserved words. */
            $valueString .= '?,';   /* For each column, pair a '?, ' then (below) trim off the extra right ',' */
        }
        $columnString = rtrim($columnString, ',');
        $valueString = rtrim($valueString, ',');
        $sql = "INSERT INTO {$table} ({$columnString}) VALUES ({$valueString})";
        if ($this->query($sql, $values)) {   /* The execute() method is already invoked within query(); no need to repeat. */
            return true;
        }
        return false;    /* No error will be returned. If method doesn't work, method returns value of 'false' */
    }

    public function update($table, $id, $columns = []) {    /* $table and $id allow method to find the appropriate record. */
        $columnString = '';
        $values = '';
        foreach ($columns as $column => $value) {
            $columnString .= ' ' . ' = ?,';
            $values[] = $value;
        }
        $columnString = trim($columnString);
        $columnString = rtrim($columnString);
        $sql = "UPDATE {$table} SET {$columnString} WHERE user_id = {$id}";
        if ($this->query($sql, $values)) {
            return true;
        }
        return false;
    }

    public function delete($table, $id) {
        $sql = "DELETE FROM {$table} WHERE user_id = {$id}";
        if ($this->query($sql)) {
            return true;
        }
        return false;
    }

    /* Logic for method _read() is shared by find() and findFirst(). Breaking-out repeated logic into separate method.
       Method can be 'protected' as it will not be called directly from outside the class (only by find() and findFirst()).
       The end goal of _read(), find() and findFirst() is to have the application dynamically create ALL SQL instead of 
       requiring us to type out every SQL string and pass that into query(). Below is an example of the kind of SQL 
       statment this method builds: "SELECT * FROM users WHERE last_name = ? AND first_name = ? ORDER BY last_name LIMIT 3" */
    protected function _read($table, $params = []) {
        /* Initiate variables. These will become the components of a dynamically-created SQL statement. */
        $conditionString = '';
        $bind = [];
        $order = '';
        $limit = '';
        /* Set conditions. Foreach() handles $params['conditions'] provided as an array within an array. Else() handles 
           single conditions. */
        if (isset($params['conditions'])) {
            if (is_array($params['conditions'])) {
                foreach ($params['conditions'] as $condition) {
                    $conditionString .= ' ' . $condition . ' AND';   /* Example: 'WHERE last_name = ? AND first_name = ? */
                }
                $conditionString = trim($conditionString);       /* Remove excess space from beginning of string. */
                $conditionString = rtrim($conditionString, ' AND');   /* Remove excess ' AND' applied to string by foreach() */
            } else {
                /* If $params['conditions'] is not array, simply set $conditionString to value assoc with $params['conditions'] */
                $conditionString = $params['conditions'];
            }
        }
        /* Append string 'WHERE ' to the $conditionString defined above. This step completes the query conditions. 
           IF requires the condition is not an empty string. */
        if ($conditionString != '') {
            $conditionString = ' WHERE ' . $conditionString;
        }
        /* Bind values. First, check if 'bind' key is populated in $params[] array. If so, move 'bind' contents into variable.*/
        if (array_key_exists('bind', $params)) {
            $bind = $params['bind'];
        }
        /* Order results. As above, check that 'order' key is populated, then concatenate value with 'ORDER BY ' */
        if (array_key_exists('order', $params)) {
            $order = ' ORDER BY ' . $params['order'];
        } 
        /* Limit results. Likewise, if populated in $params array, construct LIMIT statement using the provided value.  */
        if (array_key_exists('limit', $params)) {
            $limit = ' LIMIT ' . $params['limit'];
        }
        /* Define the remainder of the SQL statement and add placeholders for interpolating prepared variables. 
           Note: no spaces required between placeholders as spaces are already factored in to our variables. The query ()
           method automatically posts results to the _result property, so check for _result values, if exist, return true. */
        $sql = "SELECT * FROM {$table}{$conditionString}{$order}{$limit}";
        //dnd($sql);
        if ($this->query($sql, $bind)) {
            if (!count($this->_result)) {
                return false;
            }
            return true;
        }
        return false;
    }

    /* Methods find() and findFirst() are the primary means of returning records for display. Both use the protected _read()
       method defined above. Create empty array, else if we didnt pass params, function could break. The _read() method already 
       posted results to _result property, hence return statement can use result() method to fetch data. */
    public function find($table, $params = []) {
        if ($this->_read($table, $params)) {
            return $this->result();
        }
        return false;
    }

    /* Return the first result simply by invoking the first() method, which picks [0] index from the _result array of objects. */
    public function findFirst($table, $params = []) {
        if ($this->_read($table, $params)) {
            return $this->first();
        }
        return false;
    }

    /* Method first() returns the initial result. Use when only one result is anticipated. Avoids placing single result
       object in an array, which adds complication and is unnecessary if only a single result object is needed. This 
       method can be chained-on to others in the controller to extract only first result. Example is demonstrated below: 
       $users = $database->query("SELECT * FROM users")->first(); */
    public function first() {
        /* Extract the first object from the results array. Note: The PDO fetchAll() method returns an array of objects. 
           Add ternary operator to check  */
        return (!empty($this->_result)) ? $this->_result[0] : [] ;
    }

    public function lastInsert() {
        return $this->_lastInsertId;
    }

    public function error() {
        return $this->_error;
    }

}
