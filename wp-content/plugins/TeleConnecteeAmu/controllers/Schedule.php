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

    public function displaySchedule($tab, $code, $force){
        global $R34ICS;
        $R34ICS = new R34ICS();

        //$url = 'https://ade-consult.univ-amu.fr/jsp/custom/modules/plannings/anonymous_cal.jsp?resources='.$code.'&projectId=8&startDay='.$tab[0].'&startMonth='.$tab[1].'&startYear='.$tab[2].'&endDay='.$tab[3].'&endMonth='.$tab[4].'&endYear='.$tab[5].'&calType=ical';
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
        if(isset($contents)){
            $model = new CodeAdeManager();
            $title = $model->getTitle($code);
            if($code == $title) $this->addLogEvent("Le code s'est affiché au lieu du titre");
            echo '<h2>'.$title.'</h2>';
            $R34ICS->display_calendar($contents, $args);
        }
    }

    /**
     * Affiche l'emploi du temps de la personne concerné sauf si il s'agit d'une personne qui n'a pas de code ADE lié à son compte
     * @throws Exception
     */
    public function displayMySchedule(){
        if(is_user_logged_in()){
            ### Initialisation
            $planning = new Planning();

            ## Récupération de la configuration
            $conf = $planning->getConf();

            # On prépare l’export en iCal
            list($startDay, $startMonth, $startYear) = explode('/', gmdate('d\/m\/Y', $conf['FIRST_WEEK']));
            list($endDay, $endMonth, $endYear) = explode('/', gmdate('d\/m\/Y', intval($conf['FIRST_WEEK'] + ($conf['NB_WEEKS'] * 7 * 24 * 3600))));

            $tab = [$startDay, $startMonth, $startYear, $endDay, $endMonth, $endYear];
            $current_user = wp_get_current_user();
//            $url = 'https://ade-consult.univ-amu.fr/jsp/custom/modules/plannings/anonymous_cal.jsp?resources='.$current_user->code3.'&projectId=8&startDay='.$tab[0].'&startMonth='.$tab[1].'&startYear='.$tab[2].'&endDay='.$tab[3].'&endMonth='.$tab[4].'&endYear='.$tab[5].'&calType=ical';
//            file_put_contents(ABSPATH."/wp-content/plugins/TeleConnecteeAmu/controllers/fileICS/".$current_user->code3, fopen($url, 'r'));

            $force = true;
            $validSchedule = array();
            /*if($this->checkSchedule($tab, $current_user->code1, $force)) $validSchedule[] = $current_user->code1;
            if($this->checkSchedule($tab, $current_user->code2, $force)) $validSchedule[] = $current_user->code2;*/
            if($this->checkSchedule($tab, $current_user->code3, $force)) $validSchedule[] = $current_user->code3;
            if($current_user->role == "television") {
                $this->view->startSlide();
                foreach ($validSchedule as $schedule) {
                    $this->displaySchedule($tab, $schedule, $force);
                    $this->view->midSlide();
                }
                $this->view->endSlide();
            }
            else{
                $this->displaySchedule($tab, $validSchedule[0], $force);
            }
        }
    }
}