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
    } //addInformation();

    public function deleteInformation($id ) {

        $this->bdInformation->deleteInformationBD($id);
    }


}