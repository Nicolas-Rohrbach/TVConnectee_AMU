<?php
/**
 * Created by PhpStorm.
 * User: r17000292
 * Date: 06/02/2019
 * Time: 17:23
 */

class Schedule extends ControllerG {
    private $view;

    /**
     * Schedule constructor.
     */
    public function __construct(){
        $this->view = new ViewSchedule();
    }

    /**
     * Renvoie les dates de début et de fin, de l'emploi du temps
     * @return array
     */
    public function getTabConfig(){
        ### Initialisation
        $planning = new Planning();

        ## Récupération de la configuration
        $conf = $planning->getConf();

        # On prépare l’export en iCal
        list($startDay, $startMonth, $startYear) = explode('/', gmdate('d\/m\/Y', $conf['FIRST_WEEK']));
        list($endDay, $endMonth, $endYear) = explode('/', gmdate('d\/m\/Y', intval($conf['FIRST_WEEK'] + ($conf['NB_WEEKS'] * 7 * 24 * 3600))));

        $tab = [$startDay, $startMonth, $startYear, $endDay, $endMonth, $endYear];

        return $tab;
    }

    /**
     * Vérifie si l'emploi du temps existe
     * @param $tab
     * @param $code
     * @param $force
     * @return bool
     */
    public function checkSchedule($tab, $code, $force){
        global $R34ICS;
        $R34ICS = new R34ICS();
        $url = 'https://ade-consult.univ-amu.fr/jsp/custom/modules/plannings/anonymous_cal.jsp?resources='.$code.'&projectId=8&startDay='.$tab[0].'&startMonth='.$tab[1].'&startYear='.$tab[2].'&endDay='.$tab[3].'&endMonth='.$tab[4].'&endYear='.$tab[5].'&calType=ical';
        $contents = $R34ICS->checkCalendar($url, $force);
        if(isset($contents)) {
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * Affiche l'emploi du temps demandé
     * @param $tab
     * @param $code
     * @param $force
     */
    public function displaySchedule($tab, $code, $force){
        global $R34ICS;
        $R34ICS = new R34ICS();

        $url = 'https://ade-consult.univ-amu.fr/jsp/custom/modules/plannings/anonymous_cal.jsp?resources='.$code.'&projectId=8&startDay='.$tab[0].'&startMonth='.$tab[1].'&startYear='.$tab[2].'&endDay='.$tab[3].'&endMonth='.$tab[4].'&endYear='.$tab[5].'&calType=ical';
        //$url = ABSPATH."/wp-content/plugins/TeleConnecteeAmu/controllers/fileICS/".$code;
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
        if(isset($contents)){
            $model = new CodeAdeManager();
            $title = $model->getTitle($code);
            if($code == $title) $this->addLogEvent("Le code s'est affiché au lieu du titre");
            $this->view->displayName($title);
            $R34ICS->display_calendar($contents, $args);
        }
    }

    /**
     * Affiche l'emploi du temps de la personne concerné sauf si il s'agit d'une personne qui n'a pas de code ADE lié à son compte
     * @throws Exception
     */
    public function displaySchedules(){
        $current_user = wp_get_current_user();
        $urlExpl = explode('/', $_SERVER['REQUEST_URI']);
        if(is_user_logged_in() && isset($urlExpl[2])){
            $tab = $this->getTabConfig();
            $code = $urlExpl[2];
            $force = true;
            if($this->checkSchedule($tab, $code, $force)) {
                $this->displaySchedule($tab, $code, $force);
            }
            else{
                $this->view->displayEmptySchedule();
            }
        }
        elseif($current_user->role =="television" || $current_user->role == "etudiant" || $current_user->role == "enseignant"){
//            $url = 'https://ade-consult.univ-amu.fr/jsp/custom/modules/plannings/anonymous_cal.jsp?resources='.$current_user->code3.'&projectId=8&startDay='.$tab[0].'&startMonth='.$tab[1].'&startYear='.$tab[2].'&endDay='.$tab[3].'&endMonth='.$tab[4].'&endYear='.$tab[5].'&calType=ical';
//            file_put_contents(ABSPATH."/wp-content/plugins/TeleConnecteeAmu/controllers/fileICS/".$current_user->code3, fopen($url, 'r'));

            $force = true;
            $tab = $this->getTabConfig();
            $codes = unserialize($current_user->code);
            $validSchedule = array();
            foreach ($codes as $code){
                if($this->checkSchedule($tab, $code, $force))
                    $validSchedule[] = $code;
            }
            if(empty($validSchedule))
                $this->view->displayEmptySchedule();
            else{
                if($current_user->role == "television") {
                    $this->view->displayStartSlide();
                    foreach ($validSchedule as $schedule) {
                        $this->displaySchedule($tab, $schedule, $force);
                        $this->view->displayMidSlide();
                    }
                    $this->view->displayEndSlide();
                }
                else{
                    $this->displaySchedule($tab, $validSchedule[0], $force);
                }
            }
        }
        else{
            $this->view->displayWelcome();
        }
    }
}