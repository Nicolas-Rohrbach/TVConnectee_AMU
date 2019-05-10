<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 25/04/2019
 * Time: 11:41
 */

class Television extends ControllerG
{
    private $view;
    private $model;

    public function __construct()
    {
        $this->view = new ViewTelevision();
        $this->model = new TelevisionManager();
    }

    public function insertTelevision(){

        $action = $_POST['createTv'];
        $login = filter_input(INPUT_POST,'loginTv');
        $pwd = md5(filter_input(INPUT_POST,'pwdTv'));
        $code1 = $_POST['firstCode'];
        $code2 = 0;
        $code3 = 0;

        if(isset($_POST['secondCode'])) $code2 = $_POST['secondCode'];
        if(isset($_POST['thirdCode'])) $code3 = $_POST['thirdCode'];

        $years = $this->model->getCodeYear();
        $groups = $this->model->getCodeGroup();
        $halfgroups = $this->model->getCodeHalfgroup();
        $this->view->displayFormTelevision($years, $groups, $halfgroups);
        if(isset($action)) {
            if($this->model->insertMyTelevision($login, $pwd, $code1, $code2, $code3)){
                $this->view->refreshPage();
            }
            else{
                $this->view->displayErrorLogin();
            }
        }
    }

    public function displayAllTv(){
        $results = $this->model->getUsersByRole('television');
        if(isset($results)){
            $this->view->displayHeaderTabTv();
            $this->TabTvStudent($results, $this->model, $this->view);
        }
        else{
            $this->view->displayEmpty();
        }
    }

    public function modifyTv($result){
        $years = $this->model->getCodeYear();
        $groups = $this->model->getCodeGroup();
        $halfgroups = $this->model->getCodeHalfgroup();
        $this->view->displayModifyTv($result, $years, $groups, $halfgroups);

        $action = $_POST['modifValidate'];
        $code1 = $_POST['firstCode'];
        $code2 = $_POST['secondCode'];
        $code3 = $_POST['thirdCode'];
        if(isset($action)){
            if($this->model->modifyTv($result, $code1, $code2, $code3)){
                $this->view->refreshPage();
            }
        }
    }
}