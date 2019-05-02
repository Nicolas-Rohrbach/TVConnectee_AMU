<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 26/04/2019
 * Time: 10:09
 */

class ManagementUsers extends ControllerG
{
    private $view;

    public function __construct(){
        $this->view = new ViewManagementUsers();
    }

    public function displayMyUsers($action){
        $this->view->displayButtonChoise();
        $this->view->displayError();
        if($action == "Students"){
            $controller = new Student();
            $controller->displayAllStudents();
        }
        elseif ($action == "Teachers") {
            $controller = new Teacher();
            $controller->displayAllTeachers();
        }
    }

    public function modifyMyUser(){
        $model = new TeacherManager();
        $result = $model->getById($this->getMyIdUrl());

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