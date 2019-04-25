<?php
/**
 * Created by PhpStorm.
 * User: s17018568
 * Date: 22/01/19
 * Time: 15:19
 */

class User
{
    private $bduser;
    private $userview;
    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->userview = new ViewUser();
        $this->bduser = new BdUser();
    }

    public function insert_etudiant($actionEtud){

        excelEtudiant($actionEtud);
        $this->userview->afficherInsertEtudiant();

    }

    public function insert_prof($actionProf) {
        excelProf($actionProf);
        $this->userview->affichierInsertProf();
    }

    public function insert_tv($action, $name, $pwd, $code, $code2, $code3) {
        $this->userview->displayFormTele();
        if(isset($action)) {
            $this->bduser->insertTv($name, $pwd, $code, $code2, $code3);
        }
    }

    public function insert_secre($action, $login, $pwd, $firstname, $lastname) {
        $this->userview->displayFormSecre();
        if(isset($action)) {
            $this->bduser->insertSecre($login, $pwd, $firstname, $lastname);
        }
    }

    function afficherLesEtudiants($action){

        $result = $this->bduser->getEtudiants();
        $this->userview->tabHeadEtud();

        $tabEtud = [];
        $cpt = 0;

        foreach ($result as $row) {

            $nom = $row['user_nicename'];
            $prenom = $row['prenom'];
            $annee = $row['annee'];
            $groupe = $row['groupe'];
            $halfgroup = $row['demi-groupe'];
            $idBd = $row['ID'];

            $etudiant = new DAOEtudiant($nom, $prenom, $annee, $groupe, $idBd);

            $tabEtud[$cpt] = $etudiant;
            ++$cpt;

        }
        $i = 0;
        if($action[0] === 'nom'){
            $tabEtudSort = DAOEtudiant::sortByNom($tabEtud);
            foreach ($tabEtudSort as $etudiant){
                $this->userview->afficherSupprEtud($etudiant->getNom(), $etudiant->getPrenom(), $etudiant->getAnnee(), $etudiant->getGroupe(), ++$i, $etudiant->getIdBd());
            }
        }

        elseif($action[1] === 'prenom'){
            $tabEtudSort = DAOEtudiant::sortByPrenom($tabEtud);
            foreach ($tabEtudSort as $etudiant){
                    $this->userview->afficherSupprEtud($etudiant->getNom(), $etudiant->getPrenom(), $etudiant->getAnnee(), $etudiant->getGroupe(), ++$i, $etudiant->getIdBd());
            }
        }
        elseif($action[2] === 'annee1'){
            foreach ($tabEtud as $etudiant){
                if($etudiant->getAnnee() === '1'){
                    $this->userview->afficherSupprEtud($etudiant->getNom(), $etudiant->getPrenom(), $etudiant->getAnnee(), $etudiant->getGroupe(), ++$i, $etudiant->getIdBd());
                }
            }
        }
        elseif($action[3] === 'annee2'){
            foreach ($tabEtud as $etudiant){
                if($etudiant->getAnnee() === '2'){
                    $this->userview->afficherSupprEtud($etudiant->getNom(), $etudiant->getPrenom(), $etudiant->getAnnee(), $etudiant->getGroupe(), ++$i, $etudiant->getIdBd());
                }
            }
        }
        elseif($action[3] === 'licence'){
            foreach ($tabEtud as $etudiant){
                if($etudiant->getAnnee() == "Licence ACI"){
                    $this->userview->afficherSupprEtud($etudiant->getNom(), $etudiant->getPrenom(), $etudiant->getAnnee(), $etudiant->getGroupe(), ++$i, $etudiant->getIdBd());
                }
            }
        }
        else{
            foreach ($tabEtud as $etudiant){
                $this->userview->afficherSupprEtud($etudiant->getNom(), $etudiant->getPrenom(), $etudiant->getAnnee(), $etudiant->getGroupe(), ++$i, $etudiant->getIdBd());
            }
        }
        $this->userview->endTab();
    }

    public function supprEtudiant($action){
        if(isset($action)){
            $this->bduser->supprEtudiant($action);
            $this->userview->refreshPage();
        }

    }

    public function afficherLesProf($action){

        $result = $this->bduser->getProfs();
        $this->userview->tabHeadProf();

        $tabEtud = [];
        $cpt = 0;

        foreach ($result as $row) {

            $nom = $row['user_nicename'];
            $prenom = $row['prenom'];
            $idBd = $row['ID'];

            $prof = new DAOProf($nom, $prenom, $idBd);

            $tabEtud[$cpt] = $prof;
            ++$cpt;

        }
        $i = 0;
        if($action[0] === 'nom'){
            $tabEtudSort = DAOProf::sortByNom($tabEtud);
            foreach ($tabEtudSort as $prof){
                $this->userview->afficherSupprProf($prof->getNom(), $prof->getPrenom(), ++$i, $prof->getIdBd());
            }
        }

        elseif($action[1] === 'prenom'){
            $tabEtudSort = DAOProf::sortByPrenom($tabEtud);
            foreach ($tabEtudSort as $prof){
                $this->userview->afficherSupprProf($prof->getNom(), $prof->getPrenom(), ++$i, $prof->getIdBd());
            }
        }
        else{
            foreach ($tabEtud as $prof){
                $this->userview->afficherSupprProf($prof->getNom(), $prof->getPrenom(),++$i, $prof->getIdBd());
            }
        }
        $this->userview->endTab();
    }

    public function afficherModifEtudiant($action, $nom, $prenom, $annee, $groupe){

        $adresse = $_SERVER['REQUEST_URI'];
        $id =  '';

        for($i = 1; $i < strlen($adresse); ++$i){
            if($adresse[$i] === '/'){
                for($j = $i + 1; $j < strlen($adresse) - 1; ++$j){
                    $id .= $adresse[$j];
                }
            }
        }
        $result = $this->bduser->getById($id);
        $this->userview->affichageModifEtud($result['user_nicename'], $result['prenom'], $result['annee'], $result['groupe']);

        if($action === 'Valider'){
            $this->bduser->supprEtudiant($id);
            $this->bduser->insertEtudiant($nom, $result['user_pass'], $result['user_login'], $result['user_email'], $result['display_name'], $annee, $groupe, $result['demiGroupe'], $prenom);
            $this->userview->refreshEtud();

        }

    }

    public function supprProf($action){
        if(isset($action)){
            $this->bduser->supprProf($action);
            $this->userview->refreshProf();
        }
    }

    public function afficherModifProf(){
        $adresse = $_SERVER['REQUEST_URI'];
        $id =  '';

        $action = $_POST['modifvalider'];
        $nom  = $_POST['modifnom'];
        $prenom = $_POST['modifprenom'];

        for($i = 1; $i < strlen($adresse); ++$i){
            if($adresse[$i] === '/'){
                for($j = $i + 1; $j < strlen($adresse) - 1; ++$j){
                    $id .= $adresse[$j];
                }
            }
        }

        $result = $this->bduser->getById($id);
        $this->userview->affichageModifProf($result['user_nicename'], $result['prenom']);

        if($action === 'Valider'){
            $this->bduser->supprProf($id);
            $this->bduser->insertProf($nom, $result['user_pass'], $result['user_login'], $prenom ,$result['user_email'], $result['display_name'], $result['code']);
            $this->userview->refreshProf();
        }
    }
}