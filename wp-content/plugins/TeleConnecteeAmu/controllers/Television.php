<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 25/04/2019
 * Time: 11:41
 */

class Television extends ControllerG{

    /**
     * View de Television
     * @var ViewTelevision
     */
    private $view;

    /**
     * Model de Television
     * @var TelevisionManager
     */
    private $model;

    /**
     * Constructeur de Television
     */
    public function __construct(){
        $this->view = new ViewTelevision();
        $this->model = new TelevisionManager();
    }

    public function insertTelevision(){

        $action = $_POST['createTv'];
        $login = filter_input(INPUT_POST,'loginTv');
        $pwd = md5(filter_input(INPUT_POST,'pwdTv'));
        $codes = $_POST['selectTv'];

        $years = $this->model->getCodeYear();
        $groups = $this->model->getCodeGroup();
        $halfgroups = $this->model->getCodeHalfgroup();
        $this->view->displayFormTelevision($years, $groups, $halfgroups);
        if(isset($action)){
            if($this->model->insertMyTelevision($login, $pwd, $codes)){
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
            $row = 0;
            foreach ($results as $result){
                ++$row;
                $id = $result['ID'];
                $login = $result['user_login'];
                $nbCode = sizeof(unserialize($result['code']));
                $this->view->displayAllTv($id, $login, $nbCode, $row);
            }
            $this->view->displayEndTab();
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

        $code = [$code1, $code2, $code3];
        if(isset($action)){
            if($this->model->modifyTv($result, $code)){
                $this->view->refreshPage();
            }
        }
    }
}