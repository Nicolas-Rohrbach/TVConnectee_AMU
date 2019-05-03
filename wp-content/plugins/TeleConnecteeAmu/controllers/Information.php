<?php
/**
 * Created by PhpStorm.
 * User: SFW
 * Date: 17/04/2019
 * Time: 11:33
 */

class Information
{
    private $DB;
    private $view;

    /**
     * Information constructor.
     */
    public function __construct(){
        $this->DB = new BdInformation();
        $this->view = new ViewInformation();
    }

    /**
     * Permet de creer une information. EndDate etant sa date d'expiration.
     * @param $title
     * @param $content
     * @param $endDate
     */
    public function createInformation($title, $content, $endDate) {
        $this->DB->addInformationDB($title, $content, $endDate);
    } //addInformation()

    /**
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
    } //deleteInformation()

    function displayAllInformations(){
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
    }

    public function modifyInformation() {
        $urlExpl = explode('/', $_SERVER['REQUEST_URI']);
        $id = $urlExpl[2];

        $action = $_POST['validateChange'];

        $result = $this->DB->getInformationbyID($id);
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
    }

    /**
     * Verifie si la date d'expiration de l'info est dépassé et la supprime
     * @param $id
     * @param $endDate
     */
    public function endDateCheckInfo($id, $endDate){
        if($endDate <= date("Y-m-d")) {
            $this->DB->deleteInformationDB($id);
        }
    } //endDateCheckInfo()


    /**
     * Affiche la liste des informations sur la page d'accueil
     */
    public function displayInformationMain(){


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

    } // displayInformationMain()


    /**
     * Demande l'affichage du formulaire et creer l'information si il y a eu un submit.
     *
     * @param $action
     * correspond à la valeur renvoyé par l'appuie du bouton submit (cf snippet createInfo)
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
        $target_dir = $_SERVER['DOCUMENT_ROOT'] ."/wp-content/plugins/TeleConnecteeAmu/views/Media/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


        $this->view->displayUploadFileForm();
        if(isset($action)){
            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if($check !== false) {
                    echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
                }
            }
            // Check if file already exists
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }
            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 500000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
    }

}