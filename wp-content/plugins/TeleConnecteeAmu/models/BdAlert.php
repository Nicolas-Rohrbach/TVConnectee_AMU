<?php
/**
 * Created by PhpStorm.
 * User: SFW
 * Date: 06/05/2019
 * Time: 11:01
 */

class BdAlert
{
    private static $bdd;

    private static function setBdd()
    {
        global $wpdb;
        self::$bdd = new PDO('mysql:host='.$wpdb->dbhost.'; dbname='.$wpdb->dbname, $wpdb->dbuser, $wpdb->dbpassword);
        self::$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }
    protected function getBdd()
    {
        if (self:: $bdd == null)
            self::setBdd();
        return self::$bdd;
    }


    public function addAlertBD($content,$endDate){
        global $wpdb;

        $current_user = wp_get_current_user();

        if (isset($current_user)) {
            $user = $current_user->user_login;
        }

        $creationDate = date('Y-m-d');

        $wpdb->query(
            $wpdb->prepare(
                "INSERT INTO `alerts`(`ID_alert`,`author`, `text`, `creation_date`, `end_date` )
                        VALUES (%d, %s, %s, %s, %s)",
                null,
                $user,
                $content,
                $creationDate,
                $endDate
            )
        );
    }

    public function deleteAlertDB($id)
    {
        global $wpdb;
        $wpdb->query(
            $wpdb->prepare(
                "DELETE FROM `alerts` WHERE ID_alert = %d",
                $id
            )
        );
    } //deleteAlertDB()

    public function getListAlert()
    {
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM alerts", ARRAY_A);
        return $result;
    } //getListAlert()


    public function getAlertbyID($id) {
        global $wpdb;
        $result = $wpdb->get_row('SELECT * FROM alerts WHERE ID_alert ="'.$id.'"',ARRAY_A );
        return $result;
    } //getAlertbyID()

    public function modifyAlert($id,$content,$endDate)
    {
        $req = $this->getBdd()->prepare('UPDATE alerts SET text=:content, end_date=:endDate
                                         WHERE ID_alert=:id');
        $req->bindParam(':id',$id);
        $req->bindParam(':content',$content);
        $req->bindParam(':endDate',$endDate);

        $req->execute();
    }



}