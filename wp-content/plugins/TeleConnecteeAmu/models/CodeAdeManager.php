<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 29/04/2019
 * Time: 09:36
 */

class CodeAdeManager extends Model
{
    protected function checkIfDoubleCode($code){
        $var = 0;
        $req = $this->getBdd()->prepare('SELECT * FROM code_ade WHERE code =:code');
        $req->bindValue(':code', $code);
        $req->execute();
        while ($data = $req->fetch(PDO::FETCH_ASSOC)){
            $var = $var + 1;
        }
        if ($var > 0)
            return true;
        else
            return false;

        $req->closeCursor();
    }

    /**
     * @param $title
     * @return bool
     */
    protected function checkIfDoubleTitle($title){
        $var = 0;
        $req = $this->getBdd()->prepare('SELECT * FROM code_ade WHERE title =:title');
        $req->bindValue(':title', $title);
        $req->execute();
        while ($data = $req->fetch(PDO::FETCH_ASSOC)){
            $var = $var + 1;
        }
        if ($var > 0)
            return true;
        else
            return false;

        $req->closeCursor();
    }


    /**
     * Add a tuple
     * @param $type
     * @param $title
     * @param $code
     * @return bool
     */
    public function addCode($type, $title, $code){
        if(! ($this->checkIfDoubleCode($code)) && ! ($this->checkIfDoubleTitle($title))){
            $req = $this->getBdd()->prepare('INSERT INTO code_ade (type, title, code) 
                                         VALUES (:type, :title, :code)');

            $req->bindParam(':type', $type);
            $req->bindParam(':title', $title);
            $req->bindParam(':code', $code);

            $req->execute();

            return true;
        }
        else{
            return false;
        }
    }

    /**
     * Modify the tuple
     * @param $result - Hold parameter of the tuple
     * @param $id
     * @param $title
     * @param $code
     * @param $type
     * @return bool
     */
    public function checkModify($result, $id, $title, $code, $type){
        if($result[0]['title'] != $title && $result[0]['code'] != $code){
            if(!($this->checkIfDoubleCode($code)) && !($this->checkIfDoubleTitle($title))){
                $this->modifyCode($id, $title, $code, $type);
                return true;
            }
            else{
                return false;
            }
        }
        elseif ($result[0]['title'] == $title && $result[0]['code'] != $code){
            if(!($this->checkIfDoubleCode($code))){
                $this->modifyCode($id, $title, $code, $type);
                return true;
            }
            else{
                return false;
            }
        }
        elseif ($result[0]['title'] != $title && $result[0]['code'] == $code){
            if (!($this->checkIfDoubleTitle($title))){
                $this->modifyCode($id, $title, $code, $type);
                return true;
            }
            else{
                return false;
            }
        }
        elseif($result[0]['title'] == $title && $result[0]['code'] == $code){
            $this->modifyCode($id, $title, $code, $type);
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * Modify tuple
     * @param $id
     * @param $title
     * @param $code
     * @param $type
     */
    public function modifyCode($id, $title, $code, $type){

            $req = $this->getBdd()->prepare('UPDATE code_ade SET title=:title, code=:code, type=:type WHERE ID=:id');

            $req->bindParam(':id', $id);
            $req->bindParam(':title', $title);
            $req->bindParam(':code', $code);
            $req->bindParam(':type', $type);

            $req->execute();

    }

    /**
     * Delete tuple
     * @param $id
     */
    public function deleteCode($id){
        $this->deleteTuple('code_ade',$id);
    }

    /**
     * Return all tuple from the table code_ade
     * @return array
     */
    public function getAllCode(){
        return parent::getAll('code_ade');
    }

    /**
     * Return the tuple bind with the id
     * @param $id
     * @return array
     */
    public function getCode($id){
        $req = $this->getBdd()->prepare('SELECT * FROM code_ade WHERE ID = :id');
        $req->bindParam(':id', $id);
        $req->execute();
        while ($data = $req->fetch()) {
            $var[] = $data;
        }
        return $var;
        $req->closeCursor();
    }
}