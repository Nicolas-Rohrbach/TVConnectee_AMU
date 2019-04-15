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
    $con = mysqli_connect("mysql-tvconnectee.alwaysdata.net", "180947", "TvStage2019", "tvconnectee_bd") ;
	
    if(isset($actionEtud)) {
        $extension = end(explode(".", $_FILES["excelEtud"]["name"]));    // For getting Extension of selected file
        $allowed_extension = array("xls", "xlsx", "csv");                // allowed extension
        if (in_array($extension, $allowed_extension))                    // check selected file extension is present in allowed extension array
        {
            $file = $_FILES["excelEtud"]["tmp_name"];                    // getting temporary source of excel file
            $objPHPExcel = PHPExcel_IOFactory::load($file);              // create object of PHPExcel library by using load() method and in load method define path of selected file

            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                for ($row = 2; $row <= $highestRow; $row++) {
                    $prenom = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
                    $name = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
                    $mdp = chaine_aleatoire() ;
					$mdpMd5 = md5($mdp) ;
                    $nicename = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(2, $row)->getValue());
                    $email = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(3, $row)->getValue());
                    $display = "$prenom" . " $name" ;
                    $annee = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(4, $row)->getValue());
                    $alternant = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(5, $row)->getValue());
                    $groupe = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(6, $row)->getValue());
                    $demigroupe = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(7, $row)->getValue());
                    $langue = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(8, $row)->getValue());

                    $bduser->insertEtudiant($name, $mdpMd5, $nicename, $email, $display, $annee, $alternant, $groupe, $demigroupe, $langue, $prenom) ;
					$message = "Bonjour, vous avez été inscrit sur le site de la Télé Connecté de votre département en temps qu'étudiant. <br> Sur ce site, vous aurez accès à votre emploie du temps, à vos notes et aux informations concernant votre scolarité. <br>" ;
					$message2 = $message . "Votre identifiant est " . $nicename . " et votre mot de passe est " . $mdp . ". <br>"  ;
					$message3 = $message2 . "Pour vous connecter, rendez vous sur le site : tv-connectee-amu.alwaysdata.net ." . "<br> Nous vous souhaitons une bonne expérience sur notre site. <br>" ;
					mail($email, "Inscription à la télé-connecté", $message3) ;
                }
            }
            echo("Votre inscription a été validé.");
        }
        else {
            echo("Extension invalide."); //if non excel file
        }
    }
}

function excelProf($actionProf)
{
    $bduser = new BdUser();
    $con = mysqli_connect("mysql-tvconnectee.alwaysdata.net", "180947", "TvStage2019", "tvconnectee_bd") ;
    if(isset($actionProf)) {
        $extension = end(explode(".", $_FILES["excelProf"]["name"]));        // For getting Extension of selected file
        $allowed_extension = array("xls", "xlsx", "csv");               	 // allowed extension
        if (in_array($extension, $allowed_extension))                  	  	 // check selected file extension is present in allowed extension array
        {
            $file = $_FILES["excelProf"]["tmp_name"];                        // getting temporary source of excel file
            $objPHPExcel = PHPExcel_IOFactory::load($file);                  // create object of PHPExcel library by using load() method and in load method define path of selected file
            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                for ($row = 2; $row <= $highestRow; $row++) {
                    $prenom = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
                    $name = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
                    $mdp = chaine_aleatoire() ;
					$mdpMd5 = md5($mdp) ;
                    $nicename = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(2, $row)->getValue());
                    $email = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(3, $row)->getValue());
                    $display = "$prenom" . " $name" ;
                    $code = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(4, $row)->getValue());

                    $bduser->insertProf($name, $mdpMd5, $nicename, $prenom, $email, $display) ;
					$message = "Bonjour, vous avez été inscrit sur le site de la Télé Connecté de votre département en temps que professeur. <br> Sur ce site, vous aurez accès à votre emploie du temps, à vos notes et aux informations concernant votre scolarité. <br>" ;
					$message2 = $message . "Votre identifiant est " . $nicename . " et votre mot de passe est " . $mdp . ". <br>"  ;
					$message3 = $message2 . "Pour vous connecter, rendez vous sur le site : tv-connectee-amu.alwaysdata.net ." . "<br> Nous vous souhaitons une bonne expérience sur notre site. <br>" ;
					mail($email, "Inscription à la télé-connecté", $message3) ;
                    $fichier_nom = 'wp-content/plugins/Excel/test.yaml';
                    $fichier_yaml = 'wp-content/plugins/Emploi du temps/data/resources.yaml';
                    $ajout = "\n" . "    " . $code . ": " . $prenom . " " . $name;
                    file_put_contents($fichier_yaml, $ajout, FILE_APPEND); // ecriture fin de fichier
                }
            }
            echo("Votre inscription a été validé.");
        }
        else {
            echo("Extension invalide."); //if non excel file
        }
    }
}

//    if(isset($actionGroupe))
//    {
//        $extension = end(explode(".", $_FILES["excel"]["name"])); 		// For getting Extension of selected file
//        $allowed_extension = array("xls", "xlsx", "csv"); 				//allowed extension
//        if(in_array($extension, $allowed_extension)) 					//check selected file extension is present in allowed extension array
//        {
//            $file = $_FILES["excel"]["tmp_name"]; 						// getting temporary source of excel file
//            $objPHPExcel = PHPExcel_IOFactory::load($file);				// create object of PHPExcel library by using load() method and in load method define path of selected file
//
//            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
//            {
//                $highestRow = $worksheet->getHighestRow();
//                for($row=1; $row<=$highestRow; $row++)
//                {
//                    $groupe = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
//                    $wpdb->query("INSERT INTO `groupe`(`groupe`) VALUES ('$groupe')");
//                }
//            }
//            echo ("Votre inscription a été validé.") ;
//        }
//        else
//        {
//            echo ("Extension invalide."); //if non excel file then
//        }
//    }
//}
//add_action('HookTitou', 'Excel');