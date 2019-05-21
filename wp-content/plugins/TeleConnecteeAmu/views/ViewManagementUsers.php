<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 26/04/2019
 * Time: 11:03
 */

class ViewManagementUsers extends ViewG
{
    public function displayButtonChoise(){
        echo '
        <form method="post">
          <input type="radio" name="seeUsers" value="students"> Etudiants 
          <input type="radio" name="seeUsers" value="teachers"> Enseignants
          <input type="radio" name="seeUsers" value="secretarys"> Secrétaires
          <input type="radio" name="seeUsers" value="televisions"> Télévisions
          <input type="submit" value="Envoyer">
        </form>';
    }
}