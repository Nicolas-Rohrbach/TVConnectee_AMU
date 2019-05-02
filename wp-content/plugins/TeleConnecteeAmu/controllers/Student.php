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
            $year = $this->model->codeReturn($row['annee']);
            $group = $this->model->codeReturn($row['groupe']);
            $halfgroup = $this->model->codeReturn($row['demiGroupe']);
            $this->view->displayAllStudent($row,  $year, $group, $halfgroup, ++$i);
        }
        $this->view->endTab();
    }

    public function displayModifyMyStudent($result){

        $years = $this->model->getCodeYear();
        $groups = $this->model->getCodeGroup();
        $halfgroups = $this->model->getCodeHafgroup();
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