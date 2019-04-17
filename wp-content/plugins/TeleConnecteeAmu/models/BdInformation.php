<?php
/**
 * Created by PhpStorm.
 * User: Léa Arnaud
 * Date: 17/04/2019
 * Time: 11:34
 */
//setlocale(LC_TIME, 'fra_fra');

class BdInformation
{

    /**
     * BdInformation constructor.
     */
    public function __construct()
    {
    }

    public function addInformation($title, $content, $endDate){
        global $wpdb;

        $current_user = wp_get_current_user();

        if (isset($current_user)) {
            $user = $current_user->user_login;
        }
        $creationDate = date('Y-m-d H:i:s');

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

    }
}