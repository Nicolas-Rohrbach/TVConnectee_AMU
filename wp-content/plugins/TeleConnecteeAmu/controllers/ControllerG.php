<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 29/04/2019
 * Time: 14:54
 */

class ControllerG
{
    public function getMyIdUrl(){
        $urlExpl = explode('/', $_SERVER['REQUEST_URI']);
        return $urlExpl[3];
    }
}