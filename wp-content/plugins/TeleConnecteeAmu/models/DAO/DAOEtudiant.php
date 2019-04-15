<?php
/**
 * Created by PhpStorm.
 * User: alexi
 * Date: 31/01/2019
 * Time: 17:09
 */

class DAOEtudiant implements DAOUser
{
    private $nom;
    private $prenom;
    private $annee;
    private $groupe;
    private static $id = 0;
    private $idUnique;
    private $idBd;

    /**
     * DAOUser constructor.
     * @param $nom
     * @param $prenom
     * @param $annee
     * @param $groupe
     */
    public function __construct($nom, $prenom, $annee, $groupe, $idBd)
    {
        $this->idUnique = self::$id++;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->annee = $annee;
        $this->groupe = $groupe;
        $this->idBd = $idBd;
    }
    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }
    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }
    /**
     * @return mixed
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * @return mixed
     */
    public function getGroupe()
    {
        return $this->groupe;
    }

    /**
     * @return int
     */
    public function getIdUnique()
    {
        return $this->idUnique;
    }

    public static function getId()
    {
        return self::$id;
    }

    /**
     * @return mixed
     */
    public function getIdBd()
    {
        return $this->idBd;
    }

    /**
     * @return array
     */



    public static function sortByNom($tab = [])
    {
        $tabNom = [];

        foreach ($tab as $etudiant){
            $tabNom[$etudiant->getIdUnique()] = $etudiant->getNom();
        }

        $tabTemp = [];
        asort($tabNom);
        $i = 0;
        foreach ($tabNom as $id => $value){
            foreach($tab as $etudiant){
                if($etudiant->getIdUnique() === $id){
                    $tabTemp[$i] = $etudiant;
                }
            }
            ++$i;
        }
        return $tabTemp;
    }

    public static function sortByPrenom($tab = [])
    {
        $tabNom = [];

        foreach ($tab as $etudiant){
            $tabNom[$etudiant->getIdUnique()] = $etudiant->getPrenom();
        }

        $tabTemp = [];
        asort($tabNom);
        $i = 0;
        foreach ($tabNom as $id => $value){
            foreach($tab as $etudiant){
                if($etudiant->getIdUnique() === $id){
                    $tabTemp[$i] = $etudiant;
                }
            }
            ++$i;
        }
        return $tabTemp;
    }

    public function sortByAnnee($tab = [])
    {
        $tabNom = [];

        foreach ($tab as $etudiant){
            $tabNom[$etudiant->getIdUnique()] = $etudiant->getAnnee();
        }

        $tabTemp = [];
        asort($tabNom);
        $i = 0;
        foreach ($tabNom as $id => $value){
            foreach($tab as $etudiant){
                if($etudiant->getIdUnique() === $id){
                    $tabTemp[$i] = $etudiant;
                }
            }
            ++$i;
        }
        return $tabTemp;
    }

    public function sortByGroupe($tab = [])
    {
        $tabNom = [];

        foreach ($tab as $etudiant){
            $tabNom[$etudiant->getIdUnique()] = $etudiant->getGroupe();
        }

        $tabTemp = [];
        asort($tabNom);
        $i = 0;
        foreach ($tabNom as $id => $value){
            foreach($tab as $etudiant){
                if($etudiant->getIdUnique() === $id){
                    $tabTemp[$i] = $etudiant;
                }
            }
            ++$i;
        }
        return $tabTemp;
    }
}