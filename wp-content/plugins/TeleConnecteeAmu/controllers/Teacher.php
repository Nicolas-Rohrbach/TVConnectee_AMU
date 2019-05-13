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
     * Constructeur de Teacher
     */
    public function __construct(){
        $this->view = new ViewTeacher();
        $this->model = new TeacherManager();
    }

    /**
     * Insère tout les professeurs depuis un fichier excel
     * @param $actionTeacher
     */
    public function insertTeacher($actionTeacher){
        excelTeacher($actionTeacher);
        $this->view->displayInsertImportFileTeacher();
    }

    /**
     * Affiche tout les utilisateurs dans un tableau
     */
    public function displayAllTeachers(){
        $results = $this->model->getUsersByRole('enseignant');
        if(isset($results)){
            $this->view->displayTabHeadTeacher();
            $row = 0;
            foreach ($results as $result){
                ++$row;
                $this->view->displayAllTeacher($result, $row);
            }
            $this->view->displayEndTab();
        }
        else{
            $this->view->displayEmpty();
        }
    }

    /**
     * Modifie l'utilisateur
     * @param $result
     */
    public function modifyTeacher($result){
        $action = $_POST['modifValidate'];
        $code = $_POST['modifCode'];
        $this->view->displayModifyTeacher($result);
        if($action === 'Valider'){
            $this->model->modifyTeacher($result, $code);
            $this->view->refreshPage();
        }
    }
}