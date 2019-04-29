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
     * Supprime une information a l'aide de son id
     * @param $id
     */
    public function deleteInformation($id) {

        $this->DB->deleteInformationDB($id);
    } //deleteInformation()

    /**
     *Affiche la liste des informations et modifie ou supprime l'info selectionné.
     *
     */
    public function informationList($actionDelete, $actionChange, $infoSelectedID){
        $result = $this->DB->getListInformation();

        $idList = array();
        $titleList = array();
        $authorList = array();
        $creationDateList = array();
        $endDateList = array();
        $contentList = array();

        foreach ($result as $row) {

            $id = $row['ID_info'];
            $title = $row['title'];
            $author = $row['author'];
            $creationDate = date('Y-m-d',strtotime($row['creation_date']));
            $endDate = date('Y-m-d',strtotime($row['end_date']));
            $content = $row['content'];

            $this->endDateCheckInfo($id,$endDate);

            array_push($idList, $id);
            array_push($titleList, $title) ;
            array_push($authorList, $author) ;
            array_push($creationDateList, $creationDate);
            array_push($endDateList, $endDate);
            array_push($contentList,$content) ;
        }

        $this->view->displayInformationManagement($idList, $titleList,$authorList,$contentList, $creationDateList, $endDateList);

        if(isset($actionDelete)){
            $this->deleteInformation($infoSelectedID);
            $this->view->refreshPage();
        }
        elseif (isset($actionChange)) {
            echo 'modifier'.$infoSelectedID;
        }
    } // informationList()

    /**
     * Verifie si la date d'expiration de l'info est dépassé et la supprime
     * @param $id
     * @param $endDate
     */
    public function endDateCheckInfo($id, $endDate){
        if($endDate <= date("Y-m-d")) {
            $this->deleteInformation($id);
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
     * @param $endDates
     */
    public function insertInformation($action, $title, $content, $endDate){
        $this->view->displayInformationCreation();
        if(isset($action)){
            $this->createInformation($title, $content, $endDate);
        }
    } //insertInformation()

}