<?php
/**
 * Created by PhpStorm.
 * User: s17018568
 * Date: 22/01/19
 * Time: 15:33
 */

class BdUser
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

    public function checkNoDouble ($email, $login) {
        return $this->verifyNoDouble($email, $login);
    }

    public function insertEtudiant($name, $pwd, $nicename, $email, $display, $year, $group, $demigroup, $firstname){

        if($this->verifyNoDouble($email,$nicename)) {
            $req = $this->getBdd()->prepare('INSERT INTO wp_users (user_login, user_pass, role, annee, groupe, demiGroupe,
                                      user_nicename, prenom, user_email, user_url, user_registered, user_activation_key,
                                      user_status, display_name) 
                                         VALUES (:login, :pwd, :role, :annee, :groupe, :demiGroupe, :name, :firstname, :email, :url, NOW(), :key, :status, :displayname)');

            $nul = " ";
            $zero = 0;
            $role = "etudiant";

            $req->bindParam(':login', $nicename);
            $req->bindParam(':pwd', $pwd);
            $req->bindParam(':role', $role);
            $req->bindParam(':annee', $year);
            $req->bindParam(':groupe', $group);
            $req->bindParam(':demiGroupe', $demigroup);
            $req->bindParam(':name', $name);
            $req->bindParam(':firstname', $firstname);
            $req->bindParam(':email', $email);
            $req->bindParam(':url', $nul);
            $req->bindParam(':key', $nul);
            $req->bindParam(':status', $zero);
            $req->bindParam(':displayname', $display);

            $req->execute();

            global $wpdb;

            $capa = 'wp_capabilities';
            $role = 'a:1:{s:8:"etudiant";b:1;}';

            $result = $wpdb->get_row('SELECT * FROM `wp_users` WHERE `user_login` ="' . $nicename . '"', ARRAY_A);
            $id = $result['ID'];

            $req = $this->getBdd()->prepare('INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUES (:id, :capabilities, :role)');

            $req->bindParam(':id', $id);
            $req->bindParam(':capabilities', $capa);
            $req->bindParam(':role', $role);

            $req->execute();

            return true;
        }
        else {

            return false;
        }

    }


    public function insertProf($name, $pwd, $nicename, $firstname, $email, $display,$code){

        if($this->verifyNoDouble($email,$nicename)) {
            $req = $this->getBdd()->prepare('INSERT INTO wp_users (user_login, user_pass, role, annee, groupe, demiGroupe,
                                      user_nicename, prenom, user_email, user_url, user_registered, user_activation_key,
                                      user_status, display_name) 
                                         VALUES (:login, :pwd, :role, :annee, :groupe, :demiGroupe, :name, :firstname, :email, :url, NOW(), :key, :status, :displayname)');

            $nul = " ";
            $zero = "0";
            $role = "enseignant";

            $req->bindParam(':login', $nicename);
            $req->bindParam(':pwd', $pwd);
            $req->bindParam(':role', $role);
            $req->bindParam(':annee', $code);
            $req->bindParam(':groupe', $code2);
            $req->bindParam(':demiGroupe', $code3);
            $req->bindParam(':name', $name);
            $req->bindParam(':firstname', $firstname);
            $req->bindParam(':email', $email);
            $req->bindParam(':url', $nul);
            $req->bindParam(':key', $nul);
            $req->bindParam(':status', $zero);
            $req->bindParam(':displayname', $display);

            $req->execute();

            global $wpdb;

            $capa = 'wp_capabilities';
            $role = 'a:1:{s:10:"enseignant";b:1;}';

            $result = $wpdb->get_row('SELECT * FROM `wp_users` WHERE `user_login` ="' . $nicename . '"', ARRAY_A);
            $id = $result['ID'];

            $req = $this->getBdd()->prepare('INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUES (:id, :capabilities, :role)');

            $req->bindParam(':id', $id);
            $req->bindParam(':capabilities', $capa);
            $req->bindParam(':role', $role);

            $req->execute();

            return true;

        }
        else {
            return false;
        }

    }

    public function insertTv($name, $pwd, $code, $code2, $code3){

        if($this->verifyNoDouble($name,$name)) {
            $req = $this->getBdd()->prepare('INSERT INTO wp_users (user_login, user_pass, role, annee, groupe, demiGroupe,
                                      user_nicename, prenom, user_email, user_url, user_registered, user_activation_key,
                                      user_status, display_name) 
                                         VALUES (:login, :pwd, :role, :annee, :groupe, :demiGroupe, :name, :firstname, :email, :url, NOW(), :key, :status, :displayname)');

            $nul = " ";
            $zero = "0";
            $role = "television";

            $req->bindParam(':login', $name);
            $req->bindParam(':pwd', $pwd);
            $req->bindParam(':role', $role);
            $req->bindParam(':annee', $code);
            $req->bindParam(':groupe', $code2);
            $req->bindParam(':demiGroupe', $code3);
            $req->bindParam(':name', $nul);
            $req->bindParam(':firstname', $name);
            $req->bindParam(':email', $name);
            $req->bindParam(':url', $nul);
            $req->bindParam(':key', $nul);
            $req->bindParam(':status', $zero);
            $req->bindParam(':displayname', $name);

            $req->execute();

            global $wpdb;

            $capa = 'wp_capabilities';
            $role = 'a:1:{s:10:"television";b:1;}';

            $result = $wpdb->get_row('SELECT * FROM `wp_users` WHERE `user_login` ="' . $name . '"', ARRAY_A);
            $id = $result['ID'];

            $req = $this->getBdd()->prepare('INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUES (:id, :capabilities, :role)');

            $req->bindParam(':id', $id);
            $req->bindParam(':capabilities', $capa);
            $req->bindParam(':role', $role);

            $req->execute();

            return true;

        }
        else {
            return false;
        }

    }

    public function insertSecre($login, $pwd, $firstname, $lastname){

        if($this->verifyNoDouble($login,$login)) {
            $req = $this->getBdd()->prepare('INSERT INTO wp_users (user_login, user_pass, role, annee, groupe, demiGroupe,
                                      user_nicename, prenom, user_email, user_url, user_registered, user_activation_key,
                                      user_status, display_name) 
                                         VALUES (:login, :pwd, :role, :annee, :groupe, :demiGroupe, :name, :firstname, :email, :url, NOW(), :key, :status, :displayname)');

            $nul = " ";
            $zero = "0";
            $role = "secretaire";
            $diplayname = $firstname." ".$lastname;

            $req->bindParam(':login', $login);
            $req->bindParam(':pwd', $pwd);
            $req->bindParam(':role', $role);
            $req->bindParam(':annee', $zero);
            $req->bindParam(':groupe', $zero);
            $req->bindParam(':demiGroupe', $zero);
            $req->bindParam(':name', $nul);
            $req->bindParam(':firstname', $firstname);
            $req->bindParam(':email', $lastname);
            $req->bindParam(':url', $nul);
            $req->bindParam(':key', $nul);
            $req->bindParam(':status', $zero);
            $req->bindParam(':displayname', $diplayname);

            $req->execute();

            global $wpdb;

            $capa = 'wp_capabilities';
            $role = 'a:1:{s:10:"secretaire";b:1;}';

            $result = $wpdb->get_row('SELECT * FROM `wp_users` WHERE `user_login` ="' . $login . '"', ARRAY_A);
            $id = $result['ID'];

            $req = $this->getBdd()->prepare('INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUES (:id, :capabilities, :role)');

            $req->bindParam(':id', $id);
            $req->bindParam(':capabilities', $capa);
            $req->bindParam(':role', $role);

            $req->execute();

            return true;

        }
        else {
            return false;
        }

    }

    public function getEtudiants(){
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM wp_users WHERE role = 'etudiant'", ARRAY_A);
        return $result;
    }

