<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 25/04/2019
 * Time: 10:33
 */

class Student extends ControllerG
{
    private $view;
    private $model;

    /**
     * Student constructor.
     */
    public function __construct()
    {
        $this->view = new ViewStudent();
        $this->model = new StudentManager();
    }

    public function insertStudent($actionStudent){

        excelStudent($actionStudent);
        $this->view->displayInsertImportFileStudent();

    }

    function displayAllStudents(){
        $results = $this->model->getUsersByRole('etudiant');
        if(isset($results)){
            $this->view->tabHeadStudent();
            $this->displayTabTvStudent($results, $this->model, $this->view);
        }
        else{
            $this->view->displayEmpty();
        }
    }

    public function displayModifyMyStudent($result){
        $years = $this->model->getCodeYear();
        $groups = $this->model->getCodeGroup();
        $halfgroups = $this->model->getCodeHalfgroup();
        $this->view->displayModifyStudent($result, $years, $groups, $halfgroups);

        $action = $_POST['modifvalider'];
        $year = filter_input(INPUT_POST,'modifYear');
        $group = filter_input(INPUT_POST,'modifGroup');
        $halfgroup = filter_input(INPUT_POST,'modifHalfgroup');

        if($action == 'Valider'){
            if($this->model->modifyStudent($result['ID'], $year, $group, $halfgroup)){
                $this->view->refreshPage();
            }
        }
    }
}