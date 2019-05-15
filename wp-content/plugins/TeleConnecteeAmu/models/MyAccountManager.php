<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 06/05/2019
 * Time: 10:09
 */

class MyAccountManager extends Model{

    /**
     * Vérifie si un code identique existe déjà
     * @param $code     Code ADE
     * @return bool     Renvoie vrai s'il y a un doublon
     */
    protected function checkIfDoubleCode($code){
        $var = 0;
        $req = $this->getDb()->prepare('SELECT * FROM code_delete_account WHERE Code =:code');
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
     * Vérifie si un titre identique existe déjà
     * @param $id    Titre du code ADE
     * @return bool     Renvoie vrai s'il y a un doublon
     */
    protected function checkIfDoubleUserID($id){
        $var = 0;
        $req = $this->getDb()->prepare('SELECT * FROM code_delete_account WHERE ID_user =:ID_user');
        $req->bindValue(':ID_user', $id);
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

    public function createRandomCode($userID, $code){
        if(! ($this->checkIfDoubleCode($code)) && ! ($this->checkIfDoubleUserID($userID))){
            $req = $this->getDb()->prepare('INSERT INTO code_delete_account (ID, ID_user, Code) 
                                         VALUES (NULL, :ID_user, :code)');

            $req->bindParam(':ID_user', $userID);
            $req->bindParam(':code', $code);

            $req->execute();

            return true;
        }
        else{
            return false;
        }
    }

    public function modifyCode($userID, $code){

    }

    public function getCode($userID){
        $var = 0;
        $req = $this->getDb()->prepare('SELECT * FROM code_delete_account WHERE ID_user = :userID');
        $req->bindParam(':userID', $userID);
        $req->execute();
        while ($data = $req->fetch()) {
            $var[] = $data;
        }
        return $var;
        $req->closeCursor();
    }

    public function deleteCode($UserID){
        $req = $this->getDb()->prepare('DELETE FROM code_delete_account WHERE ID_user = :id');
        $req->bindValue(':id', $UserID);

        $req->execute();
    }
}