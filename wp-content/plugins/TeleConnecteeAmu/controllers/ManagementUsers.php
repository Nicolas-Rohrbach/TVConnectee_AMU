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

    public function displayUsers($action){
        $this->view->displayButtonChoise();
        if($action == "students"){
            $controller = new Student();
            $controller->displayAllStudents();
        }
        elseif ($action == "teachers") {
            $controller = new Teacher();
            $controller->displayAllTeachers();
        }
        elseif ($action == "televisions"){
            $controller = new Television();
            $controller->displayAllTv();
        }
        elseif ($action == "secretarys"){
            $controller = new Secretary();
            $controller->displayAllSecretary();
        }
    }

    public function modifyUser(){
        $model = new TeacherManager();
        $result = $model->getById($this->getMyIdUrl());

        if($result['role'] == "etudiant"){
            $controller = new Student();
            $controller->modifyMyStudent($result);
        }
        elseif ($result['role'] == "enseignant"){
            $controller = new Teacher();
            $controller->modifyTeacher($result);
        }
        elseif ($result['role'] == "television"){
            $controller = new Television();
            $controller->modifyTv($result);
        }
    }
}