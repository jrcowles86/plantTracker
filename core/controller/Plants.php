<?php

namespace Core\Controller;

use Core\Controller;
use Core\Database;
use Core\Router;
use \PDO;

class Plants extends Controller {

    public function __construct($controller, $method) {
        parent::__construct($controller, $method);
        $this->loadModel('Plants');
        $this->view->setLayout('default');
    }

    public function index() {
        $database = Database::instance();
        $plants = $database->query("SELECT * FROM plants ORDER BY genus ASC, species ASC")->result();
        $this->view->setData($plants);
        $this->view->render('show');
    }

    public function insert() {
        if (isset($_POST['insert-submit'])) {
            unset($_POST['insert-submit']);
            //dnd($_POST);
            $database = Database::instance();
            $cleanedInsert = postedValues($_POST);
            //dnd($cleanedInsert);
            $family = $cleanedInsert['family'];
            $genus = $cleanedInsert['genus'];
            $species = $cleanedInsert['species'];
            $subspecies = $cleanedInsert['subspecies'];
            $cultivar = $cleanedInsert['cultivar'];
            $commonName = $cleanedInsert['common_name'];
            if (empty($family) || empty($genus) || empty($species) || empty($commonName)) {
                header('Location: ../plants/index?error=requiredfields');
                exit();
            } else {
                $params = [
                    'family' => $family,
                    'genus' => $genus,
                    'species' => $species
                ];
                $insertCheck = $database->query("SELECT * FROM plants WHERE family = ? AND genus = ? AND species = ?", $params)->result();
                //dnd($insertCheck);   
                if ($insertCheck) {
                    header('Location: ../plants/index?error=recordexists&family='.$family.'&genus='.$genus.'&species='.$species.'&common_name='.$commonName);
                    exit();
                } else if (!$insertCheck) {
                    $database->insert('plants', $cleanedInsert);
                    Router::redirect('/plants/index?error=insertsuccess');
                }
            }
        }
    }

    public function search() {
        $database = Database::instance();
        /* Apparently must use empty() to check if search is submitted w/o parameter. Function isset() will not reset to /plants/index.
           Looks like merely clicking the 'submit' button sets isset() to true. If search bar is empty, reload plants/index. */
        if (empty($_POST['plants-search'])) {
            Router::redirect('/plants/index');
            exit();
        } else {
            $cleanTerm = (isset($_POST['plants-search'])) ? strtolower(sanitize($_POST['plants-search'])) : [] ;
            /* LIKE Statements: Best practice to dynamically apply wildcards (%) when preparing the array of parameters. Below, use 
               for loop to take search term string and create array of parameters to match number of columns to query. */
            $params = [];
            for ($i = 0; $i <= 5; $i++ ) {
                $params[] = '%' . $cleanTerm . '%';
            }
            $sql = "SELECT * FROM plants WHERE LOWER(family) LIKE ? OR LOWER(genus) LIKE ? OR LOWER(species) LIKE ? OR LOWER(subspecies) LIKE ? OR LOWER(cultivar) LIKE ? OR LOWER(common_name) LIKE ?";
            $plants = $database->query($sql, $params)->result();
            //dnd($plants);
            if (!$plants) {
                header('Location: ../plants/index?error=noresults');
                exit();
            } else {
                /* Allows $cleanTerm to be called from within the view markup. Check search 'value' attr on show.php for an example.
                   View method setPost allows for an array of posted values to be passed along to inputs in  */
                $this->view->setPost($cleanTerm);
                $this->view->setData($plants);
                $this->view->render('show');
            }
        }
    }

    public function detail($id) {
        if (empty($id)) {
            Router::redirect('/plants/index');
            exit();
        } else {
            $database = Database::instance();
            
            /* Database query() method requires search data to be passed as an array in $params. Below is a simple indexed array. 
            IDEA: Could change query() to check if $params is an array. If not, then convert from single value to an array. */
            $plant_id = [
                $id
            ];
            $sql = "SELECT * FROM plants WHERE plant_id = ?";
            $plant = $database->query($sql, $plant_id)->result();
            $this->view->setData($plant);
            $this->view->render('detail');
        }
    }

    public function update($id) {
        /* Must initially populate the update view with data for the requested plant record. Will drop data elements into HTML
           input tags. */
        if (empty($id)) {
            Router::redirect('/plants/index');
            exit();
        } else {
            $database = Database::instance();
            /* Place the $id value into an indexed array for use by the Database query() method. */
            $plant_id = [
                'plant_id' => $id
            ];
            if (!isset($_POST['update-submit'])) {
                $displaySql = "SELECT * FROM plants WHERE plant_id = ?";
                $plant = $database->query($displaySql, $plant_id)->result();
                $this->view->setData($plant);
                $this->view->render('update');
            } else {
                /* Replace empty strings with NUL values. */
                $cleanPost = postedValues($_POST);
                /* Remove or 'unset' the $key => $value pair with key 'submit' - not needed for the update statement. */
                unset($cleanPost['update-submit']);
                $updateArray = [];
                foreach ($cleanPost as $key => $value) {
                    $value = ($value == "") ? ($value = null) : $value ;
                    $updateArray[$key] = $value;
                }
                /* Prepare SQL statement for the update. The update() method generates the SQL automatically, then passes SQL and 
                   $params to Database query() method. */
                if ($database->update('plants', $plant_id, $updateArray)) {
                    header('Location: ../detail/' . $id . '?error=updatesuccess');
                    exit();
                } else {
                    header('Location: ../detail/' . $id . '?error=updatefailed');
                    exit();
                }
            }
        }
    }

    public function indexDelete($id) {
        $database = Database::instance();
        $plant_id = [
            'plant_id' => $id
        ];
        $sql = "SELECT plant_id, genus, species FROM plants WHERE plant_id = ?";
        $plant = $database->query($sql, $plant_id)->result();
        $this->view->setData($plant);
        $this->view->render('delete');
    }

    public function delete($id) {
        $database = Database::instance();
        $plant_id = [
            'plant_id' => $id
        ];
        if (isset($_POST['delete-submit']) && !empty($id)) {
            if ($database->delete('plants', $plant_id)) {
                Router::redirect('/plants/index?error=deletesuccess');
                exit();
            } else {
                header('Location: /plants/index?error=deletefailed');
                exit();
            }
        } else {
            header('Location: /plants/index?error=deletefailed');
            exit();
        }
    }

}