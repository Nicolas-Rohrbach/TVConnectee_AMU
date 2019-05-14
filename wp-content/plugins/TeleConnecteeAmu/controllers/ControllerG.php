<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 29/04/2019
 * Time: 14:54
 */

abstract class ControllerG {

    /**
     * Renvoie l'ID
     * @return mixed
     */
    protected function getMyIdUrl(){
        $urlExpl = explode('/', $_SERVER['REQUEST_URI']);
        $size = sizeof($urlExpl);
        return $urlExpl[$size-2];
    }

    /**
     * Supprime tout les utilisateurs sélectionnés
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

    /**
     *
     * @param $results
     * @param $model
     * @param $view
     *
     */
    protected function tabTvStudent($results, $model, $view){
        $row = 0;
        foreach ($results as $result){
            ++$row;
            $id = $result['ID'];
            $login = $result['user_login'];
            $year = $model->getTitle($result['code1']);
            $group = $model->getTitle($result['code2']);
            $halfgroup = $model->getTitle($result['code3']);
            $view->displayAllTvStudent($id, $login, $year, $group, $halfgroup, $row);
        }
        $view->displayEndTab();
    }

    public function addLogEvent($event){
        $time = date("D, d M Y H:i:s");
        $time = "[".$time."] ";
        $event = $time.$event."\n";
        file_put_contents(ABSPATH."/wp-content/plugins/TeleConnecteeAmu/fichier.log", $event, FILE_APPEND);
    }
}