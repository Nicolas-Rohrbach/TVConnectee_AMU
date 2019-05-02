<?php
require_once("PHPExcel/IOFactory.php");


function chaine_aleatoire($chaine = 'azertyuiopqsdfghjklmwxcvbn123456789'){
    $nb_letters = strlen($chaine) - 1;
    $generation = '';
    for($i=0; $i < 8; $i++)
    {
        $pos = mt_rand(0, $nb_letters);
        $car = $chaine[$pos];
        $generation .= $car;
    }
    return $generation;
}

function excelStudent($actionEtud){
    $model = new StudentManager();

    global $wpdb;
    $doubles = array();
    $con = mysqli_connect($wpdb->dbhost, $wpdb->dbuser, $wpdb->dbpassword, $wpdb->dbname);
	
    if(isset($actionEtud)) {
        $extension = end(explode(".", $_FILES["excelEtu"]["name"]));    // For getting Extension of selected file
        $allowed_extension = array("xls", "xlsx", "csv");                // allowed extension
        if (in_array($extension, $allowed_extension)){
            $file = $_FILES["excelEtu"]["tmp_name"];                    // getting temporary source of excel file
            $objPHPExcel = PHPExcel_IOFactory::load($file);              // create object of PHPExcel library by using load() method and in load method define path of selected file

            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                if(
                    mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(0, 1)->getValue()) == "Numero Ent" &&
                    mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(1, 1)->getValue()) == "email" &&
                    mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(2, 1)->getValue()) == "Annee" &&
                    mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(3, 1)->getValue()) == "Groupe" &&
                    mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(4, 1)->getValue()) == "Demi-groupe")
                {
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $mdp = chaine_aleatoire() ;
                        $pwd = md5($mdp) ;
                        $login = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
                        $email = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
                        $year = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(2, $row)->getValue());
                        $group = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(3, $row)->getValue());
                        $halfgroup = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(4, $row)->getValue());

                        if($model->insertMyStudent($login, $pwd, $year, $group, $halfgroup, $email)) {
                            $message = "Bonjour, vous avez été inscrit sur le site de la Télé Connecté de votre département en temps qu'étudiant. <br> Sur ce site, vous aurez accès à votre emploie du temps, à vos notes et aux informations concernant votre scolarité. <br>" ;
                            $message2 = $message . "Votre identifiant est " . $login . " et votre mot de passe est " . $mdp . ". <br>"  ;
                            $message3 = $message2 . "Pour vous connecter, rendez vous sur le site : tv-connectee-amu.alwaysdata.net ." . "<br> Nous vous souhaitons une bonne expérience sur notre site. <br>" ;
                            //mail($email, "Inscription à la télé-connecté", $message3);
                        }
                        else {
                            array_push($doubles, $login);
                        }
                    }
                }
                else {
                    echo '<p class="alert alert-danger"> Vous utilisez un mauvais fichier excel/ ou vous avez changé le nom des colonnes </p>';
                }
            }
            if(isset($doubles)) {
                foreach ($doubles as $double => $value) {
                    echo'<p class="alert alert-danger"> L\'inscription a échouée pour '.$value.', vérifié si le login ou l\'adresse mail n\'a pas déjà était utilisé </p> <br/>';
                }
            }
            else {
                echo "<p class='alert alert-danger'>Votre inscription a été validé. </p>";
            }
        }
        else {
            echo "<p class='alert alert-danger'>Extension invalide. </p>"; //if non excel file
        }
    }
}

function excelTeacher($actionTeacher)
{
    $model = new TeacherManager();

    global $wpdb;
    $doubles = array();
    $con = mysqli_connect($wpdb->dbhost, $wpdb->dbuser, $wpdb->dbpassword, $wpdb->dbname);

    if(isset($actionTeacher)) {
        $extension = end(explode(".", $_FILES["excelProf"]["name"]));        // For getting Extension of selected file
        $allowed_extension = array("xls", "xlsx", "csv");               	 // allowed extension
        if (in_array($extension, $allowed_extension)){
            $file = $_FILES["excelProf"]["tmp_name"];                        // getting temporary source of excel file
            $objPHPExcel = PHPExcel_IOFactory::load($file);                  // create object of PHPExcel library by using load() method and in load method define path of selected file

            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                if(mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(0, 1)->getValue()) == "Numero Ent" &&
                    mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(1, 1)->getValue()) == "email" &&
                    mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(2, 1)->getValue()) == "Code") {
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $mdp = chaine_aleatoire() ;
                        $pwd = md5($mdp) ;
                        $login = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
                        $email = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
                        $code = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(2, $row)->getValue());

                        if($model->insertTeacher($login, $pwd, $code, $email)) {
                            $message = "Bonjour, vous avez été inscrit sur le site de la Télé Connecté de votre département en temps que professeur. <br> Sur ce site, vous aurez accès à votre emploie du temps, à vos notes et aux informations concernant votre scolarité. <br>" ;
                            $message2 = $message . "Votre identifiant est " . $login . " et votre mot de passe est " . $mdp . ". <br>"  ;
                            $message3 = $message2 . "Pour vous connecter, rendez vous sur le site : tv-connectee-amu.alwaysdata.net ." . "<br> Nous vous souhaitons une bonne expérience sur notre site. <br>" ;
                            //mail($email, "Inscription à la télé-connecté", $message3) ;
                        }
                        else {
                            array_push($doubles, $login);
                        }
                    }
                }
                else {
                    echo '<p class="alert alert-danger"> Vous utilisez un mauvais fichier excel/ ou vous avez changé le nom des colonnes </p>';
                }
            }
            if(isset($doubles)) {
                foreach ($doubles as $double => $value) {
                    echo '<p class="alert alert-danger"> L\'inscription a échouée pour '.$value.', vérifié si le login ou l\'adresse mail n\'a pas déjà était utilisé </p> <br/>';
                }
            }
            else {
                echo "<p class='alert alert-danger'>Votre inscription a été validé. </p>";
            }
        }
        else {
            echo "<p class='alert alert-danger'>Extension invalide. </p>"; //if non excel file
        }
    }
}