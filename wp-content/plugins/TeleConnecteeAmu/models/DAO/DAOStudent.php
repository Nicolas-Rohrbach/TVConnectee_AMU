<?php
/**
 * Created by PhpStorm.
 * User: alexi
 * Date: 31/01/2019
 * Time: 17:09
 */

class DAOStudent implements DAOUser
{
    private $firstname;
    private $lastname;
    private $year;
    private $group;
    private $halfgroup;
    private $id = 0;

    /**
     * DAOUser constructor.
     * @param $firstname
     * @param $lastname
     * @param $year
     * @param $group
     * @param $halfgroup
     * @param $id
     */
    public function __construct($firstname, $lastname, $year, $group, $halfgroup, $id){
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->year = $year;
        $this->group = $group;
        $this->halfgroup = $halfgroup;
        $this->id = $id;
    }
    /**
     * @return mixed
     */
    public function getFirstname(){
        return $this->firstname;
    }
    /**
     * @return mixed
     */
    public function getLastname(){
        return $this->lastname;
    }
    /**
     * @return mixed
     */
    public function getYear(){
        return $this->year;
    }

    /**
     * @return mixed
     */
    public function getGroup(){
        return $this->group;
    }

    /**
     * @return mixed
     */
    public function getHalfgroup(){
        return $this->halfgroup;
    }

    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param array $tab
     * @return array
     */
    public static function sortByFirstname($tab = []){
        $tabFirstname = [];

        foreach ($tab as $student){
            $tabFirstname[$student->getId()] = $student->getFirstname();
        }

        $tabTemp = [];
        asort($tabFirstname);
        $i = 0;
        foreach ($tabFirstname as $id => $value){
            foreach($tab as $student){
                if($student->getId() === $id){
                    $tabTemp[$i] = $student;
                }
            }
            ++$i;
        }
        return $tabTemp;
    }

    /**
     * @param array $tab
     * @return array
     */
    public static function sortByLastname($tab = []){
        $tabLastname = [];

        foreach ($tab as $student){
            $tabLastname[$student->getId()] = $student->getLastname();
        }

        $tabTemp = [];
        asort($tabNom);
        $i = 0;
        foreach ($tabLastname as $id => $value){
            foreach($tab as $student){
                if($student->getIdUnique() === $id){
                    $tabTemp[$i] = $student;
                }
            }
            ++$i;
        }
        return $tabTemp;
    }

    /**
     * @param array $tab
     * @return array
     */
    public static function sortByYear($tab = []){
        $tabFirstname = [];

        foreach ($tab as $student){
            $tabFirstname[$student->getId()] = $student->getYear();
        }

        $tabTemp = [];
        asort($tabFirstname);
        $i = 0;
        foreach ($tabFirstname as $id => $value){
            foreach($tab as $student){
                if($student->getId() === $id){
                    $tabTemp[$i] = $student;
                }
            }
            ++$i;
        }
        return $tabTemp;
    }

    /**
     * @param array $tab
     * @return array
     */
    public static function sortByGroup($tab = []){
        $tabFirstname = [];

        foreach ($tab as $student){
            $tabFirstname[$student->getId()] = $student->getGroup();
        }

        $tabTemp = [];
        asort($tabFirstname);
        $i = 0;
        foreach ($tabFirstname as $id => $value){
            foreach($tab as $student){
                if($student->getId() === $id){
                    $tabTemp[$i] = $student;
                }
            }
            ++$i;
        }
        return $tabTemp;
    }

    /**
     * @param array $tab
     * @return array
     */
    public static function sortByHalfgroup($tab = []){
        $tabFirstname = [];

        foreach ($tab as $student){
            $tabFirstname[$student->getId()] = $student->getHalfgroup();
        }

        $tabTemp = [];
        asort($tabFirstname);
        $i = 0;
        foreach ($tabFirstname as $id => $value){
            foreach($tab as $student){
                if($student->getId() === $id){
                    $tabTemp[$i] = $student;
                }
            }
            ++$i;
        }
        return $tabTemp;
    }
}