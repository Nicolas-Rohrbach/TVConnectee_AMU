<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 29/04/2019
 * Time: 14:54
 */

class ControllerG
{
    public function getMyIdUrl($size){
        $newAdress = substr($_SERVER['REQUEST_URI'],$size);
        $id = substr($newAdress,0,-1);
        return $id;
    }
}