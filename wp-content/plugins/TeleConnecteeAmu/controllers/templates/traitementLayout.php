<?php
/**
 * Created by PhpStorm.
 * User: g17018832
 * Date: 06/02/2019
 * Time: 14:53
 */

include "B.php";

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

if($r1 = $base->query('INSERT INTO Layout (NUM_UTI) VALUES ( \'' . 1 . '\')') == false){
    exit("false");
}
$lastid = $base->lastInsertId();


for( $i = 1; $i <= $_POST['nbLigne']; ++$i){

    if($r2 = $base->query('INSERT INTO LIGNE_LAYOUT(NUM_LAYOUT, NUM_LIGNE, HAUTEUR) 
                                  VALUES (' . $lastid . ' , '. $i .' , ' . $_POST['selectDimensionl' . $i] . ' ) ') == false){
        exit("false");
    }

    for($j = 1; $j <= $_POST['selectColonne' . $i]; ++$j){
        if($r3 = $base->query('INSERT INTO COLONNE_LAYOUT (NUM_LAYOUT, NUM_COLONNE, LARGEUR, NUM_LIGNE) 
                                      VALUES (' . $lastid . ' , '. $j .' , ' . $_POST['selectLargeurl' . $i . 'c' . $j] . ' , ' . $i .' ) ') == false){
            exit("false");
        }
    }
}

echo json_encode(true);






