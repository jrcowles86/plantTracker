<?php

namespace Core\Model;

use Core\Database;
use Core\Validation;
use Core\Model;
use Core\Input;
use Core\Router;

class Plants extends Model {

    private $_errors;
    
    public function __construct() {
        $table = 'plants';
        parent::__construct($table);
    }

    public function validatePlants(array $input) {
        /* Reset _errors property as Validate may have been run before. */
        $this->_errors = [];
        /* Instantiate new Validation object and prepare specs. */
        $validation = new Validation();
        $validation->validate($input, [
            'order_' => [
                'display' => "Order",
                'required' => true,
                'min' => 4,
                'max' => 30
            ],
            'family' => [
                'display' => "Family",
                'required' => true,
                'min' => 4,
                'max' => 30
            ],
            'genus' => [
                'display' => "Genus",
                'required' => true,
                'min' => 4,
                'max' => 30
            ],
            'species' => [
                'display' => "Species",
                'required' => true,
                'min' => 4,
                'max' => 30
            ],
            'subspecies' => [
                'display' => "Subspecies",
                'max' => 30
            ],
            'variety' => [
                'display' => "Variety",
                'max' => 30
            ],
            'cultivar' => [
                'display' => "Cultivar",
                'max' => 60
            ],
            'common_name' => [
                'display' => "Common Name",
                'required' => true,
                'min' => 5,
                'max' => 80
            ],
            'mature_size' => [
                'display' => "Mature Size",
                'max' => 60
            ],
            'requirements' => [
                'display' => "Requirements",
                'max' => 500
            ],
            'range_ecology' => [
                'display' => "Range and Ecology",
                'max' => 500
            ],
            'calflora' => [
                'display' => "Calflora",
                'valid_url' => true,
                'max' => 160
            ],
            'calscape' => [
                'display' => "Calscape",
                'valid_url' => true,
                'max' => 160
            ],
            'jepson_herbarium' => [
                'display' => "Jepson Herbarium",
                'valid_url' => true,
                'max' => 160
            ],
            'las_pilitas' => [
                'display' => "Las Pilitas",
                'valid_url' => true,
                'max' => 160
            ],
            'inland_planner' => [
                'display' => "Inland Valley Garden Planner",
                'valid_url' => true,
                'max' => 160
            ],
            'wiki' => [
                'display' => "Wikipedia",
                'valid_url' => true,
                'max' => 160
            ],
            'theodore_payne' => [
                'display' => "Theodore Payne",
                'valid_url' => true,
                'max' => 160
            ],
            'san_marcos' => [
                'display' => "San Marcos Growers",
                'valid_url' => true,
                'max' => 160
            ],
            'annies_annuals' => [
                'display' => "Annies Annuals",
                'valid_url' => true,
                'max' => 160
            ],
            'california_flora' => [
                'display' => "California Flora Nursery",
                'valid_url' => true,
                'max' => 160
            ],
            'oc_natural_history' => [
                'display' => "Orange County Natural History",
                'valid_url' => true,
                'max' => 160
            ]
        ]);
        if (!$validation->passed()) {
            $this->_errors = $validation->displayErrors();
            return false;
        }
        return true;
    }

    /* Use setErrors() to add a new entry to the _errors array. _errors can be set to empty '[]' 
       directly w/o using this method. */
    public function setErrors($errors) {
        $this->_errors = $errors;
    }

    public function getErrors() {
        if ($this->_errors) {
            return $this->_errors;
        }
    }

    public function index() {
        $sql = "SELECT * FROM plants";
        $params = [];
        if (!$plants = $this->allRecords()) {
            return false;
        }
        return $plants;
    }

    public function recordCheck(array $input) {
        /* Variable $input is $_POST array passed from Plants controller. $_POST array should be sanitized. */
        $this->_errors = [];
        $clean = Input::cleanArray($input);
        /* Run a query to check for existing matches. Note: MYSQL queries are case insensitive by default. */
        $checkParams = [
            $clean['family'],
            $clean['genus'],
            $clean['species'],
            $clean['subspecies'],
            $clean['variety'],
            $clean['cultivar']
        ];
        /* NOTE: need to use the MODEL version of query(), not from Database. It won't work from a child of the Model class. */
        $insertCheck = $this->query("SELECT * FROM plants WHERE family = ? AND genus = ? AND species = ? AND subspecies = ? AND variety = ? AND cultivar = ?", $checkParams);
        if ($insertCheck) {
            /* If match found, render 'insert' page and send along an error. */
            $this->setErrors(["A record exists for {$clean['genus']} {$clean['species']}! Try another variety."]);
            return false;
        }
        return true;
    }

