<?php
/**
 * Created by PhpStorm.
 * User: Léa Arnaud
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
            elseif($actionImg == "Modifier") { //si il s'agit d'une modification d'affiche
                $contentFile = $_FILES['contentFile'];

                $title =$_POST['titleInfo'];
                $endDate =$_POST['endDateInfo'];
                if($_FILES['contentFile']['size'] != 0) {    //si l'image est modifié
                    $contentNew = $this->uploadFile($contentFile,"modify","img",$id);
                    if($contentNew != null || $contentNew != 0) {
                        $this->DB->modifyInformation($id,$title,$contentNew,$endDate);
                        $this->view->refreshPage();
                    }
                }
                else { // si le texte et/ou la date de fin est modifié
                    $this->DB->modifyInformation($id,$title,$content,$endDate);
                    $this->view->refreshPage();
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
     * Affiche le formulaire de création en fonction du type d'information et ajoute l'information
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
        if(isset($actionText)) { // si c'est une création de texte
            $this->DB->addInformationDB($title, $content, $endDate,"text");
        }
        elseif (isset($actionImg)) { // si c'est une création d'affiche
            //upload le fichier avec un nom temporaire
            $result = $this->uploadFile($contentFile,"create", "img", 0, $title, $endDate);
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
        elseif (isset($actionTab)) { //si c'est une création d'un tableau de note
            $result = $this->uploadFile($contentFile,"create", "tab", 0, $title, $endDate);
            if($result != 0) {
                $id = $result;
                //récupère l'extension du fichier
                $_FILES['file'] = $contentFile;
                $extension_upload = strtolower(  substr(  strrchr($_FILES['file']['name'], '.')  ,1)  );

                //renomme le fichier avec l'id de l'info
                rename($_SERVER['DOCUMENT_ROOT'] ."/wp-content/plugins/TeleConnecteeAmu/views/Media/temporary.{$extension_upload}",
                    $_SERVER['DOCUMENT_ROOT'] ."/wp-content/plugins/TeleConnecteeAmu/views/Media/{$id}.{$extension_upload}");

                //modifie le contenu de l'information pour avoir le bon lien de l'image
                $content = $id.'.'.$extension_upload;
                $result = $this->DB->getInformationByID($id);
                $title = $result['title'];
                $endDate = date('Y-m-d',strtotime($result['end_date']));
                $this->DB->modifyInformation($id, $title, $content, $endDate);
            }

        }
    } //insertInformation()


    /**
     * Upload un fichier sur le serveur, créer l'information avec un contenu temporaire
     * ou renvoie le nouveau contenu quand il s'agit d'une modification.
     * @param $id
     * @param $file
     * @param $title
     * @param $endDate
     * @param $action
     * @return int|string
     */
    public function uploadFile($file, $action, $type, $id =0, $title="", $endDate=""){
        if($action == "create"){ //si la fonction a été appelée pour la création d'une info
            $id = "temporary"; //met un id temporaire pour le nom du fichier
        }
        elseif ($action == "modify"){ //si la fonction a été appelée pour la modification d'une info
            $this->deleteFile($id); // efface le fichier correspondant a l'info modifié
        }
        else{ echo "il y a une erreur dans l'appel de la fonction";}

        $_FILES['file'] = $file;
        $maxsize = 5000000; //5Mo
        if ($_FILES['file']['error'] > 0) echo "Erreur lors du transfert <br>";
        if ($_FILES['file']['size'] > $maxsize) echo "Le fichier est trop volumineux <br>";

        if($type == "img") $extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
        if($type == "tab") $extensions_valides = array( 'xls' , 'xlsx' );

        $extension_upload = strtolower(  substr(  strrchr($_FILES['file']['name'], '.')  ,1)  );
        if ( in_array($extension_upload,$extensions_valides) ) echo "Extension correcte <br>";

        $nom =  $_SERVER['DOCUMENT_ROOT'] ."/wp-content/plugins/TeleConnecteeAmu/views/Media/{$id}.{$extension_upload}";
        $resultat = move_uploaded_file($_FILES['file']['tmp_name'],$nom);

        if ($resultat){
            echo "Transfert réussi <br>";
            if($action == "create"){
                if($type == "img") {
                    // Ajoute dans la BD avec un contenu temporaire
                    $result = $this->DB->addInformationDB($title,"temporary content",$endDate, "img");
                    return $result;
                }
                elseif ($type == "tab") {
                    // Ajoute dans la BD avec un contenu temporaire
                    $result = $this->DB->addInformationDB($title,"temporary content",$endDate, "tab");
                    return $result;
                }else{echo "le type d'information n'est pas le bon";}
            }
            elseif ($action == "modify"){
                if($type == "img") {
                    //renvoie le nouveau contenu de l'info
                    $content = '<img src="http://wptv/wp-content/plugins/TeleConnecteeAmu/views/Media/' . $id . '.' . $extension_upload . '">';
                    return $content;
                }
                elseif ($type == "tab"){
                    //renvoie le nouveau contenu de l'info
                    $content =  $id .'.'. $extension_upload;
                    return $content;
                }else{echo "le type d'information n'est pas le bon";}
            }
        }
        else {
            echo "le fichier n'as pas été upload <br>";
            return 0;
        }
    }//uploadFile()

}