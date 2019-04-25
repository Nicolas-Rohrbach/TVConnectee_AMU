<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 25/04/2019
 * Time: 10:13
 */

class TeacherManager extends Model
{
    public function insertMyTeacher($login, $pwd, $code, $firstname, $lastname, $email){

        $role = "enseignant";
        $group = 0;
        $halfgroup = 0;

        return $this->insertUser($login, $pwd, $role, $code, $group, $halfgroup, $firstname, $lastname, $email);

    }

    public function getTeachers(){
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM wp_users WHERE role = 'enseignant'", ARRAY_A);
        return $result;
    }

}