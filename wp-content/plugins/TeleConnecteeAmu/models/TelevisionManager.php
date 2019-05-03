<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 25/04/2019
 * Time: 10:29
 */

class TelevisionManager extends Model
{
    public function insertMyTelevision($login, $pwd, $code, $code2, $code3){
        $role = "television";
        return $this->insertUser($login, $pwd, $role, $code, $code2, $code3, $login);

    }

    public function modifyTv($result, $code1, $code2, $code3){
        return $this->modifyUser($result['ID'], $result['user_login'], $result['user_pass'],$code1, $code2, $code3, $result['user_email']);
    }
}