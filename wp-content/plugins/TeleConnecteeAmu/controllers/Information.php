<?php
/**
 * Created by PhpStorm.
 * User: SFW
 * Date: 17/04/2019
 * Time: 11:33
 */

class Information
{
    private $bdInformation;
    private $viewInformation;

    /**
     * Information constructor.
     */
    public function __construct(){
        $this->bdInformation = new BdInformation();
        $this->viewInformation = new ViewInformation();
    }

    /**
     * Permet de creer une information. EndDate etant sa date d'expiration.
     * @param $title
     * @param $content
     * @param $endDate
     */
    public function createInformation($title, $content, $endDate) {
        $this->bdInformation->addInformationDB($title, $content, $endDate);
    } //addInformation()

    /**
     * Supprime une information a l'aide de son id
     * @param $id
     */
    public function deleteInformation($id) {

        $this->bdInformation->deleteInformationDB($id);
    } //deleteInformation()

    /**
     *Récupère la liste des informations et l'affiche.
     */
    public function informationList(){

//        $title = 'Evenement !';
//        $content = '<img src=http://wptv/wp-content/uploads/2019/04/totoro-poster.jpg>';
//        $endDate = date("2019-06-27");
//
//       $this->createInformation($title, $content,$endDate);

        $result = $this->bdInformation->getListInformation();

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
        $this->viewInformation->displayInformationManagement($idList, $titleList,$authorList,$contentList, $creationDateList, $endDateList);
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


       $result = $this->bdInformation->getListInformation();

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

        $this->viewInformation->displayInformationView($titleList,$contentList);

    } // displayInformationMain()

    public function informationCreationForm(){
        $this->viewInformation->displayInformationCreation();
    }
}