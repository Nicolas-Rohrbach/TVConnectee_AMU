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
    private $card;
    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->userview = new ViewUser();
        $this->bduser = new BdUser();
        $this->card = new ViewCard();
    }

    public function insert_user($actionEtud, $actionGroupe, $actionProf){

        excelEtudiant($actionEtud);
        //$this->excelGroupe($actionGroupe);
        excelProf($actionProf);

        $this->userview->afficherInsert();

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
            $this->userview->refresh();
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
            $this->bduser->insertEtudiant($nom, $result['user_pass'], $result['user_login'], $result['user_email'], $result['display_name'], $annee, $result['alternant'], $groupe, $result['demiGroupe'],
                $result['langue'], $prenom);
            $this->userview->refresh();

        }

    }

    public function supprProf($action){
        if(isset($action)){
            $this->bduser->supprProf($action);
            $this->userview->refreshEtud();
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
            $this->bduser->insertProf($nom, $result['user_pass'], $result['user_login'], $prenom ,$result['user_email'], $result['display_name']);
            $this->userview->refreshProf();


        }
    }
}