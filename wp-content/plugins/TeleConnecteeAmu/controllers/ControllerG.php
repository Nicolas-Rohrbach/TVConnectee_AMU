<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 29/04/2019
 * Time: 14:54
 */

abstract class ControllerG
{
    /**
     * Return the id from the url
     * @return mixed
     */
    public function getMyIdUrl(){
        $urlExpl = explode('/', $_SERVER['REQUEST_URI']);
        return $urlExpl[3];
    }

    /**
     * Delete all users who are selected
     * @param $action
     */
    public function deleteUsers($action){
        $model = new StudentManager();
        if(isset($action)){
            if(isset($_REQUEST['checkboxstatus'])) {
                $checked_values = $_REQUEST['checkboxstatus'];
                foreach($checked_values as $val) {
                    $model->deleteUser($val);
                }
            }
        }
    }
}