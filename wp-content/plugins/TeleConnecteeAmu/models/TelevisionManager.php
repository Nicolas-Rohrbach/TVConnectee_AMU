<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 25/04/2019
 * Time: 10:29
 */

class TelevisionManager extends Model
{
    public function insertMyTelevision($login, $pwd, $code, $code2, $code3, $name){
        $role = "television";
        return $this->insertUser($login, $pwd, $role, $code, $code2, $code3, $name);

    }
}