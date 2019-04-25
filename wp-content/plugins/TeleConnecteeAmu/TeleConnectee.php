<?php
/**
 * Plugin Name: TvConnecteeAmu
 * Description: Plugin de la télé connectée de l'AMU, ce plugin permet de générer des fichiers ICS. Ces fichiers sont ensuite lus pour pouvoir afficher l'emploi du temps de la personne connectée. Ce plugin permet aussi d'afficher la météo, des informations, des alertes. Tant en ayant une gestion des utilisateurs et des informations.
 * Version: 2.1.1
 * Author: Alexis Sola & Nicolas Rohrbach & Gwenaêl Roux
 * Author URI: http://tvconnectee.alwaysdata.net/
*/

include_once 'views/ViewUser.php';
include_once 'models/BdUser.php';
include_once 'controllers/User.php';
include_once 'models/Excel/PHPExcel/IOFactory.php';
include_once 'models/Excel/PluginExcel.php';
include_once 'models/DAO/DAOUser.php';
include_once 'models/DAO/DAOEtudiant.php';
include_once 'models/DAO/DAOProf.php';

include_once 'views/ViewSchedule.php';
include_once 'controllers/Schedule.php';

include_once 'controllers/Weather.php';
include_once 'views/ViewWeather.php';

include_once 'controllers/R34ICS.php';
include_once 'views/ViewR34ICS.php';


add_action("wp_head", "mfp_card");
define('ROOT', dirname(__FILE__));
require_once(ROOT . '/controllers/fileSchedule/app/app.php');

function mfp_Card()
{
  echo '  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
   <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css">-->
';
}

$users = new User();
$schedule = new Schedule();
$weather = new Weather();

add_action('HookAlexis', array( $info, 'affichage_infos_pages' ) );
add_action('infosMobile', array($info, 'affichage_infos_mobile' ) );

add_action('insert_info', array( $info, 'traitement_formulaire_info'), 0, 4);
add_action('HookAlexis', array( $info, 'suppr_info'), 0, 2);
add_action('modif_info', array( $info, 'modifier_info'), 0, 4);

add_action('add_student', array($users, 'insert_etudiant'), 0, 1);
add_action('add_teacher', array($users, 'insert_prof'), 0, 1);
add_action('hookTv', array($users, 'insert_tv'), 0, 6);
add_action('add_secre', array($users, 'insert_secre'), 0, 5);

add_action('afficher_prof', array($users, 'afficherLesProf'), 0, 1 );
add_action('afficher_etudiant', array($users, 'afficherLesEtudiants'),0 ,1 );

add_action('supprimerEtudiant', array($users, 'supprEtudiant'), 0, 1);
add_action('supprimerProf', array($users, 'supprProf'), 0, 1);

add_action('modifetud', array($users, 'afficherModifEtudiant'), 0, 5);
add_action('modifprof', array($users, 'afficherModifProf') );

add_action('hookEDT',array($schedule,'displayMySchedule'));
add_action('hookWeather',array($weather,'displayMyWeather'));

// Initialize plugin
add_action('init', function() {
    global $R34ICS;
    $R34ICS = new R34ICS();
});

// Flush rewrite rules when plugin is activated
register_activation_hook(__FILE__, function() { flush_rewrite_rules(); });