<?php
/**
 * Created by PhpStorm.
 * User: r17000292
 * Date: 06/02/2019
 * Time: 17:23
 */

class Schedule extends ControllerG
{
    private $view;

    /**
     * Schedule constructor.
     */
    public function __construct(){
        $this->view = new ViewSchedule();
    }

    /**
     * Vérifie si l'emploi du temps existe et qu'il a du contenus
     * @param $code
     * @param $force
     * @return bool
     */
    public function checkSchedule($code, $force){
        global $R34ICS;
        $R34ICS = new R34ICS();
        $url = ABSPATH."/wp-content/plugins/TeleConnecteeAmu/controllers/fileICS/".$code;
        $contents = $R34ICS->checkCalendar($url, $force);
        if (isset($contents))
            return true;
        else
            return false;
    }

    /**
     * Affiche l'emploi du temps demandé
     * @param $code
     * @param $force
     */
    public function displaySchedule($code, $force){
        global $R34ICS;
        $R34ICS = new R34ICS();

        $url = ABSPATH."/wp-content/plugins/TeleConnecteeAmu/controllers/fileICS/".$code;
        $args = array(
            'count' => 10,
            'description' => null,
            'eventdesc' => null,
            'format' => null,
            'hidetimes' => null,
            'showendtimes' => null,
            'title' => null,
            'view' => 'list',
        );
        $contents = $R34ICS->checkCalendar($url, $force);
        if (isset($contents)) {
            $model = new CodeAdeManager();
            $title = $model->getTitle($code);
            if ($code == $title) $this->addLogEvent("Le code s'est affiché au lieu du titre");
            $this->view->displayName($title);
            $R34ICS->display_calendar($contents, $args);
        }
    }

    /**
     * Affiche l'emploi du temps d'une promo en fonction de l'ID récupéré dans l'url
     */
    public function displayYearSchedule(){
        $code = $this->getMyIdUrl();
        $force = true;
        if ($this->checkSchedule($code, $force)) {
            $this->displaySchedule($code, $force);
        }
        else
            $this->view->displayEmptySchedule();
    }

    /**
     * Affiche l'emploi du temps de la personne concerné sauf si il s'agit d'une personne qui n'a pas de code ADE lié à son compte
     * @throws Exception
     */
    public function displaySchedules(){
        $current_user = wp_get_current_user();
        if ($current_user->role == "television" || $current_user->role == "etudiant" || $current_user->role == "enseignant") {
            $force = true;
            $codes = unserialize($current_user->code);
            $validSchedule = array();
            foreach ($codes as $code) {
                if ($this->checkSchedule($code, $force))
                    $validSchedule[] = $code;
            }
            if (empty($validSchedule))
                $this->view->displayEmptySchedule();
            else {
                if ($current_user->role == "television") {
                    $this->view->displayStartSlide();
                    foreach ($validSchedule as $schedule) {
                        $this->displaySchedule($schedule, $force);
                        $this->view->displayMidSlide();
                    }
                    $this->view->displayEndSlide();
                }
                else if($current_user->role == "etudiant"){
                    $this->displaySchedule($validSchedule[1], $force);
                }
                else
                    $this->displaySchedule($validSchedule[0], $force);
            }
        }
        else
            $this->view->displayWelcome();
    }
}