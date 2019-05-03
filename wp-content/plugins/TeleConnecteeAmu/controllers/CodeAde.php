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
            }
            else{
                $this->view->errorDouble();
            }
        }
    }

    /**
     * Display all codes from the database
     */
    public function displayAllCodes(){
        $results = $this->model->getAllCode();
        if(isset($results)){
            $this->view->displayAllCode($results);
        }
        else{
            $this->view->displayEmpty();
        }
    }

    /**
     * Delete all code who are selected
     * @param $action
     */
    public function deleteCodes($action){
        $model = new CodeAdeManager();
        if(isset($action)){
            if(isset($_REQUEST['checkboxstatus'])) {
                $checked_values = $_REQUEST['checkboxstatus'];
                foreach($checked_values as $val) {
                    $model->deleteCode($val);
                }
            }
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
            }
            else{
                $this->view->errorDouble();
            }
        }
    }
}