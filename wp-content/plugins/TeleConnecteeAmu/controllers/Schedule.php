<?php
/**
 * Created by PhpStorm.
 * User: r17000292
 * Date: 06/02/2019
 * Time: 17:23
 */

class Schedule
{
    private $url;


    public function __construct(){
        $this->url = new ViewSchedule();
    }

    /**
     * Affiche l'emploi du temps de la personne concerné sauf si il s'agit d'un admin ou d'un(e) secrétaire
     * @throws Exception
     */
    public function displayMySchedule() {
        ### Initialisation
        $planning = new Planning();

        ## Récupération de la configuration
        $conf = $planning->getConf();
        $resources = $planning->getResources();
        $displays = $planning->getDisplays();
        $dimensions = $planning->getDimensions();

        # Récupération de la configuration personnalisée
        $custom_conf = $planning->getCustomConf();

        ### On commence à noter les paramètres qui seront nécessaires pour la génération de l’image
        $identifier = $planning->getIdentifier();

        # On prépare l’export en iCal
        list($startDay, $startMonth, $startYear) = explode('/', gmdate('d\/m\/Y', $conf['FIRST_WEEK']));
        list($endDay, $endMonth, $endYear) = explode('/', gmdate('d\/m\/Y', intval($conf['FIRST_WEEK'] + ($conf['NB_WEEKS'] * 7 * 24 * 3600))));



        # Cherche le code ADE dans le dossier data/ressources.yaml en fonction de l'utilisateur connecté et demande à afficher l'emploi du temps
        $current_user = wp_get_current_user();

        # Si la personne connectée est un étudiant, on cherche à savoir si il est en Alternance ou en initiale puis on cherche son code ADE dans le dossier ressources.yaml
        if($current_user->roles[0] == "etudiant"){
            if($current_user->alternant){
                $typeEtud = 'Alternance';
                $groupe = $current_user->annee;
            }
            else {
                $typeEtud = 'Initial';
                $groupe = "TD".$current_user->groupe;
            }

            #On parcour le fichier ressources.yaml, en faissant des foreach car ceux sont des tableaux dans des tableaux
            foreach ($resources as $group => $entities) {
                if($group == $typeEtud) {
                    foreach ($entities as $annee => $values){
                        if ($annee == $current_user->annee) {
                            foreach($values as $value => $key) {
                                if ($key == $groupe) {
                                    $this->url->displayName($current_user);
                                    $this->url->displayTimetable($value,$startDay,$startMonth,$startYear,$endDay,$endMonth,$endYear);
                                }
                            }
                        }
                    }
                }
            }
        }

        #Si un professeur est connecté
        else if ($current_user->role == "enseignant") {
            foreach ($resources as $group => $entities) {
                if($group == "Enseignant") {
                    foreach ($entities as $key => $value) {
                        if($current_user->display_name == $value) {
                            $this->url->displayName($current_user);
                            $this->url->displayTimetable($value,$startDay,$startMonth,$startYear,$endDay,$endMonth,$endYear);
                        }
                    }
                }
            }
        }

        #Si c'est la télévision
        else if ($current_user->role == "television") {
            foreach ($resources as $group => $entities) {
                if ($group == "Initial") {
                    foreach ($entities as $key => $values) {
                        if($current_user->annee == $key) {
                            foreach($values as $value => $val) {
                                if ("General ".$current_user->annee == $val) {
                                    if($current_user->annee == 1) {
                                        $this->url->displayTitle("Première année");
                                    }
                                    else if($current_user->annee == 2) {
                                        $this->url->displayTitle("Deuxième année");
                                    }
                                    $this->url->displayTimetable($value,$startDay,$startMonth,$startYear,$endDay,$endMonth,$endYear);                                }
                            }
                        }
                    }
                }
            }
        }

        #Si la personne n'est pas connectée ou si il s'agit d'un Admin ou d'une secrétaire
        else {
            $this->url->displayHome($current_user);
        }
    }

}