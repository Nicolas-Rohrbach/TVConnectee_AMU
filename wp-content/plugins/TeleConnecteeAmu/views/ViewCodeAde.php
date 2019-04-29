<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 29/04/2019
 * Time: 09:54
 */

class ViewCodeAde
{
    /**
     * Display a form for create a new ADE code with a title and a type
     */
    public function displayFormAddCode(){
        echo '
         <div class="cadre">
             <div align="center">
                <form method="post">
                    <label for="titleAde">Titre</label>
                    <input type="text" class="form-control text-center modal-sm" name="titleAde" placeholder="Titre" required="">
                    <label for="codeAde">Code ADE</label>
                    <input type="text" class="form-control text-center modal-sm" name="codeAde" placeholder="Code ADE" required="">
                    <input type="radio" name="typeCode" value="Annee"> Année 
                    <input type="radio" name="typeCode" value="Groupe"> Groupe
                    <input type="radio" name="typeCode" value="Demi-groupe"> Demi-Groupe
                  <button type="submit" class="btn btn-primary" name="addCode" value="Valider">Ajouter</button>
                </form>
            </div>
         </div>';
    }

    /**
     * Display all codes
     * @param $results
     */
    public function displayAllCode($results){
        foreach($results as $result){
            echo $result['code'].$result['title'].$result['type'];
        }
    }
}