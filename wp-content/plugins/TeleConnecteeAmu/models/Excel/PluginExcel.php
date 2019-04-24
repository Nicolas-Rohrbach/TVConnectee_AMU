<?php
require_once("PHPExcel/IOFactory.php");


function chaine_aleatoire($chaine = 'azertyuiopqsdfghjklmwxcvbn123456789')
{
    $nb_lettres = strlen($chaine) - 1;
    $generation = '';
    for($i=0; $i < 8; $i++)
    {
        $pos = mt_rand(0, $nb_lettres);
        $car = $chaine[$pos];
        $generation .= $car;
    }
    return $generation;
}

function excelEtudiant($actionEtud){
    $bduser = new BdUser();

    global $wpdb;
    $doubles = array();
    $con = mysqli_connect($wpdb->dbhost, $wpdb->dbuser, $wpdb->dbpassword, $wpdb->dbname);
	
    if(isset($actionEtud)) {
        $extension = end(explode(".", $_FILES["excelEtud"]["name"]));    // For getting Extension of selected file
        $allowed_extension = array("xls", "xlsx", "csv");                // allowed extension
        if (in_array($extension, $allowed_extension))                    // check selected file extension is present in allowed extension array
        {
            $file = $_FILES["excelEtud"]["tmp_name"];                    // getting temporary source of excel file
            $objPHPExcel = PHPExcel_IOFactory::load($file);              // create object of PHPExcel library by using load() method and in load method define path of selected file

            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                if(mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(0, 1)->getValue()) == "Prenom" &&
                    mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(1, 1)->getValue()) == "Nom" &&
                    mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(2, 1)->getValue()) == "Numero Ent" &&
                    mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(3, 1)->getValue()) == "email" &&
                    mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(4, 1)->getValue()) == "Annee" &&
                    mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(5, 1)->getValue()) == "Groupe" &&
                    mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(6, 1)->getValue()) == "Demi-groupe")
                {
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $prenom = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
                        $name = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
                        $mdp = chaine_aleatoire() ;
                        $mdpMd5 = md5($mdp) ;
                        $nicename = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(2, $row)->getValue());
                        $email = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(3, $row)->getValue());
                        $display = "$prenom" . " $name" ;
                        $annee = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(4, $row)->getValue());
                        $groupe = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(5, $row)->getValue());
                        $demigroupe = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(6, $row)->getValue());

                        if($bduser->insertEtudiant($name, $mdpMd5, $nicename, $email, $display, $annee, $groupe, $demigroupe, $prenom)) {
                            $message = "Bonjour, vous avez été inscrit sur le site de la Télé Connecté de votre département en temps qu'étudiant. <br> Sur ce site, vous aurez accès à votre emploie du temps, à vos notes et aux informations concernant votre scolarité. <br>" ;
                            $message2 = $message . "Votre identifiant est " . $nicename . " et votre mot de passe est " . $mdp . ". <br>"  ;
                            $message3 = $message2 . "Pour vous connecter, rendez vous sur le site : tv-connectee-amu.alwaysdata.net ." . "<br> Nous vous souhaitons une bonne expérience sur notre site. <br>" ;
                            //mail($email, "Inscription à la télé-connecté", $message3);
                        }
                        else {
                            array_push($doubles, $nicename);
                        }
                    }
                }
                else {
                    echo ('<p> Vous utilisez un mauvais fichier excel/ ou vous avez changé le nom des colonnes </p>');
                }
            }
            if(isset($doubles)) {
                foreach ($doubles as $double => $value) {
                    echo('<p> L\'inscription a échouée pour '.$value.', vérifié si le login ou l\'adresse mail n\'a pas déjà était utilisé </p> <br/>');
                }
            }
            else {
                echo("Votre inscription a été validé.");
            }
        }
        else {
            echo("Extension invalide."); //if non excel file
        }
    }
}

function excelProf($actionProf)
{
    $bduser = new BdUser();

    global $wpdb;
    $doubles = array();
    $con = mysqli_connect($wpdb->dbhost, $wpdb->dbuser, $wpdb->dbpassword, $wpdb->dbname);

    if(isset($actionProf)) {
        $extension = end(explode(".", $_FILES["excelProf"]["name"]));        // For getting Extension of selected file
        $allowed_extension = array("xls", "xlsx", "csv");               	 // allowed extension
        if (in_array($extension, $allowed_extension))                  	  	 // check selected file extension is present in allowed extension array
        {
            $file = $_FILES["excelProf"]["tmp_name"];                        // getting temporary source of excel file
            $objPHPExcel = PHPExcel_IOFactory::load($file);                  // create object of PHPExcel library by using load() method and in load method define path of selected file

            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                if(mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(0, 1)->getValue()) == "Prenom" &&
                    mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(1, 1)->getValue()) == "Nom" &&
                    mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(2, 1)->getValue()) == "Numero Ent" &&
                    mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(3, 1)->getValue()) == "email" &&
                    mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(4, 1)->getValue()) == "Code")
                {
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $prenom = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
                        $name = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
                        $mdp = chaine_aleatoire() ;
                        $mdpMd5 = md5($mdp) ;
                        $nicename = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(2, $row)->getValue());
                        $email = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(3, $row)->getValue());
                        $display = "$prenom" . " $name" ;
                        $code = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(4, $row)->getValue());

                        if($bduser->insertProf($name, $mdpMd5, $nicename, $prenom, $email, $display,$code)) {
                            $message = "Bonjour, vous avez été inscrit sur le site de la Télé Connecté de votre département en temps que professeur. <br> Sur ce site, vous aurez accès à votre emploie du temps, à vos notes et aux informations concernant votre scolarité. <br>" ;
                            $message2 = $message . "Votre identifiant est " . $nicename . " et votre mot de passe est " . $mdp . ". <br>"  ;
                            $message3 = $message2 . "Pour vous connecter, rendez vous sur le site : tv-connectee-amu.alwaysdata.net ." . "<br> Nous vous souhaitons une bonne expérience sur notre site. <br>" ;
                            //mail($email, "Inscription à la télé-connecté", $message3) ;
                        }
                        else {
                            array_push($doubles, $nicename);
                        }
                    }
                }
                else {
                    echo ('<p> Vous utilisez un mauvais fichier excel/ ou vous avez changé le nom des colonnes </p>');
                }
            }
            if(isset($doubles)) {
                foreach ($doubles as $double => $value) {
                    echo('<p> L\'inscription a échouée pour '.$value.', vérifié si le login ou l\'adresse mail n\'a pas déjà était utilisé </p> <br/>');
                }
            }
            else {
                echo("Votre inscription a été validé.");
            }
        }
        else {
            echo("Extension invalide."); //if non excel file
        }
    }
}