<?php
/**
 * Created by PhpStorm.
 * User: r17000292
 * Date: 06/02/2019
 * Time: 17:23
 */

class Schedule {
    private $view;

    /**
     * Schedule constructor.
     */
    public function __construct(){
        $this->view = new ViewSchedule();
    }

    public function displaySchedule($code){
        ### Initialisation
        $planning = new Planning();

        ## Récupération de la configuration
        $conf = $planning->getConf();

        # On prépare l’export en iCal
        list($startDay, $startMonth, $startYear) = explode('/', gmdate('d\/m\/Y', $conf['FIRST_WEEK']));
        list($endDay, $endMonth, $endYear) = explode('/', gmdate('d\/m\/Y', intval($conf['FIRST_WEEK'] + ($conf['NB_WEEKS'] * 7 * 24 * 3600))));

        global $R34ICS;
        $R34ICS = new R34ICS();
        $url = 'https://ade-consult.univ-amu.fr/jsp/custom/modules/plannings/anonymous_cal.jsp?resources='.$code.'&projectId=8&startDay='.$startDay.'&startMonth='.$startMonth.'&startYear='.$startYear.'&endDay='.$endDay.'&endMonth='.$endMonth.'&endYear='.$endYear.'&calType=ical';
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
        $R34ICS->display_calendar($url, $args, true);
    }

    /**
     * Affiche l'emploi du temps de la personne concerné sauf si il s'agit d'une personne qui n'a pas de code ADE lié à son compte
     * @throws Exception
     */
    public function displayMySchedule(){

        $current_user = wp_get_current_user();
        if(isset($current_user)){
            $this->displaySchedule($current_user->code1);
            $this->displaySchedule($current_user->code2);
            $this->displaySchedule($current_user->code3);
        }
    }
}