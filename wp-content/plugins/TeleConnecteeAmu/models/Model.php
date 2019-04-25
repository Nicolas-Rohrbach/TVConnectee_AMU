<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 25/03/2019
 * Time: 18:10
 */

abstract class Model
{
    private static $bdd;

    private static function setBdd()
    {
        global $wpdb;
        self::$bdd = new PDO('mysql:host='.$wpdb->dbhost.'; dbname='.$wpdb->dbname, $wpdb->dbuser, $wpdb->dbpassword);
        self::$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }

    protected function getBdd()
    {
        if (self:: $bdd == null)
            self::setBdd();
        return self::$bdd;
    }

    protected function getAll($table)
    {
        $var = [];
        $req = $this->getBdd()->prepare('SELECT * FROM ' . $table . ' ORDER BY ID desc');
        $req->execute();
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $var[] = $data;
        }
        return $var;
        $req->closeCursor();
    }

    public function getEmail($login)
    {
        $var = [];
        $req = $this->getBdd()->prepare('SELECT * FROM USER WHERE LOGIN = :login');
        $req->bindValue(':login', $login);
        $req->execute();
        while ($data = $req->fetch()) {
            $var[] = $data;
        }
        return $var;
        $req->closeCursor();
    }

    protected function verifyNoDouble($email, $login)
    {
        $var = 0;
        $req = $this->getBdd()->prepare('SELECT * FROM wp_users WHERE user_email =:mail OR user_login =:login');
        $req->bindValue(':mail', $email);
        $req->bindValue(':login', $login);
        $req->execute();
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $var = $var + 1;
        }
        if ($var > 0) {
            return false;
        } else {
            return true;
        }
        $req->closeCursor();
    }

    protected function insertUser($login, $pwd, $role, $year, $group, $halfgroup, $firstname, $lastname, $email)
    {
        if ($this->verifyNoDouble($email, $login)) {
            $req = $this->getBdd()->prepare('INSERT INTO wp_users (user_login, user_pass, role, annee, groupe, demiGroupe,
                                      user_nicename, prenom, user_email, user_url, user_registered, user_activation_key,
                                      user_status, display_name) 
                                         VALUES (:login, :pwd, :role, :annee, :groupe, :demiGroupe, :name, :firstname, :email, :url, NOW(), :key, :status, :displayname)');

            $nul = " ";
            $zero = "0";

            $display = $firstname.' '.$lastname;

            $req->bindParam(':login', $login);
            $req->bindParam(':pwd', $pwd);
            $req->bindParam(':role', $role);
            $req->bindParam(':annee', $year);
            $req->bindParam(':groupe', $group);
            $req->bindParam(':demiGroupe', $halfgroup);
            $req->bindParam(':name', $lastname);
            $req->bindParam(':firstname', $firstname);
            $req->bindParam(':email', $email);
            $req->bindParam(':url', $nul);
            $req->bindParam(':key', $nul);
            $req->bindParam(':status', $zero);
            $req->bindParam(':displayname', $display);

            $req->execute();

            global $wpdb;

            $capa = 'wp_capabilities';
            $role = 'a:1:{s:10:"'.$role.'";b:1;}';

            $result = $wpdb->get_row('SELECT * FROM `wp_users` WHERE `user_login` ="' . $login . '"', ARRAY_A);
            $id = $result['ID'];

            $req = $this->getBdd()->prepare('INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUES (:id, :capabilities, :role)');

            $req->bindParam(':id', $id);
            $req->bindParam(':capabilities', $capa);
            $req->bindParam(':role', $role);

            $req->execute();

            $level = "wp_user_level";

            $req = $this->getBdd()->prepare('INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUES (:id, :level, :value)');

            $req->bindParam(':id', $id);
            $req->bindParam(':level', $level);
            $req->bindParam(':value', $zero);

            $req->execute();

            return true;
        }
        else {
            return false;
        }
    }

    public function deleteUser($id){
        global $wpdb;
        $wpdb->query("DELETE FROM wp_users WHERE id = '$id'");
        $wpdb->query("DELETE FROM wp_usermeta WHERE user_id = '$id'");
    }

    public function getById($id){
        global $wpdb;
        $result = $wpdb->get_row('SELECT * FROM `wp_users` WHERE `ID` ="' . $id . '"', ARRAY_A);
        return $result;
    }

    public function getByGroup($group){
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM wp_users WHERE groupe= '$group'", ARRAY_A) ;
        return $result ;
    }

    public function getByYear($year){
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM wp_users WHERE annee= '$year'", ARRAY_A) ;
        return $result ;
    }

    public function getByName($firstname, $lastname){
        global $wpdb;
        $result = $wpdb->get_row('SELECT groupe, annee FROM wp_users WHERE user_nicename = "'.$lastname.'" AND prenom = "'.$firstname.' "', ARRAY_A);
        return $result;
    }
}