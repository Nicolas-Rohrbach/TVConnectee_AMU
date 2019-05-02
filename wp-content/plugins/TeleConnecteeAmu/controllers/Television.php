<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 25/04/2019
 * Time: 11:41
 */

class Television
{
    private $view;
    private $model;

    public function __construct()
    {
        $this->view = new ViewTelevision();
        $this->model = new TelevisionManager();
    }

    public function insertTelevision($action, $login, $pwd, $code, $code2, $code3, $name) {
        $years = $this->model->getCodeYear();
        $groups = $this->model->getCodeGroup();
        $halfgroups = $this->model->getCodeHalfgroup();
        $this->view->displayFormTelevision($years, $groups, $halfgroups);
        if(isset($action)) {
            $this->model->insertMyTelevision($login, $pwd, $code, $code2, $code3, $name);
        }
    }
}