<?php
/**
 * Created by PhpStorm.
 * User: Léa Arnaud
 * Date: 17/04/2019
 * Time: 11:34
 */


class BdInformation
{

    /**
     * BdInformation constructor.
     */
    public function __construct()
    {
    }

    /**
     * Ajoute une information dans la BD avec en parametre le titre, le contenu et la date d'expiration.
     * @param $title
     * @param $content
     * @param $endDate
     */
    public function addInformationDB($title, $content, $endDate)
    {
        global $wpdb;

        $current_user = wp_get_current_user();

        if (isset($current_user)) {
            $user = $current_user->user_login;
        }


        $creationDate = date('Y-m-d');


        $wpdb->query(
            $wpdb->prepare(
                "INSERT INTO `informations`(`ID_info`, `title`, `author`, `creation_date`, `end_date`, `content`)
                        VALUES (%d, %s, %s, %s, %s, %s)",
                null,
                $title,
                $user,
                $creationDate,
                $endDate,
                $content
            )
        );

    } //addInformation()

    /**
     * Supprime une information dans la BD a l'aide de son ID
     * @param $id
     */
    public function deleteInformationDB($id)
    {
        global $wpdb;
        $wpdb->query(
            $wpdb->prepare(
                "DELETE FROM `informations` WHERE ID_info = %d",
                $id
            )
        );
    } //deleteInformation()

    /**
     * Renvoie la liste de toutes les informations
     * @return array|null|object
     */
    public function getListInformation()
    {
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM informations", ARRAY_A);
        return $result;
    } //getListInformation()

    /**
     * Renvoie la liste des information crée par un utilisateur
     * @param $user
     * @return array|null|object
     */
    public function getListInformationByAuthor($user)
    {
        global $wpdb;
        $result = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM informations WHERE author = %s",
                $user
            ), ARRAY_A
        );
        return $result;
    } //getListInformationByAuthor()
}