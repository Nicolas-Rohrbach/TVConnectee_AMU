<?php
/**
 * Created by PhpStorm.
 * User: s17018568
 * Date: 22/01/19
 * Time: 15:33
 */

class BdUser
{
    /**
     * BdUser constructor.
     */
    public function __construct(){
    }

    public function insertEtudiant($name, $mdp, $nicename, $email, $display, $annee, $alternant, $groupe, $demigroupe, $langue, $prenom){
        global $wpdb;
		$wpdb->query(
				$wpdb->prepare(
						"INSERT INTO `wp_users`(`ID`, `user_login`, `user_pass`, `role`, `annee`, `alternant`, `groupe`, `demiGroupe`, `langue`, `user_nicename`, `prenom`, `user_email`, `user_url`,
                        `user_registered`, `user_activation_key`, `user_status`, `display_name`) VALUES (%d, %s, %s, %s, %s, %d, %d, %s, %s, %s, %s, %s, %s, NOW(), %s, %d, %s)",
								null,
								$nicename,
								$mdp,
								'etudiant',
								$annee,
								$alternant,
								$groupe,
								$demigroupe,
								$langue,
								$name,
								$prenom,
								$email,
								' ',
								' ',
								null,
								$display)
		);
		
		$result = $wpdb->get_row('SELECT * FROM `wp_users` WHERE `user_login` ="' . $nicename . '"', ARRAY_A);
        $id = $result['ID'];

        $wpdb->query(
			$wpdb->prepare(
						"INSERT INTO `wp_usermeta`(`user_id`, `meta_key`, `meta_value`) VALUES (%d, %s, %s)",
								$id,
								'wp_capabilities',
								"a:1:{s:8:\"etudiant\";b:1;}")
		);
    }


public function insertProf($name, $mdp, $nicename, $prenom, $email, $display){
       global $wpdb;
		$wpdb->query(
				$wpdb->prepare(
						"INSERT INTO `wp_users`(`ID`, `user_login`, `user_pass`, `role`, `annee`, `alternant`, `groupe`, `demiGroupe`, `langue`, `user_nicename`, `prenom`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`) VALUES (%d, %s, %s, %s, %s, %d, %d, %s, %s, %s, %s, %s, %s, NOW(), %s, %d, %s)",
								null,
								$nicename,
								$mdp,
								'enseignant',
								'',
								'',
								'',
								'',
								'',
								$name,
								$prenom,
								$email,
								' ',
								' ',
								null,
								$display)
		);
	
		$result = $wpdb->get_row('SELECT * FROM `wp_users` WHERE `user_login` ="' . $nicename . '"', ARRAY_A);
        $id = $result['ID'];
	
		$wpdb->query(
			$wpdb->prepare(
						"INSERT INTO `wp_usermeta`(`user_id`, `meta_key`, `meta_value`) VALUES (%d, %s, %s)",
								$id,
								'wp_capabilities',
								"a:1:{s:10:\"enseignant\";b:1;}")
		);
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