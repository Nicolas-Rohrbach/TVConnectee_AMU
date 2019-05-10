<?php
/*
Plugin Name: TvConnecteeAmu
Description: Plugin de la télé connectée de l'AMU
Version: 1.5
Author: Alexis
*/
include_once 'views/ViewG.php';
include_once 'views/ViewCard.php';
include_once 'views/ViewUser.php';
include_once 'views/ViewInformation.php';
include_once 'views/ViewAlert.php';

include_once 'controllers/Information.php';
include_once 'controllers/Info.php';
include_once 'controllers/Alert.php';


include_once 'models/BdInfo.php';
include_once 'models/BdUser.php';
include_once 'models/BdInformation.php';
include_once 'models/BdAlert.php';

include_once 'controllers/User.php';
include_once 'Excel/PHPExcel/IOFactory.php';
include_once 'Excel/PluginExcel.php';
include_once 'models/DAO/DAOUser.php';
include_once 'models/DAO/DAOEtudiant.php';
include_once 'models/DAO/DAOProf.php';

include_once 'views/ViewSchedule.php';
include_once 'controllers/Schedule.php';
include_once 'controllers/Weather.php';
include_once 'views/ViewWeather.php';


add_action("wp_head", "mfp_card");
define('ROOT', dirname(__FILE__));
require_once(ROOT . '/controllers/fileSchedule/app/app.php');

function mfp_Card()
{
  echo '  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
   <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css">-->
';
}


$information = new Information();
$alert = new Alert();
$users = new User();
$schedule = new Schedule();
$weather = new Weather();



add_action('ajouter_user', array($users, 'insert_user'), 0, 3);

add_action('afficher_prof', array($users, 'afficherLesProf'), 0, 1 );
add_action('afficher_etudiant', array($users, 'afficherLesEtudiants'),0 ,1 );

add_action('supprimerEtudiant', array($users, 'supprEtudiant'), 0, 1);
add_action('supprimerProf', array($users, 'supprProf'), 0, 1);

add_action('modifetud', array($users, 'afficherModifEtudiant'), 0, 5);
add_action('modifprof', array($users, 'afficherModifProf') );

add_action('hookEDT',array($schedule,'displayMySchedule'));
add_action('hookWeather',array($weather,'displayMyWeather'));

add_action('handleInfos',array($information,'displayAllInformations'));
add_action('delete_infos',array($information, 'deleteInformations'),0 ,1);
add_action('modify_info',array($information,'modifyInformation'));
//add_action('displayInformations',array($information,'displayInformationMain'));
add_action('add_info',array($information,'insertInformation'), 0, 5);

add_action('createAlert',array($alert,'createAlert'),0,3);
add_action('handleAlert', array($alert,'displayListAlerts'));
add_action('delete_alert', array($alert,'deleteAlert'), 0 ,1);
add_action('modify_alert',array($alert,'modifyAlert'));
add_action('display_alert', array($alert, 'alertMain'));




add_action('test',array($alert,'displayListAlerts'));