public function getById($id){
        global $wpdb;
        $result = $wpdb->get_row('SELECT * FROM `wp_users` WHERE `ID` ="' . $id . '"', ARRAY_A);
        return $result;
    }

    public function getProfs(){
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM wp_users WHERE role = 'enseignant'", ARRAY_A);
        return $result;
    }
	
    public function getByGroupe($groupe){
		global $wpdb;
		$result = $wpdb->get_results("SELECT * FROM wp_users WHERE groupe= '$groupe'", ARRAY_A) ;
		return $result ;
    }
	
	public function getByAnnee($annee){
		global $wpdb;
		$result = $wpdb->get_results("SELECT * FROM wp_users WHERE annee= '$annee'", ARRAY_A) ;
		return $result ; 
    }

    public function getByNomPrenom($nom, $prenom){
        global $wpdb;
        $result = $wpdb->get_row('SELECT groupe, annee FROM wp_users WHERE user_nicename = "'.$nom.'" AND prenom = "'.$prenom.' "', ARRAY_A);
        return $result;
    }

    public function supprEtudiant($id){
        global $wpdb;
        $wpdb->query("DELETE FROM wp_users WHERE id = '$id'");
        $wpdb->query("DELETE FROM wp_usermeta WHERE user_id = '$id'");
    }

    public function supprProf($id){
        global $wpdb;
        $wpdb->query("DELETE FROM wp_users WHERE id = '$id'");
        $wpdb->query("DELETE FROM wp_usermeta WHERE user_id = '$id'");
    }
}