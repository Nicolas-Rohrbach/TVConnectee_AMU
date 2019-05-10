<?php
/**
 * Created by PhpStorm.
 * User: SFW
 * Date: 06/05/2019
 * Time: 11:01
 */

class Alert
{
    /**
     * Alert database object
     * @var BdAlert
     */
    private $DB;

    /**
     * Alert view object
     * @var ViewAlert
     */
    private $view;

    /**
     * Alert constructor, set DB et view.
     */
    public function __construct(){
        $this->DB = new BdAlert();
        $this->view = new ViewAlert();
    }

    /**
     * Delete selected alerts.
     * @param $action
     * @see alertsManagement()
     */
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
    } //deleteAlert()


    /**
     * Create an alert.
     * @param $action
     * @param $content
     * @param $endDate
     */
    public function createAlert($action, $content, $endDate){

        $this->view->displayAlertCreationForm();
        if(isset($action)) {
            $this->DB->addAlertDB($content, $endDate);
        }
    } //createAlert()

    /**
     * Display a table with all alert, modification and delete buttons.
     */
    function alertsManagement()
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
    } //alertManagement()

    /**
     * Verify if the alert's end date is outdated.
     * @param $id
     * @param $endDate
     */
    public function endDateCheckAlert($id, $endDate){
        if($endDate <= date("Y-m-d")) {
            $this->DB->deleteAlertDB($id);
        }
    } //endDateCheckAlert()


    /**
     * Get the alert's id from the url and display the modification form.
     */
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
    } //modifyAlert()


    /**
     * Get the list of alerts and display them in the main page
     */
    public function alertMain(){

        $result = $this->DB->getListAlert();

        $contentList = array();

        foreach ($result as $row) {

            $id = $row['ID_alert'];
            $content = $row['text'];
            $endDate = date('Y-m-d',strtotime($row['end_date']));

            $this->endDateCheckAlert($id,$endDate);

            array_push($contentList,$content) ;
        }

        $this->view->displayAlertMain($contentList);

    } // alertMain()
}