    public function insertPlant(array $input) {
        /* Note that unlike query() above, insert() requires an associative array with column names. Query() requires only 
            an indexed array. */
        $insertParams = [
            'order_' => ucfirst($input['order_']),
            'family' => ucfirst($input['family']),
            'genus' => ucfirst($input['genus']),
            'species' => strtolower($input['species']),
            'subspecies' => strtolower($input['subspecies']),
            'variety' => strtolower($input['variety']),
            'cultivar' => ucwords($input['cultivar']),
            'common_name' => ucwords($input['common_name']),
            'mature_size' => $input['mature_size'],
            'requirements' => $input['requirements'],
            'range_ecology' => $input['range_ecology'],
            'calflora' => filter_var($input['calflora'], FILTER_SANITIZE_URL),
            'calscape' => filter_var($input['calscape'], FILTER_SANITIZE_URL),
            'jepson_herbarium' => filter_var($input['jepson_herbarium'], FILTER_SANITIZE_URL),
            'las_pilitas' => filter_var($input['las_pilitas'], FILTER_SANITIZE_URL),
            'inland_planner' => filter_var($input['inland_planner'], FILTER_SANITIZE_URL),
            'wiki' => filter_var($input['wiki'], FILTER_SANITIZE_URL),
            'theodore_payne' => filter_var($input['theodore_payne'], FILTER_SANITIZE_URL),
            'san_marcos' => filter_var($input['san_marcos'], FILTER_SANITIZE_URL),
            'annies_annuals' => filter_var($input['annies_annuals'], FILTER_SANITIZE_URL),
            'california_flora' => filter_var($input['california_flora'], FILTER_SANITIZE_URL),
            'oc_natural_history' => filter_var($input['oc_natural_history'], FILTER_SANITIZE_URL)
        ];
        /* Note: method insert() grabs $this->_table from the Model, so not required to provide as argument. */
        if (!$this->insert($insertParams)) {
            return false;
        }
        return true;
    }

    /* Method search() returns false if search doesn't work or no results returned. 
       Argument $term will be the $_POST array passed from 'plants/index' */
    public function search($term) {
        /* Sanitize search term (convert from array to single-value string). */
        $cleanTerm = Input::cleanItem('plants-search');
        $params = [];
        for ($param = 0; $param <= 7; $param++) {
            $params[] = '%' . strtolower($cleanTerm) . '%';
        }
        $sql = "SELECT * FROM plants WHERE LOWER(order_) LIKE ? OR LOWER(family) LIKE ? OR LOWER(genus) LIKE ? OR LOWER(species) LIKE ? OR LOWER(subspecies) LIKE ? OR LOWER(variety) LIKE ? OR LOWER(cultivar) LIKE ? OR LOWER(common_name) LIKE ?";
        $results = $this->query($sql, $params);
        /* Multiple results returned as array, single result returns as object per model's query() method. */
        if (!$results) {
            return false;
        } else if (is_array($results)) {
            return $plants = $results;
        } else if (!is_array($results)) {
            return $plants = [
                $results
            ];
        }
    }

    public function detail($id) {
        $sql = "SELECT * FROM plants WHERE plant_id = ?";
        /* Query() returns single object for one result, array for multiple results. */
        if (!$plant = $this->query($sql, Input::sanitize($id))) {
            return false;
        }
        return $plant;
    }

    public function updateForm($id) {
        /* Must initially populate the update view with data for the requested plant record. Will drop data elements into HTML
           input tags. */
        $sql = "SELECT * FROM plants WHERE plant_id = ?";
        if (!$plant = $this->query($sql, $id)) {
            return false;
        }
        return $plant;
    }

    public function updatePlant($id, $columns) {
        $this->_errors = [];
        $clean = Input::cleanArray($columns);
        unset($clean['update-submit']);
        $idArray = [
            'plant_id' => $id
        ];
        if (!$this->update($idArray, $clean)) {
            return false;
        }
        return true;
    }

    /* I really should use the findbyid() method instead... */
    public function deleteForm($id) {
        $sql = "SELECT plant_id, genus, species FROM plants WHERE plant_id = ?";
        //dnd($id);
        if (!$plant = $this->query($sql, $id)) {
            return false;
        }
        return $plant;
    }

    public function deletePlant($id) {
        /* Delete() method only requries $id, tablename is provided by the Model. $id must be array with column name (key). */
        $idArray = [
            'plant_id' => $id
        ];
        if (!$this->delete($idArray)) {
            return false;
        }
        return true;
    }

}