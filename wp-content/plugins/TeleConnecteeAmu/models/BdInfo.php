<?php
/**
 * Created by PhpStorm.
 * User:
 * Date: 16/01/19
 * Time: 13:45
 */

class BdInfo
{

    public function __construct()
    {
    }

    public function insererInfo($titre, $contenu, $date){
        global $wpdb;

        $current_user = wp_get_current_user();

        if (isset($current_user)) {
            $user = $current_user->user_login;
            $user_info = get_userdata($current_user->ID);
            $role = $user_info->roles[0];
        }

        $wpdb->query(
            $wpdb->prepare(
                "INSERT INTO `informations`(`id`, `name`, `role`, `titre`, `contenu`, `date`) VALUES (%d, %s, %s, %s, %s, %s)",
                null,
                $user,
                $role,
                $titre,
                $contenu,
                $date
            )
        );

    }

    public function getInfos(){
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM informations", ARRAY_A);
        return $result;
    }

    public function getInfosUser($user){
        global $wpdb;
        $result = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM informations WHERE name = %s",
                $user
            ), ARRAY_A
        );
        return $result;
    }

    public function supprInfos($id){
        global $wpdb;
        $wpdb->query(
            $wpdb->prepare(
                "DELETE FROM `informations` WHERE id = %d",
                $id
            )
        );
    }

    public function getUneInfo($id){
        global $wpdb;
        $result = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM informations WHERE id = %d",
                $id
                ), ARRAY_A
        );
        return $result;
    }





}