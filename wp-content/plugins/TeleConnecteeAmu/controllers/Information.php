<?php
/**
 * Created by PhpStorm.
 * User: SFW
 * Date: 17/04/2019
 * Time: 11:33
 */

class Information
{
    /**
     * Information database object
     * @var BdInformation
     */
    private $DB;
    /**
     * Information view object
     * @var ViewInformation
     */
    private $view;

    /**
     * Information constructor, set the database and the view.
     */
    public function __construct(){
        $this->DB = new BdInformation();
        $this->view = new ViewInformation();
    }

    /**
     * Create an information
     * @param $title
     * @param $content
     * @param $endDate
     */
    public function createInformation($title, $content, $endDate) {
        $this->DB->addInformationDB($title, $content, $endDate);
    } //createInformation()

    /**
     * Delete selected informations
     * @param $action
     */
    public function deleteInformations($action) {
        if(isset($action)) {
            if (isset($_REQUEST['checkboxstatus'])) {
                $checked_values = $_REQUEST['checkboxstatus'];
                foreach ($checked_values as $val) {
                    $this->DB->deleteInformationDB($val);

                }
            }
            $this->view->refreshPage();
        }
    } //deleteInformations()

    /**
     * Get the list of information and display the management page
     */
    function informationManagement(){
        $result = $this->DB->getListInformation();
        $this->view->tabHeadInformation();
        $i = 0;

        foreach ($result as $row){
            $id = $row['ID_info'];
            $title = $row['title'];
            $author = $row['author'];
            $content = $row['content'];
            $creationDate = $row['creation_date'];
            $endDate = $row['end_date'];

            $this->view->displayAllInformation($id, $title, $author, $content, $creationDate, $endDate, ++$i);
        }
        $this->view->endTab();
    } // informationManagement()

    /**
     * Get the id with the URL and display the modification form
     */
    public function modifyInformation() {
            $urlExpl = explode('/', $_SERVER['REQUEST_URI']);
            $id = $urlExpl[2];

            $action = $_POST['validateChange'];

            $result = $this->DB->getInformationByID($id);
            $title = $result['title'];
            $content = $result['content'];
            $endDate = date('Y-m-d',strtotime($result['end_date']));

            $this->view->displayModifyInformationForm($title,$content,$endDate);

            if($action == "Valider") {
                $title =$_POST['titleInfo'];
                $content = $_POST['contentInfo'];
                $endDate =$_POST['endDateInfo'];

                $this->DB->modifyInformation($id,$title,$content,$endDate);
                $this->view->refreshPage();
            }
    } //modifyInformation()

    /**
     * Check if the end date is outdated and delete the information if it is
     * @param $id
     * @param $endDate
     */
    public function endDateCheckInfo($id, $endDate){
        if($endDate <= date("Y-m-d")) {
            $this->DB->deleteInformationDB($id);
        }
    } //endDateCheckInfo()


    /**
     * Diplay the information carousel in the main page
     */
    public function informationMain(){


       $result = $this->DB->getListInformation();

        $titleList = array();
        $contentList = array();

        foreach ($result as $row) {

            $id = $row['ID_info'];
            $title = $row['title'];
            $content = $row['content'];
            $endDate = date('Y-m-d',strtotime($row['end_date']));

            $this->endDateCheckInfo($id,$endDate);

            array_push($titleList, $title) ;
            array_push($contentList,$content) ;
        }

        $this->view->displayInformationView($titleList,$contentList);

    } // informationMain()


    /**
     * Display the creation form and add the information
     * @param $action
     * correspond to the data sent with the submit button (cf snippet createInfo)
     * @param $title
     * @param $content
     * @param $endDate
     */
    public function insertInformation($action,$actionUpload, $title, $content, $endDate){

        $this->view->displayInformationCreation();
        if(isset($action)) {
            $this->createInformation($title, $content, $endDate);
        }
    } //insertInformation()

    public function uploadFile($action){
        $this->view->displayFormUpload();
        $id = 53;

        $maxsize = 5000000;
        if(isset($action)){
            if ($_FILES['file']['error'] > 0) echo "Erreur lors du transfert <br>";
            if ($_FILES['file']['size'] > $maxsize) echo "Le fichier est trop gros <br>";


            $extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
            $extension_upload = strtolower(  substr(  strrchr($_FILES['file']['name'], '.')  ,1)  );
            if ( in_array($extension_upload,$extensions_valides) ) echo "Extension correcte <br>";

            $nom =  $_SERVER['DOCUMENT_ROOT'] ."/wp-content/plugins/TeleConnecteeAmu/views/Media/{$id}.{$extension_upload}";
            $resultat = move_uploaded_file($_FILES['file']['tmp_name'],$nom);
            if ($resultat){
                echo "Transfert réussi <br>";
                $content = '<img src="http://wptv/wp-content/plugins/TeleConnecteeAmu/views/Media/'.$id.'.'.$extension_upload.'">';
                $this->DB->addInformationDB("test upload",$content,date("2019-07-07"));
            }
            else {
                echo "erreur dans le transfert <br>";

            }



        }
    }

}