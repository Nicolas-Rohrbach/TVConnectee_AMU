<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 25/04/2019
 * Time: 11:37
 */

class Secretary
{
    private $view;
    private $model;

    public function __construct(){
        $this->view = new ViewSecretary();
        $this->model = new SecretaryManager();
    }

    public function insertSecretary($action, $login, $pwd, $firstname, $lastname, $email){
        $this->view->displayFormSecretary();
        if(isset($action)) {
            $this->model->insertMySecretary($login, $pwd, $firstname, $lastname, $email);
        }
    }
}