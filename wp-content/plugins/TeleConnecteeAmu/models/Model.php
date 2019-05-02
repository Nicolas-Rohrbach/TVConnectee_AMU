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

    /**
     * Set the db with PDO
     */
    private static function setBdd(){
        global $wpdb;
        self::$bdd = new PDO('mysql:host='.$wpdb->dbhost.'; dbname='.$wpdb->dbname, $wpdb->dbuser, $wpdb->dbpassword);
        self::$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }

    /**
     * Return the db
     * @return mixed
     */
    protected function getBdd(){
        if (self:: $bdd == null)
            self::setBdd();
        return self::$bdd;
    }

    protected function getAll($table){
        $var = [];
        $req = $this->getBdd()->prepare('SELECT * FROM ' . $table . ' ORDER BY ID desc');
        $req->execute();
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $var[] = $data;
        }
        return $var;
        $req->closeCursor();
    }

    protected function verifyTuple($login){
        $var = 0;
        $req = $this->getBdd()->prepare('SELECT * FROM wp_users WHERE user_login =:login');
        $req->bindValue(':login', $login);
        $req->execute();
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $var = $var + 1;
        }
        if ($var > 0) {
            return true;
        } else {
            return false;
        }
        $req->closeCursor();
    }

    protected function verifyNoDouble($email, $login){
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

    protected function insertUser($login, $pwd, $role, $code1, $code2, $code3, $email){
        if ($this->verifyNoDouble($email, $login)){
            $req = $this->getBdd()->prepare('INSERT INTO wp_users (user_login, user_pass, role, code1, code2, code3,
                                      user_nicename, user_email, user_url, user_registered, user_activation_key,
                                      user_status, display_name) 
                                         VALUES (:login, :pwd, :role, :code1, :code2, :code3, :name, :email, :url, NOW(), :key, :status, :displayname)');

            $nul = " ";
            $zero = "0";

            $req->bindParam(':login', $login);
            $req->bindParam(':pwd', $pwd);
            $req->bindParam(':role', $role);
            $req->bindParam(':code1', $code1);
            $req->bindParam(':code2', $code2);
            $req->bindParam(':code3', $code3);
            $req->bindParam(':name', $login);
            $req->bindParam(':email', $email);
            $req->bindParam(':url', $nul);
            $req->bindParam(':key', $nul);
            $req->bindParam(':status', $zero);
            $req->bindParam(':displayname', $login);

            $req->execute();

            $capa = 'wp_capabilities';
            $role = 'a:1:{s:10:"'.$role.'";b:1;}';

            $id = $this->getBdd()->lastInsertId();

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
        else{
            return false;
        }
    }

    protected function modifyUser($id, $login, $pwd, $code1, $code2, $code3, $email){
        if ($this->verifyTuple($login)) {
            $req = $this->getBdd()->prepare('UPDATE wp_users SET user_login=:login, user_pass=:pwd, code1=:code1, 
                                            code2=:code2, code3=:code3, user_nicename=:name, 
                                            user_email=:email, display_name=:displayname WHERE ID=:id');

            $req->bindParam(':id', $id);
            $req->bindParam(':login', $login);
            $req->bindParam(':pwd', $pwd);
            $req->bindParam(':code1', $code1);
            $req->bindParam(':code2', $code2);
            $req->bindParam(':code3', $code3);
            $req->bindParam(':name', $login);
            $req->bindParam(':email', $email);
            $req->bindParam(':displayname', $login);

            $req->execute();

            return true;
        }
        else {
            return false;
        }
    }

    public function getUsersByRole($role){
        $req = $this->getBdd()->prepare('SELECT * FROM wp_users WHERE role = :role');
        $req->bindParam(':role', $role);
        $req->execute();
        while ($data = $req->fetch()) {
            $var[] = $data;
        }
        return $var;
        $req->closeCursor();
    }

    public function getTitleOfCode($code){
        $req = $this->getBdd()->prepare('SELECT title FROM code_ade WHERE code = :code');
        $req->bindParam(':code', $code);
        $req->execute();
        while ($data = $req->fetch()) {
            $var[] = $data;
        }
        return $var;
        $req->closeCursor();
    }

    public function getCodeYear(){
        $req = $this->getBdd()->prepare('SELECT * FROM code_ade WHERE type = "Annee"');
        $req->execute();
        while ($data = $req->fetch()) {
            $var[] = $data;
        }
        return $var;
        $req->closeCursor();
    }

    public function getCodeGroup(){
        $req = $this->getBdd()->prepare('SELECT * FROM code_ade WHERE type = "Groupe"');
        $req->execute();
        while ($data = $req->fetch()) {
            $var[] = $data;
        }
        return $var;
        $req->closeCursor();
    }

    /**
     * Return all code from Halfgroup
     * @return array
     */
    public function getCodeHalfgroup(){
        $req = $this->getBdd()->prepare('SELECT * FROM code_ade WHERE type = "Demi-Groupe"');
        $req->execute();
        while ($data = $req->fetch()) {
            $var[] = $data;
        }
        return $var;
        $req->closeCursor();
    }

    /**
     * If the code has not a title, return the code
     * @param $code
     * @return mixed
     */
    public function getTitle($code){
        $var = $this->getTitleOfCode($code);
        if(! isset($var[0]['title']))  $var[0]['title'] = $code;
        return $var[0]['title'];
    }

    /**
     * Delete a row from a table due to the id
     * @param $table
     * @param $id
     */
    protected function deleteTuple($table, $id){

        $req = $this->getBdd()->prepare('DELETE FROM '.$table.' WHERE ID = :id');
        $req->bindValue(':id', $id);

        $req->execute();
    }

    /**
     * Delete a user
     * @param $id
     */
    public function deleteUser($id){
        $this->deleteTuple('wp_users', $id);
        $req = $this->getBdd()->prepare('DELETE FROM wp_usermeta WHERE user_id = :id');
        $req->bindValue(':id', $id);

        $req->execute();
    }

    /**
     * Get a user due to his id
     * @param $id
     * @return mixed
     */
    public function getById($id){
        global $wpdb;
        $result = $wpdb->get_row('SELECT * FROM `wp_users` WHERE `ID` ="' . $id . '"', ARRAY_A);
        return $result;
    }

    /**
     * Get all students from the same group
     * @param $group
     * @return mixed
     */
    public function getByGroup($group){
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM wp_users WHERE code2= '$group'", ARRAY_A) ;
        return $result ;
    }

    /**
     * Get all students from the same year
     * @param $year
     * @return mixed
     */
    public function getByYear($year){
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM wp_users WHERE code1= '$year'", ARRAY_A) ;
        return $result ;
    }
}