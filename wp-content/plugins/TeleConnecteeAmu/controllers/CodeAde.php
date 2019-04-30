<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 29/04/2019
 * Time: 09:53
 */

class CodeAde extends ControllerG
{
    private $view;
    private $model;

    /**
     * CodeAde constructor.
     */
    public function __construct(){
        $this->view = new ViewCodeAde();
        $this->model = new CodeAdeManager();
    }

    /**
     * Insert a row into code_ade
     */
    public function insertCode(){
        $this->view->displayFormAddCode();

        $action = $_POST['addCode'];
        $code = filter_input(INPUT_POST, 'codeAde');
        $title = filter_input(INPUT_POST, 'titleAde');
        $type = filter_input(INPUT_POST, 'typeCode');

        if($action == "Valider"){
            if($this->model->addCode($type, $title, $code)){
                $this->view->refreshPage();
                echo "Ajout réalisé";
            }
            else{
                echo "Raté mon gros pépère";
            }
        }
    }

    /**
     * Display all codes from the database
     */
    public function displayAllCodes(){
        $results = $this->model->getAllCode();
        $this->view->displayAllCode($results);
    }

    /**
     * Delete code
     * @param $id
     */
    public function deleteMyCode($id){
        if(isset($id)){
            $this->model->deleteCode($id);
            $this->view->refreshPage();
        }
    }

    /**
     * Modify the code
     */
    public function modifyMyCode(){
        $result = $this->model->getCode($this->getMyIdUrl());
        $this->view->displayModifyCode($result);

        $action = $_POST['modifCodeValid'];
        $title = filter_input(INPUT_POST,'modifTitle');
        $code = filter_input(INPUT_POST,'modifCode');
        $type = filter_input(INPUT_POST,'modifType');

        if($action == "Valider"){
            if($this->model->checkModify($result, $this->getMyIdUrl(), $title, $code, $type)){
                $this->view->refreshPage();
                echo "Oui c'est bon fréro";
            }
            else{
                echo "Titre ou code déjà utilisé man";
            }
        }
    }
}