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
//      $title = "Test image";
//        $content = '<img src="http://wptv/wp-content/uploads/2019/04/logo_iut-1.png">';
//        $endDate = date("2019-04-26"); //annee - mois - jour<<
//
//        $this->createInformation($title, $content,$endDate);

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
        $this->viewInformation->displayInformationList($idList, $titleList,$authorList,$contentList, $creationDateList, $endDateList);
    } // informationList()

    /**
     * Verifie si la date d'expiration de l'info est dépassé et la supprime
     * @param $id
     * @param $endDate
     */
    public function endDateCheckInfo($id, $endDate){
        if($endDate < date("Y-m-d")) {
            $this->deleteInformation($id);
        }
    } //endDateCheckInfo()




   // public function changeInformation($id){
   //     $result = $this->bdInformation->getInformationbyID($id);
    //}

}