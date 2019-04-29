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
     * @param $action
     */
    public function displayAllTeachers($action){

        $result = $this->model->getTeachers();
        $this->view->tabHeadTeacher();

        $tabTeacher = [];
        $cpt = 0;

        foreach ($result as $row){

            $firstname = $row['prenom'];
            $lastname = $row['user_nicename'];
            $code = $row['annee'];
            $id = $row['ID'];

            $teacher = new DAOTeacher($firstname, $lastname, $code, $id);

            $tabTeacher[$cpt] = $teacher;
            ++$cpt;

        }
        $i = 0;
        if($action[0] === 'prenom'){
            $tabTeacherSort = DAOTeacher::sortByFirstname($tabTeacher);
            foreach ($tabTeacherSort as $teacher){
                $this->view->displayAllTeacher($teacher->getFirstname(), $teacher->getLastname(), $teacher->getCode(), ++$i, $teacher->getId());
            }
        }

        elseif($action[1] === 'nom'){
            $tabTeacherSort = DAOTeacher::sortByLastname($tabTeacher);
            foreach ($tabTeacherSort as $teacher){
                $this->view->displayAllTeacher($teacher->getFirstname(), $teacher->getLastname(), $teacher->getCode(), ++$i, $teacher->getId());
            }
        }
        else{
            foreach ($tabTeacher as $teacher){
                $this->view->displayAllTeacher($teacher->getFirstname(), $teacher->getLastname(), $teacher->getCode(), ++$i, $teacher->getId());
            }
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

        $action = $_POST['modifvalider'];
        $firstname = $_POST['modifprenom'];
        $lastname  = $_POST['modifnom'];

        $this->view->displayModifyTeacher($result['user_nicename'], $result['prenom']);

        if($action === 'Valider'){
            $this->model->insertMyTeacher($result['user_login'], $result['user_pass'], $result['code'], $firstname, $lastname, $result['user_email']);
            $this->view->refreshPage();
        }
    }
}