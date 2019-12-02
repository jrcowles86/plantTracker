<?php

namespace Core\Controller;

use Core\Controller;
use Core\Database;
use Core\Model\Users;
use Core\Router;
use \PDO;

class Plants extends Controller {

    public function __construct($controller, $method) {
        parent::__construct($controller, $method);
        $this->loadModel('Plants');
        $this->view->setLayout('default');
    }

    public function index() {
        if (!$plants = $this->Plants->index()) {
            Router::redirect('/home/index');
            exit();
        } else {
            $this->view->setData($plants);
            $this->view->render('show');
            exit();
        }
    }

    public function insert() {
        if (strstr($_SERVER['HTTP_REFERER'], 'index')) {
            $this->view->render('insert');
            exit();
        } else if (strstr($_SERVER['HTTP_REFERER'], 'insert')) {
            if (!isset($_POST['insert-submit'])) {
                $this->view->render('insert');
                exit();
            } else {
                if (!$this->Plants->validatePlants($_POST)) {
                    $this->view->setErrors($this->Plants->getErrors());
                    $this->view->setPost($_POST);
                    $this->view->render('insert');
                    exit();
                } else {
                    if (!$this->Plants->recordCheck($_POST)) {
                        $this->view->setErrors($this->Plants->getErrors());
                        $this->view->setPost($_POST);
                        $this->view->render('insert');
                        exit();
                    } else {
                        if (!$this->Plants->insertPlant($_POST)) {
                            Router::redirect('/plants/index?error=insertfailed');
                            exit();
                        } else {
                            Router::redirect('/plants/index?error=insertsuccess');
                            exit();
                        }
                    }
                }
            }
        }
        Router::redirect('/plants/index?error=insertfailed');
        exit();
    }

    public function search() {
        if (!isset($_POST['plants-search']) || empty($_POST['plants-search'])) {
            Router::redirect('/plants/index?error=noterms');
            exit();
        } else {
            if (!$plants = $this->Plants->search($_POST)) {
                Router::redirect('/plants/index?error=noresults');
                exit();
            } else {
                $this->view->setData($plants);
                $this->view->render('show');
                exit();
            }
        }
    }

    public function detail($id) {
        if (empty($id)) {
            Router::redirect('/plants/index?error=detailfailed');
            exit();
        } else {
            if (!$plant = $this->Plants->detail($id)) {
                Router::redirect('/plants/index?error=detailfailed');
                exit();
            } else {
                $this->view->setData($plant);
                $this->view->render('detail');
                exit();
            }
        }
    }

    public function update($id) {
        if (empty($_POST) || !isset($_POST['update-submit'])) {
            if (empty($id)) {
                Router::redirect('/plants/index?error=updatefailed');
                exit();
            } else {
                if (!$plant = $this->Plants->updateForm($id)) {
                    Router::redirect('/plants/index?error=updatefailed');
                    exit();
                } else {
                    $this->view->setData($plant);
                    $this->view->render('update');
                    exit();
                }
            }
        } else {
            if (!$this->Plants->validatePlants($_POST)) {
                $plant = $this->Plants->updateForm($id);
                $this->view->setData($plant);
                $this->view->setErrors($this->Plants->getErrors());
                $this->view->render('update');
                exit();
            } else {
                if (!$this->Plants->updatePlant($id, $_POST)) {
                    $plant = $this->Plants->updateForm($id);
                    $this->view->setData($plant);
                    $this->view->setErrors($this->Plants->getErrors());
                    $this->view->render('update');
                    exit();
                } else {
                    header('Location: ../detail/' . $id . '?error=updatesuccess');
                    exit();
                }
            }
        }
    }

    public function delete($id) {
        /* Determine where the user is accessing the delete() method from. If index, send user to the 'delete' view. */
        if (strstr($_SERVER['HTTP_REFERER'], 'index')) {
            $this->view->setData($this->Plants->deleteForm($id));
            $this->view->render('delete');
            exit();
        /* If user accessed delete() from the 'delete' 'detail' or 'update' views, proceed with delete logic. */
        } else if (strstr($_SERVER['HTTP_REFERER'], 'delete') || strstr($_SERVER['HTTP_REFERER'], 'detail') || strstr($_SERVER['HTTP_REFERER'], 'update')) {
            if (!isset($_POST['delete-submit']) && !empty($id)) {
                Router::redirect('/plants/index?error=deletefailed');
                exit();
            } else {
                if (!$this->Plants->deletePlant($id)) {
                    Router::redirect('/plants/index?error=deletefailed');
                    exit();
                }
                Router::redirect('/plants/index?error=deletesuccess');
                exit();
            }
        }
    }

}