<?php
/**
 * Created by PhpStorm.
 * User: SFW
 * Date: 06/05/2019
 * Time: 11:01
 */

class Alert
{
    private $DB;
    private $view;

    /**
     * Alerte constructor.
     */
    public function __construct(){
        $this->DB = new BdAlert();
        $this->view = new ViewAlert();
    }

    public function deleteAlert($action) {
        if(isset($action)) {
            if (isset($_REQUEST['checkboxstatus'])) {
                $checked_values = $_REQUEST['checkboxstatus'];
                foreach ($checked_values as $val) {
                    $this->DB->deleteAlertDB($val);

                }
            }
            $this->view->refreshPage();
        }
    } //deleteInformation()


    public function createAlert($action,$content, $endDate){

        $this->view->displayAlertCreationForm();
        if(isset($action)) {
            $this->DB->addAlertBD($content, $endDate);
        }
    } //createAlert()

    function displayListAlerts()
    {
        $result = $this->DB->getListAlert();
        $this->view->tabHeadAlert();
        $i = 0;

        foreach ($result as $row) {
            $id = $row['ID_alert'];
            $author = $row['author'];
            $content = $row['text'];
            $creationDate = $row['creation_date'];
            $endDate = $row['end_date'];

            $this->endDateCheckAlert($id, $endDate);


            $this->view->displayAllAlert($id, $author, $content, $creationDate, $endDate, ++$i);
        }
        $this->view->endTab();
    }

    public function endDateCheckAlert($id, $endDate){
        if($endDate <= date("Y-m-d")) {
            $this->DB->deleteAlertDB($id);
        }
    } //endDateCheckInfo()


    public function modifyAlert()
    {
        $urlExpl = explode('/', $_SERVER['REQUEST_URI']);
        $id = $urlExpl[2];

        $action = $_POST['validateChange'];

        $result = $this->DB->getAlertByID($id);
        $content = $result['text'];
        $endDate = date('Y-m-d', strtotime($result['end_date']));
        $this->view->displayModifyAlertForm($content, $endDate);

        if ($action == "Valider") {
            $content = $_POST['contentInfo'];
            $endDate = $_POST['endDateInfo'];

            $this->DB->modifyAlert($id, $content, $endDate);
            $this->view->refreshPage();
        }
    }
}