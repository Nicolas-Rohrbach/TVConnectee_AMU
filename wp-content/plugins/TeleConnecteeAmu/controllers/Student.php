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
        $result = $this->model->getUsersByRole('etudiant');
        if(isset($result)){
            $this->view->tabHeadStudent();
            $i = 0;
            foreach ($result as $row){
                $year = $this->model->getTitle($row['code1']);
                $group = $this->model->getTitle($row['code2']);
                $halfgroup = $this->model->getTitle($row['code3']);
                $this->view->displayAllStudent($row,  $year, $group, $halfgroup, ++$i);
            }
            $this->view->endTab();
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
            else{
                echo "erreur";
            }
        }
    }
}