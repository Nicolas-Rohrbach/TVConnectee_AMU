<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 25/04/2019
 * Time: 10:13
 */

class TeacherManager extends Model
{
    public function insertTeacher($login, $pwd, $code, $email){
        $role = "enseignant";
        $group = 0;
        $halfgroup = 0;
        return $this->insertUser($login, $pwd, $role, $code, $group, $halfgroup, $email);
    }

    public function modifyTeacher($result, $code){
        $this->modifyUser($result['ID'], $result['user_login'], $result['user_pass'], $code, 0, 0, $result['user_email']);
    }
}