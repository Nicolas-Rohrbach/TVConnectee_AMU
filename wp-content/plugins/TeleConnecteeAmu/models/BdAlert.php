<?php
/**
 * Created by PhpStorm.
 * User: SFW
 * Date: 06/05/2019
 * Time: 11:01
 */

class BdAlert
{
    /**
     * @var
     */
    private static $bdd;

    /**
     * Set the database.
     */
    private static function setBdd(){
        global $wpdb;
        self::$bdd = new PDO('mysql:host='.$wpdb->dbhost.'; dbname='.$wpdb->dbname, $wpdb->dbuser, $wpdb->dbpassword);
        self::$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    } //setBdd()

    /**
     * Return the database.
     * @return mixed
     */
    protected function getBdd(){
        if (self:: $bdd == null)
            self::setBdd();
        return self::$bdd;
    } //getBdd()


    /**
     * Add an alert in the database with today date and current user.
     * @param $content
     * @param $endDate
     */
    public function addAlertDB($content, $endDate){
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
    } //addAlertDB()

    /**
     * Delete the alert in database.
     * @param $id
     */
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

    /**
     * Return the list of alerts.
     * @return array|null|object
     */
    public function getListAlert()
    {
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM alerts", ARRAY_A);
        return $result;
    } //getListAlert()


    /**
     * Return the alert corresponding to the ID
     * @param $id
     * @return array|null|object|void
     */
    public function getAlertByID($id) {
        global $wpdb;
        $result = $wpdb->get_row('SELECT * FROM alerts WHERE ID_alert ="'.$id.'"',ARRAY_A );
        return $result;
    } //getAlertByID()

    /**
     * Modify the alert in the database.
     * @param $id
     * @param $content
     * @param $endDate
     */
    public function modifyAlert($id, $content, $endDate){
        $req = $this->getBdd()->prepare('UPDATE alerts SET text=:content, end_date=:endDate
                                         WHERE ID_alert=:id');
        $req->bindParam(':id',$id);
        $req->bindParam(':content',$content);
        $req->bindParam(':endDate',$endDate);

        $req->execute();
    } //ModifyAlert()



}