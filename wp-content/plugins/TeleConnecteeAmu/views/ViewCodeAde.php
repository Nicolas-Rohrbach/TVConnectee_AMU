<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 29/04/2019
 * Time: 09:54
 */

class ViewCodeAde extends ViewG
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
     * Header of the table
     */
    public function tableHeadCode(){
        echo '<form method="post">
                <table class="table text-center"> 
                <thead>
                    <tr class="text-center">
                        <th scope="col">#</th>
                        <th scope="col">Titre</th>
                        <th scope="col">Code ADE</th>
                        <th scope="col">Type</th>
                        <th scope="col">Modifier</th>
                        <th scope="col">Supprimer</th>
                     </tr>
                </thead>
                <tbody>';
    }

    /**
     * Display all codes in a tab
     * @param $results
     */
    public function displayAllCode($results){
        $this->tableHeadCode();
        $cpt = 0;
        foreach($results as $result){
            echo '
                <tr>
                    <td class="text-center"> '.$cpt.'</td>
                    <td class="text-center"> '.$result['title'].'</td>
                    <td class="text-center"> '.$result['code'].'</td>
                    <td class="text-center"> '.$result['type'].'</td>
                    <td class="text-center"> <a href="http://'.$_SERVER['HTTP_HOST'].'/gestion-codes-ade/modification-code-ade/'.$result['ID'].'" class="btn btn-primary btn-lg" name="modifetud" type="submit" value="Modifier">Modifier</a></td>
                    <td class="text-center"> <button class="btn btn-danger btn-lg " name="deleteCode" type="submit" value="'.$result['ID'].'" >Supprimer</button></td>
                </tr>';
            ++$cpt;
        }
        $this->endTab();
    }

    /**
     * Display the page for modify this code
     * @param $result
     */
    public function displayModifyCode($result){
        echo '
         <form method="post">
            <label>Titre</label>
            <input name="modifTitle" type="text" class="form-control" placeholder="Titre" value="'.$result['title'].'">
            <label>Code</label>
            <input name="modifCode" type="text" placeholder="Code" value="'.$result['code'].'">
            <div class="form-group">
            <label for="exampleFormControlSelect1">Selectionner une année</label>
                <select class="form-control" name="modifannee">
                    <option>'.$result['type'].'</option>
                    <option>Annee</option>
                    <option>Groupe</option>
                    <option>Demi-Groupe</option>
                </select>
            </div>
            <input name="modifCodeValid" type="submit" value="Valider">
            <a class="btn btn-dark btn-lg mb-3" href="http://'.$_SERVER['HTTP_HOST'].'/gestion-codes-ade">Annuler</a>
         </form>';
    }
}