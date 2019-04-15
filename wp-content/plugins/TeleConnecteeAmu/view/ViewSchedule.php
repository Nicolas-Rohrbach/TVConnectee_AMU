<?php
/**
 * Created by PhpStorm.
 * User: r17000292
 * Date: 30/01/2019
 * Time: 11:54
 */

class ViewSchedule
{

    public function displayTitle($string) {
        echo '<h1 class="text-center text-black-50">'.$string. '</h1>';
    }

    public function displayName($current_user) {
        echo '<h1 class="text-center text-black-50">'.$current_user->display_name. '</h1>';
    }

    public function displayHome($current_user) {
        echo '<h1 class="text-center text-black-50"> Bienvenue '.$current_user->display_name.' sur la tv connectée ! </h1>';
    }

    public function displayTimetable($value,$startDay,$startMonth,$startYear,$endDay,$endMonth,$endYear) {
        echo '<div id="ref">';
        echo do_shortcode('[ics_calendar url="https://ade-consult.univ-amu.fr/jsp/custom/modules/plannings/anonymous_cal.jsp?resources='.$value.'&projectId=8&startDay='.$startDay.'&startMonth='.$startMonth.'&startYear='.$startYear.'&endDay='.$endDay.'&endMonth='.$endMonth.'&endYear='.$endYear.'&calType=ical" view="list"]');
        echo '</div>';
    }
}