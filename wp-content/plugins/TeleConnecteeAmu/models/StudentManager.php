<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 25/04/2019
 * Time: 10:02
 */

class StudentManager extends Model
{
    public function insertMyStudent($login, $pwd, $year, $group, $halfgroup, $firstname, $lastname, $email){

        $role = "etudiant";

        return $this->insertUser($login, $pwd, $role, $year, $group, $halfgroup, $firstname, $lastname, $email);

    }

    public function getStudents(){
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM wp_users WHERE role = 'etudiant'", ARRAY_A);
        return $result;
    }

}