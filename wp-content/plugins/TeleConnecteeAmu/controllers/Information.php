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
     * Constructeur d'information, initialise le modèle et la vue.
     */
    public function __construct(){
        $this->DB = new BdInformation();
        $this->view = new ViewInformation();
    }



    /**
     * Supprime les informations sélectionnées dans la page de gestion des informations.
     * @param $action
     */
    public function deleteInformations($action) {
        if(isset($action)) {
            if (isset($_REQUEST['checkboxstatus'])) {
                $checked_values = $_REQUEST['checkboxstatus'];
                foreach ($checked_values as $val) {
                    $res = $this->DB->getInformationByID($val);
                    $type = $res['type'];
                    if($type = "img"){
                        $this->deleteFile($val);
                    }
                    $this->DB->deleteInformationDB($val);
                }
            }
            $this->view->refreshPage();
        }
    } //deleteInformations()


    /**
     * Supprime un fichier dans le dossier Media ayant comme nom une id.
     * @param $id
     */
    public function deleteFile($id) {
        $file = glob($_SERVER['DOCUMENT_ROOT'] ."/wp-content/plugins/TeleConnecteeAmu/views/Media/{$id}.*");
        foreach ($file as $filename) {
            unlink($filename);
        }
    } //deleteFile()

    /**
     * Affiche un tableau avec toutes les informations et des boutons de modification ainsi qu'un bouton de suppression.
     * cf snippet Handle Informations
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
     * Récupère l'id de l'information depuis l'url et affiche le formulaire de modification pré-remplis.
     * cf snippet Modification Info
     */
    public function modifyInformation() {
            $urlExpl = explode('/', $_SERVER['REQUEST_URI']);
            $id = $urlExpl[2];

            $actionText = $_POST['validateChange'];
            $actionImg = $_POST['validateChangeImg'];

            $result = $this->DB->getInformationByID($id);
            $title = $result['title'];
            $content = $result['content'];
            $endDate = date('Y-m-d',strtotime($result['end_date']));
            $typeI = $result['type'];

            $this->view->displayModifyInformationForm($title,$content,$endDate,$typeI);

            if($actionText == "Modifier") {
                $title =$_POST['titleInfo'];
                $content = $_POST['contentInfo'];
                $endDate =$_POST['endDateInfo'];

                $this->DB->modifyInformation($id,$title,$content,$endDate);
                $this->view->refreshPage();
            }
            elseif($actionImg == "Modifier") {
                $contentFile = $_FILES['contentFile'];
                $content = $this->uploadFile($id,$contentFile,"","","modify");
                $title =$_POST['titleInfo'];
                $endDate =$_POST['endDateInfo'];

                if($content != null || $content != 0) {
                    $this->DB->modifyInformation($id,$title,$content,$endDate);
                    $this->view->refreshPage();
                } else {
                    echo 'modification impossible';
                }
            }
    } //modifyInformation()

    /**
     * Verifie si la date de fin est dépassée et supprime l'info si c'est le cas.
     * @param $id
     * @param $endDate
     */
    public function endDateCheckInfo($id, $endDate){
        if($endDate <= date("Y-m-d")) {
            $this->DB->deleteInformationDB($id);
        }
    } //endDateCheckInfo()


    /**
     * Affiche les informations sur la page principale (ou widget)
     * cf snippet Display Information
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
     * Affihce le formulaire de création en fonction du type d'information et ajoute l'information
     * cf snippet create info
     * @param $actionText
     * @param $actionImg
     * @param $actionTab
     * @param $title
     * @param $content
     * @param $endDate
     */
    public function insertInformation($actionText,$actionImg,$actionTab, $title, $content, $contentFile, $endDate){

        $this->view->displayInformationCreation();
        if(isset($actionText)) {
            $this->DB->addInformationDB($title, $content, $endDate,"text");
        }
        elseif (isset($actionImg)) {
            $result = $this->uploadFile(0,$contentFile, $title, $endDate,"create"); //upload le fichier avec un nom temporaire
            if($result != 0) {

                $id = $result;
                //récupère l'extension du fichier
                $_FILES['file'] = $contentFile;
                $extension_upload = strtolower(  substr(  strrchr($_FILES['file']['name'], '.')  ,1)  );

                //renomme le fichier avec l'id de l'info
                rename($_SERVER['DOCUMENT_ROOT'] ."/wp-content/plugins/TeleConnecteeAmu/views/Media/temporary.{$extension_upload}",
                    $_SERVER['DOCUMENT_ROOT'] ."/wp-content/plugins/TeleConnecteeAmu/views/Media/{$id}.{$extension_upload}");

                //modifie le contenu de l'information pour avoir le bon lien de l'image
                $content = '<img src="http://wptv/wp-content/plugins/TeleConnecteeAmu/views/Media/'.$id.'.'.$extension_upload.'">';
                $result = $this->DB->getInformationByID($id);
                $title = $result['title'];
                $endDate = date('Y-m-d',strtotime($result['end_date']));
                $this->DB->modifyInformation($id, $title, $content, $endDate);
            }
        }
        elseif (isset($actionTab)) {
            echo 'pas encore implementé';
        }
    } //insertInformation()

    public function uploadFile($id, $file, $title, $endDate, $action){
        if($action == "create"){
            $id = "temporary";
        }
        elseif ($action == "modify"){
            $this->deleteFile($id);
        }
        else{ echo "il y a une erreur dans l'appel de la fonction";}

        $_FILES['file'] = $file;
        $maxsize = 5000000;
        if ($_FILES['file']['error'] > 0) echo "Erreur lors du transfert <br>";
        if ($_FILES['file']['size'] > $maxsize) echo "Le fichier est trop volumineux <br>";

        $extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
        $extension_upload = strtolower(  substr(  strrchr($_FILES['file']['name'], '.')  ,1)  );
        if ( in_array($extension_upload,$extensions_valides) ) echo "Extension correcte <br>";

        $nom =  $_SERVER['DOCUMENT_ROOT'] ."/wp-content/plugins/TeleConnecteeAmu/views/Media/{$id}.{$extension_upload}";
        $resultat = move_uploaded_file($_FILES['file']['tmp_name'],$nom);

        if ($resultat){
            echo "Transfert réussi <br>";
            if($action == "create"){
                $result = $this->DB->addInformationDB($title,"temporary content",$endDate, "img");
                return $result;
            }
            elseif ($action == "modify"){
                $content = '<img src="http://wptv/wp-content/plugins/TeleConnecteeAmu/views/Media/' . $id . '.' . $extension_upload . '">';
                return $content;
            }
        }
        else {
            echo "le fichier n'as pas été upload <br>";
            return 0;
        }
    }//uploadFile()


}