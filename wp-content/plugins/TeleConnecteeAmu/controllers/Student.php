<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 25/04/2019
 * Time: 10:33
 */

class Student extends ControllerG
{
    /**
     * View de Student
     * @var ViewStudent
     */
    private $view;

    /**
     * Model de Student
     * @var StudentManager
     */
    private $model;

    /**
     * Constructeur de Student.
     */
    public function __construct()
    {
        $this->view = new ViewStudent();
        $this->model = new StudentManager();
    }

    /**
     * Ajoute tout les étudiants présent dans un fichier excel
     * @param $actionStudent    Est à true si le bouton est préssé
     */
    public function insertStudent($actionStudent){
        excelStudent($actionStudent);
        $this->view->displayInsertImportFileStudent();

    }

    /**
     * Affiche tout les étudiants dans un tableau
     */
    function displayAllStudents(){
        $results = $this->model->getUsersByRole('etudiant');
        if(isset($results)){
            $this->view->displayTabHeadStudent();
            $row = 0;
            foreach ($results as $result){
                ++$row;
                $id = $result['ID'];
                $login = $result['user_login'];
                $code = unserialize($result['code']);
                $year = $this->model->getTitle($code[0]);
                $group = $this->model->getTitle($code[1]);
                $halfgroup = $this->model->getTitle($code[2]);
                $this->view->displayAllStudent($id, $login, $year, $group, $halfgroup, $row);
            }
            $this->view->displayRedSignification();
            $this->view->displayEndTab();
        }
        else{
            $this->view->displayEmpty();
        }
    }

    /**
     * Modifie l'étudiant sélectionné
     * @param $result   Données de l'étudiant avant modification
     */
    public function modifyMyStudent($result){
        $years = $this->model->getCodeYear();
        $groups = $this->model->getCodeGroup();
        $halfgroups = $this->model->getCodeHalfgroup();
        $this->view->displayModifyStudent($result, $years, $groups, $halfgroups);

        $action = $_POST['modifvalider'];
        $year = filter_input(INPUT_POST,'modifYear');
        $group = filter_input(INPUT_POST,'modifGroup');
        $halfgroup = filter_input(INPUT_POST,'modifHalfgroup');

        $code = [$year, $group, $halfgroup];
        if($action == 'Valider'){
            if($this->model->modifyStudent($result['ID'], $code)){
                $this->view->refreshPage();
            }
        }
    }
}