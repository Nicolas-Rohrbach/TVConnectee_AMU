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

    public function deleteCode($id){
        $this->deleteTuple('code_Ade',$id);
    }

    public function getAllCode(){
        return parent::getAll('code_ade');
    }
}