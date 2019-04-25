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

    function displayAllStudents($action){

        $result = $this->model->getStudents();
        $this->view->tabHeadStudent();

        $tabStudent = [];
        $cpt = 0;

        foreach ($result as $row) {

            $firstname = $row['prenom'];
            $lastname = $row['user_nicename'];
            $year = $row['annee'];
            $group = $row['groupe'];
            $halfgroup = $row['demiGroupe'];
            $id = $row['ID'];

            $student = new DAOStudent($firstname, $lastname, $year, $group, $halfgroup, $id);

            $tabStudent[$cpt] = $student;
            ++$cpt;

        }
        $i = 0;
        if($action[0] === 'prenom'){
            $tabStudentSort = DAOStudent::sortByFirstname($tabStudent);
            foreach ($tabStudentSort as $student){
                $this->view->displayAllStudent($student->getFirstname(), $student->getLastname(), $student->getYear(), $student->getGroup(), $student->getHalfgroup(), ++$i, $student->getId());
            }
        }

        elseif($action[1] === 'nom'){
            $tabStudentSort = DAOStudent::sortByLastname($tabStudent);
            foreach ($tabStudentSort as $student){
                $this->view->displayAllStudent($student->getFirstname(), $student->getLastname(), $student->getYear(), $student->getGroup(), $student->getHalfgroup(), ++$i, $student->getId());
            }
        }
        elseif($action[2] === 'annee1'){
            foreach ($tabStudent as $student){
                if($student->getAnnee() === '1'){
                    $this->view->displayAllStudent($student->getFirstname(), $student->getLastname(), $student->getYear(), $student->getGroup(), $student->getHalfgroup(), ++$i, $student->getId());                }
            }
        }
        elseif($action[3] === 'annee2'){
            foreach ($tabStudent as $student){
                if($student->getAnnee() === '2'){
                    $this->view->displayAllStudent($student->getFirstname(), $student->getLastname(), $student->getYear(), $student->getGroup(), $student->getHalfgroup(), ++$i, $student->getId());                }
            }
        }
        elseif($action[3] === 'licence'){
            foreach ($tabStudent as $student){
                if($student->getAnnee() == "Licence ACI"){
                    $this->view->displayAllStudent($student->getFirstname(), $student->getLastname(), $student->getYear(), $student->getGroup(), $student->getHalfgroup(), ++$i, $student->getId());                }
            }
        }
        else{
            foreach ($tabStudent as $student){
                $this->view->displayAllStudent($student->getFirstname(), $student->getLastname(), $student->getYear(), $student->getGroup(), $student->getHalfgroup(), ++$i, $student->getId());            }
        }
        $this->view->endTab();
    }

    public function displayModifyStudent($action, $nom, $prenom, $annee, $groupe){

        $adresse = $_SERVER['REQUEST_URI'];
        $id =  '';

        for($i = 1; $i < strlen($adresse); ++$i){
            if($adresse[$i] === '/'){
                for($j = $i + 1; $j < strlen($adresse) - 1; ++$j){
                    $id .= $adresse[$j];
                }
            }
        }
        $result = $this->model->getById($id);
        $this->view->displayModifyStudent($result['user_nicename'], $result['prenom'], $result['annee'], $result['groupe']);

        if($action === 'Valider'){
            $this->model->deleteUser($id);
            $this->model->insertStudent($nom, $result['user_pass'], $result['user_login'], $result['user_email'], $result['display_name'], $annee, $groupe, $result['demiGroupe'], $prenom);
            $this->view->refreshPage();

        }

    }
}