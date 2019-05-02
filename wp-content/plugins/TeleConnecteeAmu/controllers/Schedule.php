<?php
/**
 * Created by PhpStorm.
 * User: r17000292
 * Date: 06/02/2019
 * Time: 17:23
 */

class Schedule
{
    private $view;

    /**
     * Schedule constructor.
     */
    public function __construct(){
        $this->view = new ViewSchedule();
    }

    /**
     * Affiche l'emploi du temps de la personne concerné sauf si il s'agit d'une personne qui n'a pas de code ADE lié à son compte
     * @throws Exception
     */
    public function displayMySchedule(){
        ### Initialisation
        $planning = new Planning();

        ## Récupération de la configuration
        $conf = $planning->getConf();

        # On prépare l’export en iCal
        list($startDay, $startMonth, $startYear) = explode('/', gmdate('d\/m\/Y', $conf['FIRST_WEEK']));
        list($endDay, $endMonth, $endYear) = explode('/', gmdate('d\/m\/Y', intval($conf['FIRST_WEEK'] + ($conf['NB_WEEKS'] * 7 * 24 * 3600))));

        # Cherche le code ADE dans le dossier data/ressources.yaml en fonction de l'utilisateur connecté et demande à afficher l'emploi du temps
        $current_user = wp_get_current_user();

        if($current_user->code3 != 0) {
            $this->view->displayName($current_user);
            $this->view->displayTimetable($current_user->demiGroupe,$startDay,$startMonth,$startYear,$endDay,$endMonth,$endYear);
        }
        else if($current_user->code2 != 0) {
            $this->view->displayName($current_user);
            $this->view->displayTimetable($current_user->groupe,$startDay,$startMonth,$startYear,$endDay,$endMonth,$endYear);
        }
        else if($current_user->code1 != 0) {
            $this->view->displayName($current_user);
            $this->view->displayTimetable($current_user->annee,$startDay,$startMonth,$startYear,$endDay,$endMonth,$endYear);
        }
        #Si la personne n'est pas connectée ou si il s'agit d'un Admin ou d'une secrétaire
        else {
            $this->view->displayHome($current_user);
        }
    }

}