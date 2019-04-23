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
//        $title = "titre test";
//        $content = "yee";
//        $endDate = date("2019-06-06"); //annee - mois - jour
        $this->bdInformation->addInformationDB($title, $content, $endDate);
    } //addInformation()

    /**
     * Supprime une information a l'aide de son id
     * @param $id
     */
    public function deleteInformation($id) {

        $this->bdInformation->deleteInformationDB($id);
    } //deleteInformation()

    public function displayListInformation(){

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


            array_push($idList, $id);
            array_push($titleList, $title) ;
            array_push($authorList, $author) ;
            array_push($creationDateList, $creationDate);
            array_push($endDateList, $endDate);
            array_push($contentList,$content) ;
        }
        $this->viewInformation->displayInformationList($idList, $titleList,$authorList,$contentList, $creationDateList, $endDateList);
    }

}