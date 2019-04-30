<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 25/04/2019
 * Time: 11:25
 */

class Teacher
{
    private $view;
    private $model;

    /**
     * Teacher constructor
     */
    public function __construct(){
        $this->view = new ViewTeacher();
        $this->model = new TeacherManager();
    }

    /**
     * Insert all teacher from an Excel file
     * @param $actionTeacher
     */
    public function insertTeacher($actionTeacher){
        excelTeacher($actionTeacher);
        $this->view->displayInsertImportFileTeacher();
    }

    /**
     * Display all teachers in a tab
     */
    public function displayAllTeachers(){
        $results = $this->model->getTeachers();
        $this->view->tabHeadTeacher();
        $row = 0;
        foreach ($results as $result){
            ++$row;
            $this->view->displayAllTeacher($result, ++$row);
        }
        $this->view->endTab();
    }

    /**
     * Delete a teacher
     * @param $action
     */
    public function deleteTeacher($action){
        if(isset($action)){
            $this->model->deleteUser($action);
            $this->view->refreshPage();
        }

    }

    public function displayModifyTeacher($result){

        $action = $_POST['modifValidate'];
        $code = $_POST['modifCode'];

        $this->view->displayModifyTeacher($result);

        if($action === 'Valider'){
            $this->model->modifyTeacher($result, $code);
            $this->view->refreshPage();
        }
    }
}