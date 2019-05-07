<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 06/05/2019
 * Time: 08:58
 */

class MyAccount{
    private $view;
    private $model;

    public function __construct(){
        $this->view = new ViewMyAccount();
        $this->model = new MyAccountManager();
    }

    public function displayModifyPwd(){
        $this->view->verifyPassword();
        $this->view->modifyPassword();
        $action = $_POST['modifyMyPwd'];
        $current_user = wp_get_current_user();
        if(isset($action)){
            $pwd = filter_input(INPUT_POST, 'verifPwd');
            if(wp_check_password($pwd, $current_user->user_pass)){
                $newPwd = filter_input(INPUT_POST, 'newPwd');
                wp_set_password( $newPwd, $current_user->ID);
                $this->view->modificationValidate();
            }
            else{
                echo "No, Wrong Password";
            }
        }
    }

    public function deleteMyAccount(){
        $action = $_POST['deletePwd'];
        if(isset($action)){
        }
        $action = $_POST['deletePwdSubmit'];
        if(isset($action)){
            $pwd = md5(filter_input(INPUT_POST, 'deletePwd'));
            if($this->model->verifyMyPassword($pwd)){
                echo "oui";
            }
            else{
                echo 'non';
            }
        }
    }
}