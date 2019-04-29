<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 18/04/2019
 * Time: 08:55
 */

session_start();

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

echo json_encode(!is_user_logged_in());