<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 25/04/2019
 * Time: 11:25
 */

class Teacher extends ControllerG
{
    private $view;
    private $model;

    /**
     * Constructeur de Teacher
     */
    public function __construct(){
        $this->view = new ViewTeacher();
        $this->model = new TeacherManager();
    }

    /**
     * Insère tout les professeurs depuis un fichier excel
     * @param $actionTeacher
     */
    public function insertTeacher($actionTeacher){
        $this->view->displayInsertImportFileTeacher();
        if ($actionTeacher) {
            $allowed_extension = array("Xls", "Xlsx", "Csv");
            $extension = ucfirst(strtolower(end(explode(".", $_FILES["excelProf"]["name"]))));

            // allowed extension
            if (in_array($extension, $allowed_extension)) {
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($extension);
                $reader->setReadDataOnly(TRUE);
                $spreadsheet = $reader->load($_FILES["excelProf"]["tmp_name"]);

                $worksheet = $spreadsheet->getActiveSheet();
                $highestRow = $worksheet->getHighestRow();

                $row = $worksheet->getRowIterator(1, 1);
                $cells = [];
                foreach ($row as $value){
                    $cellIterator = $value->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(FALSE);
                    foreach ($cellIterator as $cell) {
                        $cells[] = $cell->getValue();
                    }
                }
                if($cells[0] == "Numero Ent" && $cells[1] == "email" && $cells[2] == "Code") {
                    $doubles = array();
                    for ($i = 2; $i < $highestRow + 1; ++$i) {
                        $cells = array();
                        foreach ($worksheet->getRowIterator($i, $i + 1) as $row) {
                            $cellIterator = $row->getCellIterator();
                            $cellIterator->setIterateOnlyExistingCells(FALSE);
                            foreach ($cellIterator as $cell) {
                                $cells[] = $cell->getValue();
                            }
                        }
                        $pwd = wp_generate_password();
                        $hashpass = wp_hash_password($pwd);
                        $login = $cells[0];
                        $email = $cells[1];
                        $codes = [$cells[2]];
                        if($this->model->insertTeacher($login, $hashpass, $email, $codes)){
                            foreach ($codes as $code){
                                $path = $this->getFilePath($code);
                                if(! file_exists($path))
                                    $this->addFile($code);
                            }
                            $message = "Bonjour, vous avez été inscrit sur le site de la Télé Connecté de votre département en temps qu'enseignant.\n";
                            $message1 = $message."Sur ce site, vous aurez accès à votre emploie du temps, à vos notes et aux informations concernant votre scolarité. \n" ;
                            $message2 = $message1 . "Votre identifiant est " . $login . " et votre mot de passe est " . $pwd. "\n";
                            $message3 = $message2 . "Pour vous connecter, rendez vous sur le site : ".home_url().". \n";
                            $message4 = $message3."Nous vous souhaitons une bonne expérience sur notre site." ;
                            mail($email, "Inscription à la télé-connecté", $message4);
                        }
                        else {
                            array_push($doubles, $cells[0]);
                        }
                    }
                    if(! is_null($doubles[0])) {
                        $this->view->displayErrorDouble($doubles);
                    } else {
                        $this->view->displayInsertValidate();
                    }
                }
                else {
                    $this->view->displayWrongFile();
                }
            } else {
                $this->view->displayWrongExtension();
            }
        }
    }

    /**
     * Affiche tout les utilisateurs dans un tableau
     */
    public function displayAllTeachers(){
        $results = $this->model->getUsersByRole('enseignant');
        if(isset($results)){
            $this->view->displayTabHeadTeacher();
            $row = 0;
            foreach ($results as $result){
                ++$row;
                $this->view->displayAllTeacher($result, $row);
            }
            $this->view->displayEndTab();
        }
        else{
            $this->view->displayEmpty();
        }
    }

    /**
     * Modifie l'utilisateur
     * @param $result
     */
    public function modifyTeacher($result){
        $action = $_POST['modifValidate'];
        $code = [$_POST['modifCode']];
        $this->view->displayModifyTeacher($result);
        if($action === 'Valider'){
            $this->model->modifyTeacher($result, $code);
            $this->view->refreshPage();
        }
    }
}