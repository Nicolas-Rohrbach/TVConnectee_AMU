<?php
/**
 * Created by PhpStorm.
 * User: SFW
 * Date: 06/05/2019
 * Time: 11:01
 */

class Alert
{
    private $DB;
    private $view;

    /**
     * Alerte constructor.
     */
    public function __construct(){
        $this->DB = new BdAlert();
        $this->view = new ViewAlert();
    }

    public function createAlert($content, $endDate) {
        $this->DB->addAlertBD($content, $endDate);
    } //createAlert()



}