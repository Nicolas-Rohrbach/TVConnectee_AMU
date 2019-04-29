<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 26/04/2019
 * Time: 10:09
 */

class ManagementUsers
{
    private $view;
    //private $model;

    public function __construct()
    {
        $this->view = new ViewManagementUsers();
        //$this->model = new StudentManager();
    }

    public function displayMyUsers($action, $actionTri){
        $this->view->displayButtonChoise();
        if($action == "Students"){
            $controller = new Student();
            $controller->displayAllStudents($action);
        }
        elseif ($action == "Teachers") {
            $controller = new Teacher();
            $controller->displayAllTeachers($actionTri);
        }
    }

    public function modifyMyUser(){
        $newAdress = substr($_SERVER['REQUEST_URI'],51);
        $id = substr($newAdress,0,-1);
        $model = new TeacherManager();
        $result = $model->getById($id);

        if($result['role'] == "etudiant"){
            $controller = new Student();
            $controller->displayModifyMyStudent($result);
        }
        elseif ($result['role'] == "enseignant"){
            $controller = new Teacher();
            $controller->displayModifyTeacher($result);
        }
    }
}