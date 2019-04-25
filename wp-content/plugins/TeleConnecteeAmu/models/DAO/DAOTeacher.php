<?php
/**
 * Created by PhpStorm.
 * User: s17018568
 * Date: 06/02/2019
 * Time: 14:36
 */

class DAOTeacher implements DAOUser
{

    private $firstname;
    private $lastname;
    private $code;
    private $id;

    /**
     * DAOTeacher constructor.
     * @param $firstname
     * @param $lastname
     * @param $code
     * @param $id
     */
    public function __construct($firstname, $lastname, $code, $id)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->code = $code;
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Sort teachers by firstname
     * @param array $tab
     * @return array
     */
    public static function sortByFirstname($tab = [])
    {
        $tabFirstname = [];

        foreach ($tab as $teacher){
            $tabFirstname[$teacher->getId()] = $teacher->getFirstname();
        }

        $tabTemp = [];
        asort($tabFirstname);
        $i = 0;
        foreach ($tabFirstname as $id => $value){
            foreach($tab as $teacher){
                if($teacher->getId() === $id){
                    $tabTemp[$i] = $teacher;
                }
            }
            ++$i;
        }
        return $tabTemp;
    }

    /**
     * Sort teachers by lastname
     * @param array $tab
     * @return array
     */
    public static function sortByLastname($tab = [])
    {
        $tabLastname = [];

        foreach ($tab as $teacher){
            $tabLastname[$teacher->getId()] = $teacher->getLastname();
        }

        $tabTemp = [];
        asort($tabNom);
        $i = 0;
        foreach ($tabLastname as $id => $value){
            foreach($tab as $teacher){
                if($teacher->getId() === $id){
                    $tabTemp[$i] = $teacher;
                }
            }
            ++$i;
        }
        return $tabTemp;
    }
}