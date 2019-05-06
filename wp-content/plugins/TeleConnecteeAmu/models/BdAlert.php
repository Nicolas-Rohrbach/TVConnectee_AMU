<?php
/**
 * Created by PhpStorm.
 * User: SFW
 * Date: 06/05/2019
 * Time: 11:01
 */

class BdAlert
{
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
}