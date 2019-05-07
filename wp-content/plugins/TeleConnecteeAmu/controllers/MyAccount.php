<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 06/05/2019
 * Time: 08:58
 */

class MyAccount extends ControllerG {
    private $view;
    private $model;

    /**
     * MyAccount constructor.
     */
    public function __construct(){
        $this->view = new ViewMyAccount();
        $this->model = new MyAccountManager();
    }

    /**
     *
     */
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
                $this->view->wrongPassword();
            }
        }
    }

    /**
     * Delete the account of the user if the password is good
     */
    public function deleteMyAccount(){
        $this->view->verifyPassword();
        $this->view->deleteAccount();
        $action = $_POST['deleteMyAccount'];
        $current_user = wp_get_current_user();
        if(isset($action)){
            $pwd = filter_input(INPUT_POST, 'verifPwd');
            if(wp_check_password($pwd, $current_user->user_pass)){
                require_once( ABSPATH.'wp-admin/includes/user.php' );
                wp_delete_user( $current_user->ID );
                $this->addLogEvent("Le compte ".$current_user->user_login." a été supprimé !");
                $this->view->modificationValidate();
            }
            else{
                $this->view->wrongPassword();
            }
        }
    }
}