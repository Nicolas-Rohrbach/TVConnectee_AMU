<?php
/**
 * Created by PhpStorm.
 * User: g17018832
 * Date: 27/02/19
 * Time: 16:53
 */

try {
    $base = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME, DB_USER, DB_PASSWORD);
}
catch(exception $e) {
    die('Erreur '.$e->getMessage());
}
?>