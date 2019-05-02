<?php
/**
 * Plugin Name: TvConnecteeAmu
 * Description: Plugin de la télé connectée de l'AMU, ce plugin permet de générer des fichiers ICS. Ces fichiers sont ensuite lus pour pouvoir afficher l'emploi du temps de la personne connectée. Ce plugin permet aussi d'afficher la météo, des informations, des alertes. Tant en ayant une gestion des utilisateurs et des informations.
 * Version: 2.1.1
 * Author: Alexis Sola & Nicolas Rohrbach & Gwenaêl Roux
 * Author URI: http://tvconnectee.alwaysdata.net/
*/

include_once 'controllers/ControllerG.php';
include_once 'models/Model.php';
include_once 'views/ViewG.php';

include_once 'controllers/CodeAde.php';
include_once 'models/CodeAdeManager.php';
include_once 'views/ViewCodeAde.php';

include_once 'controllers/Student.php';
include_once 'models/StudentManager.php';
include_once 'views/ViewStudent.php';

include_once 'controllers/Teacher.php';
include_once 'models/TeacherManager.php';
include_once 'views/ViewTeacher.php';

include_once 'controllers/Television.php';
include_once 'models/TelevisionManager.php';
include_once 'views/ViewTelevision.php';

include_once 'controllers/Secretary.php';
include_once 'models/SecretaryManager.php';
include_once 'views/ViewSecretary.php';

include_once 'controllers/ManagementUsers.php';
include_once 'views/ViewManagementUsers.php';

include_once 'models/Excel/PHPExcel/IOFactory.php';
include_once 'models/Excel/PluginExcel.php';
include_once 'models/DAO/DAOUser.php';
include_once 'models/DAO/DAOStudent.php';
include_once 'models/DAO/DAOTeacher.php';

include_once 'controllers/R34ICS.php';
include_once 'controllers/Schedule.php';
include_once 'views/ViewSchedule.php';
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

$student = new Student();
$teacher = new Teacher();
$television = new Television();
$secretary = new Secretary();
$code = new CodeAde();

$managementusers = new ManagementUsers();

$schedule = new Schedule();
add_action('displaySchedule',array($schedule,'displayMySchedule'));

add_action('add_student', array($student, 'insertStudent'), 0, 1);
add_action('add_teacher', array($teacher, 'insertTeacher'), 0, 1);
add_action('add_television', array($television, 'insertTelevision'), 0, 7);
add_action('add_secretary', array($secretary, 'insertSecretary'), 0, 6);
add_action('add_code_ade', array($code, 'insertCode'));

add_action('display_all_codes', array($code, 'displayAllCodes'));
add_action('displayManagementUsers', array($managementusers, 'displayMyUsers'),0 , 2);

add_action('modify_user', array($managementusers, 'ModifyMyUser'));
add_action('modify_code_ade', array($code, 'modifyMyCode'));

add_action('delete_student', array($student, 'deleteStudent'), 0, 1);
add_action('delete_teacher', array($teacher, 'deleteTeacher'), 0, 1);
add_action('delete_code_ade', array($code, 'deleteMyCode'), 0, 1);
add_action('delete_users', array($student, 'deleteUsers'), 0, 1);

// Initialize plugin
add_action('init', function(){
    global $R34ICS;
    $R34ICS = new R34ICS();
});

// Flush rewrite rules when plugin is activated
register_activation_hook(__FILE__, function() { flush_rewrite_rules(); });