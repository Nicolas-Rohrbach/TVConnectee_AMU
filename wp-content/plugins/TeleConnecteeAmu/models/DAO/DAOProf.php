<?php
/**
 * Created by PhpStorm.
 * User: s17018568
 * Date: 06/02/2019
 * Time: 14:36
 */

class DAOProf implements DAOUser
{

    private $nom;
    private $prenom;
    private $bdId;

    /**
     * DAOProf constructor.
     * @param $nom
     * @param $prenom
     * @param $bdId
     */

    public function __construct($nom, $prenom, $bdId)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->bdId = $bdId;
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
    public function getIdBd()
    {
        return $this->bdId;
    }



    public static function sortByNom($tab = [])
    {
        $tabNom = [];

        foreach ($tab as $prof){
            $tabNom[$prof->getIdUnique()] = $prof->getNom();
        }

        $tabTemp = [];
        asort($tabNom);
        $i = 0;
        foreach ($tabNom as $id => $value){
            foreach($tab as $prof){
                if($prof->getIdUnique() === $id){
                    $tabTemp[$i] = $prof;
                }
            }
            ++$i;
        }
        return $tabTemp;
    }

    public static function sortByPrenom($tab = [])
    {
        $tabNom = [];

        foreach ($tab as $prof){
            $tabNom[$prof->getIdUnique()] = $prof->getPrenom();
        }

        $tabTemp = [];
        asort($tabNom);
        $i = 0;
        foreach ($tabNom as $id => $value){
            foreach($tab as $prof){
                if($prof->getIdUnique() === $id){
                    $tabTemp[$i] = $prof;
                }
            }
            ++$i;
        }
        return $tabTemp;
    }
}