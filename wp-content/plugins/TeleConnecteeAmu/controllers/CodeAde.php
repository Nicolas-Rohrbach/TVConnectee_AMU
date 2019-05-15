<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 29/04/2019
 * Time: 09:53
 * Ce controller permet de créer/modifier/supprimer des codes ADE
 */

class CodeAde extends ControllerG
{
    /**
     * Vue de CodeAde
     * @var ViewCodeAde
     */
    private $view;

    /**
     * Model de CodeAde
     * @var CodeAdeManager
     */
    private $model;

    /**
     * Constructeur de CodeAde.
     */
    public function __construct(){
        $this->view = new ViewCodeAde();
        $this->model = new CodeAdeManager();
    }

    /**
     * Lorsque le bouton est préssé, le controller appel le model pour pouvoir insérer le code écrit
     */
    public function insertCode(){
        $this->view->displayFormAddCode();
        $badCodesYears = $this->model->codeNotBound(0);
        $badCodesGroups = $this->model->codeNotBound(1);
        $badCodesHalfgroups = $this->model->codeNotBound(2);
        $badCodes = [$badCodesYears, $badCodesGroups, $badCodesHalfgroups];
        $this->view->displayUnregisteredCode($badCodes);

        $action = $_POST['addCode'];
        $code = filter_input(INPUT_POST, 'codeAde');
        $title = filter_input(INPUT_POST, 'titleAde');
        $type = filter_input(INPUT_POST, 'typeCode');

        if($action == "Valider"){
            if($this->model->addCode($type, $title, $code)){
                $this->addFile($code);
                $this->view->refreshPage();
            }
            else{
                $this->view->displayErrorDouble();
            }
        }
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
     * Ajoute un fichier via le code donné
     * @param $code     Code ADE
     * @param $tab      Configuration pour les dates de début & fin de l'année scolaire
     */
    public function addFile($code){
        $tab = $this->getTabConfig();
        $path = ABSPATH . "/wp-content/plugins/TeleConnecteeAmu/controllers/fileICS/" . $code;
        $url = 'https://ade-consult.univ-amu.fr/jsp/custom/modules/plannings/anonymous_cal.jsp?resources=' . $code . '&projectId=8&startDay=' . $tab[0] . '&startMonth=' . $tab[1] . '&startYear=' . $tab[2] . '&endDay=' . $tab[3] . '&endMonth=' . $tab[4] . '&endYear=' . $tab[5] . '&calType=ical';
        file_put_contents($path, fopen($url, 'r'));
    }

    /**
     * Supprime le fichier lié au code
     * @param $code     Code ADE
     */
    public function deleteFile($code){
        $path = ABSPATH . "/wp-content/plugins/TeleConnecteeAmu/controllers/fileICS/" . $code;
        if(! unlink($path))
            $this->addLogEvent("Le fichier ne s'est pas supprimer (chemin: ".$path.")");
    }

    /**
     * Affiche tout les codes ADE enregistrés dans un tableau où on peut soit les supprimer soit les modifier
     */
    public function displayAllCodes(){
        $results = $this->model->getAllCode();
        if(isset($results)){
            $this->view->displayAllCode($results);
        }
        else{
            $this->view->displayEmpty();
        }
    }

    /**
     * Supprime tout les codes qui sont sélectionnés
     * @param $action       Bouton de validation
     */
    public function deleteCodes($action){
        $model = new CodeAdeManager();
        if(isset($action)){
            if(isset($_REQUEST['checkboxstatus'])) {
                $checked_values = $_REQUEST['checkboxstatus'];
                foreach($checked_values as $val) {
                    $oldCode = $model->getCode($val);
                    $this->deleteFile($oldCode[0]['code']);
                    $model->deleteCode($val);
                    $this->view->refreshPage();
                }
            }
        }
    }

    /**
     * Modifie le code ADE lorsque le bouton est préssé
     */
    public function modifyCode(){
        $result = $this->model->getCode($this->getMyIdUrl());
        $this->view->displayModifyCode($result);

        $action = $_POST['modifCodeValid'];
        $title = filter_input(INPUT_POST,'modifTitle');
        $code = filter_input(INPUT_POST,'modifCode');
        $type = filter_input(INPUT_POST,'modifType');

        if($action == "Valider"){
            if($this->model->checkModify($result, $this->getMyIdUrl(), $title, $code, $type)){
                if($result[0]['code'] != $code){
                    $this->deleteFile($result[0]['code']);
                    $this->addFile($code);
                }
                $this->view->refreshPage();
            }
            else{
                $this->view->displayErrorDouble();
            }
        }
    }
}