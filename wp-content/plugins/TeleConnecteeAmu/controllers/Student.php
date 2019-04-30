<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 25/04/2019
 * Time: 10:33
 */

class Student
{
    private $view;
    private $model;

    public function __construct()
    {
        $this->view = new ViewStudent();
        $this->model = new StudentManager();
    }

    public function insertStudent($actionStudent){

        excelStudent($actionStudent);
        $this->view->displayInsertImportFileStudent();

    }

    public function deleteStudent($action){
        if(isset($action)){
            $this->model->deleteUser($action);
            $this->view->refreshPage();
        }
    }

    function displayAllStudents(){
        $result = $this->model->getStudents();
        $this->view->tabHeadStudent();
        $i = 0;
        foreach ($result as $row){
            $year = $this->model->getTitleOfCode($row['annee']);
            echo  $year[0]['title'];
            $this->view->displayAllStudent($row['prenom'], $row['user_nicename'],  $year[0]['title'], $row['groupe'], $row['demiGroupe'], ++$i, $row['ID']);
        }
        $this->view->endTab();
    }

    public function displayModifyMyStudent($result){

        $this->view->displayModifyStudent($result['user_nicename'], $result['prenom'], $result['annee'], $result['groupe'], $result['demiGroupe']);

        $action = $_POST['modifvalider'];
        $firstname = filter_input(INPUT_POST,'modifprenom');
        $lastname = filter_input(INPUT_POST,'modifnom');
        $year = filter_input(INPUT_POST,'modifannee');
        $group = filter_input(INPUT_POST,'modifgroupe');
        $halfgroup = filter_input(INPUT_POST,'modifdemigroupe');

        if($action == 'Valider'){
            if($this->model->modifyStudent($result['ID'], $firstname, $lastname, $year, $group, $halfgroup, $result['user_email'])){
                $this->view->refreshPage();
            }
            else{
                echo "erreur";
            }
        }
    }
}