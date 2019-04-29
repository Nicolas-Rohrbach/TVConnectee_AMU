<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 26/04/2019
 * Time: 11:03
 */

class ViewManagementUsers
{
    public function displayButtonChoise(){
        echo '
        <form method="post">
          <input type="radio" name="seeUsers" value="Students"> Etudiants 
          <input type="radio" name="seeUsers" value="Teachers"> Enseignants
          <input type="radio" name="seeUsers" value="Secretarys"> Secrétaires
          <input type="radio" name="seeUsers" value="Televisions"> Télévisions
          <input type="submit" value="Envoyer">
        </form>';
    }
}