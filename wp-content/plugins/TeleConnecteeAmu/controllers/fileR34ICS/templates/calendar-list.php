<?php
/*
Version: 1.5.7
Author: Room 34 Creative Services, LLC
Author URI: http://room34.com et Gwenaêl ROUX
License: GPL2
Text Domain: r34ics
Domain Path: /i18n/languages/
Description: Recupère le format ical et l'affiche sous forme de tableau
on n'affiche pas les cours qui ont déja eu lieu en utilisant un timestamp de la date et heure actuel
Grace au timestamp on surligne en vert les cours qui ont lieu au moment du visionnage
Possibilite de splitté le tableau en un nombre d'évèment définis (possibilte de developpement pour creer un slide avec les tableau)
Possibilite de parametrer le nombre d'évement à afficher
*/

// Require object
if (empty($ics_data)) { return false; }

global $R34ICS;
global $wp_locale;

$days_of_week = $R34ICS->get_days_of_week();
$start_of_week = get_option('start_of_week', 0);

// Not currently used in this template; uncomment if needed in a future update
//$today = date_i18n('Ymd', current_time('timestamp'));

$date_format = !empty($args['format']) ? strip_tags($args['format']) : 'l, F j';
?>

<section class="ics-calendar<?php if (!empty($args['hidetimes'])) { echo ' hide_times'; } ?>">

    <?php
    // Title and description
    if (!empty($ics_data['title'])) {
        ?>
        <h2 class="ics-calendar-title"><?php echo $ics_data['title']; ?></h2>
        <?php
    }
    if (!empty($ics_data['description'])) {
        ?>
        <p class="ics-calendar-description"><?php echo $ics_data['description']; ?></p>
        <?php
    }

    // Empty calendar message
    if (empty($ics_data['events'])) {
        ?>
        <p class="ics-calendar-error"><?php _e('No events found.', 'R35ICS'); ?></p>
        <?php
    }

    // Display calendar
    else {
        ?>

        <?php
        // Build monthly calendars
        $i = 0;
        foreach (array_keys((array)$ics_data['events']) as $year) {
            for ($m = 1; $m <= 12; $m++) {
                $month = $m < 10 ? '0' . $m : '' . $m;
                $ym = $year . $month;
                if ($ym < $ics_data['earliest']) { continue; }
                if ($ym > $ics_data['latest']) { break(2); }
                $first_date = mktime(0,0,0,$month,1,$year);
                $month_label = ucwords(date_i18n('F Y', $first_date));

                // Build month's calendar
                if (isset($ics_data['events'][$year][$month])) {

                    foreach ((array)$ics_data['events'][$year][$month] as $day => $day_events) {
                        $date = mktime(0,0,0,$month,$day,$year);
                        $date_label = ucwords(date_i18n('l j F Y', $date));

                        ?>
                        <!-- 							<h3><?php echo $date_label; ?></h3> -->

                        <?php
                        $nbevents = 0;
                        $nboccurence = 0;
                        foreach ((array)$day_events as $time => $events) {
                            $all_day_indicator_shown = false;
                            foreach ((array)$events as $event) {

                                if(($nboccurence == 0 || $nbevents == 20)){
                                    if($nbevents == 20){
                                        $nbevents = 0;
                                        ?>
                                        </tbody>
                                        </table>
                                        <?php
                                    }
                                    ?>
                                    <table class="table">
                                    <thead class="bg-primary">
                                    <tr>
                                        <th scope="col" class="text-light" width="20%">Horaire</th>
                                        <th scope="col" class="text-light" width="35%">Cours</th>
                                        <th scope="col" class="text-light" width="25%">Enseignant</th>
                                        <th scope="col" class="text-light" width="20%">Salle</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                }

                                ++$nboccurence;
                                // et on supprime cours qui ont déja eu lieu
                                $heure = date("H:i");

                                if (!(date("H:i",strtotime($event['fin'])) <= $heure) ){
                                    if(date("H:i",strtotime($event['deb'])) <= $heure && $heure < date("H:i",strtotime($event['fin']))){
                                        ++$nbevents;
                                        ?>
                                        <tr class="alert alert-success" scope="row">
                                        <?php
                                    }
                                    else if(date("H:i",strtotime($event['deb'])) > $heure) {
                                        ++$nbevents;
                                        ?>
                                        <tr scope="row">
                                        <?php
                                    }
                                    if ($time == 'all-day') {
                                        if (!$all_day_indicator_shown) {
                                            ?>
                                            <dt class="all-day-indicator"><?php _e('All Day', 'R35ICS'); ?></dt>
                                            <?php
                                            $all_day_indicator_shown = true;
                                        }
                                        ?>
                                        <td class="event">
                                            <span class="title"><?php echo str_replace('/', '/<wbr />',$event['label']); ?></span>
                                            <?php
                                            if (!empty($event['sublabel'])) {
                                                ?>
                                                <span class="sublabel"><?php echo str_replace('/()', '/<wbr />',$event['sublabel']); ?></span>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <?php
                                    }
                                    else {

                                        if (!empty($event['start'])) {
                                            ?>
                                            <td width="20%"><?php

                                                echo $event['start'];

                                                if (!empty($event['end'])) {
                                                    ?>
                                                    <span class="time">&#8211; <?php echo $event['end']; ?></span>
                                                    <?php
                                                }
                                                ?></td>
                                            <?php
                                        }
                                        ?>
                                        <td width="35%">
                                            <span class="title"><?php echo str_replace('/', '/<wbr />',$event['label']); ?></span>
                                            <?php
                                            if (!empty($event['sublabel'])) {
                                                ?>
                                                <span class="sublabel"><?php
                                                    if (empty($event['start']) && !empty($event['end'])) {
                                                        ?>
                                                        <span class="carryover">&#10554;</span>
                                                        <?php
                                                    }
                                                    echo str_replace('/', '/<wbr />',$event['sublabel']);
                                                    ?></span>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td width="25%">
												<span class="sublabel"><?php $des = $event['description'];
                                                    $des = substr($des,0,-29);
                                                    echo $des;	?></span>
                                        </td >
                                        <td width="20%">
                                            <span><?php echo str_replace('/', '/<wbr />',$event['location']); ?></span>
                                        </td>
                                        <?php
                                    }
                                    ?>
                                    </tr>
                                    <?php

                                }
                                if ($nbevents == 5){
                                    break(2);
                                }
                            }
                        }
                        ?>
                        </tbody>
                        </table>
                        <?php
                        break(3);

                    }
                    ?>

                    </div>
                    <?php
                }
            }
        }
    }
    ?>
</section>