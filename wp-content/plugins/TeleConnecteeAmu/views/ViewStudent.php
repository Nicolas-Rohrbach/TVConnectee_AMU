<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 25/04/2019
 * Time: 10:44
 */

class ViewStudent extends ViewG
{
    public function displayInsertImportFileStudent() {
        $this->displayInsertImportFile("Etu");
    }

    public function tabHeadStudent(){
        echo '
            <form method="post">
                <table class="table text-center"> 
                <thead>
                    <tr class="text-center">
                        <th scope="col">#</th>
                        <th scope="col">Numéro étudiant</th>
                        <th scope="col">Année</th>
                        <th scope="col">Groupe</th>
                        <th scope="col">Demi groupe</th>
                        <th scope="col">Modifier</th>
                        <th scope="col">Supprimer</th>
                     </tr>
                </thead>
                <tbody>
        ';
    }

    public function displayAllStudent($result, $year, $group, $halfgroup, $row){
        $this->displayAll($row , $result['user_login'], $year);
        echo '
          <td class="text-center">'.$group.'</td>
          <td class="text-center">'.$halfgroup.'</td>
          <td class="text-center"> <a href="http://'.$_SERVER['HTTP_HOST'].'/gestion-des-utilisateurs/modification-utilisateur/'.$result['ID'].'" class="btn btn-primary btn-lg" name="modifetud" type="submit" value="Modifier">Modifier</a></td>
          <td class="text-center"> <button class="btn btn-danger btn-lg " name="suppretud" type="submit" value="'.$result['ID'].'" >Supprimer</button></td>
        </tr>';
    }

    public function displayModifyStudent($result, $years, $groups, $halfgroups){
        echo '
         <h3>'.$result['user_login'].'</h3>
         <form method="post">
            <label>Année</label>
            <select class="form-control" name="modifYear">
                <option>'.$result['annee'].'</option>
            ';
            foreach ($years as $year) {
                echo '<option value="'.$year['code'].'">'.$year['title'].'</option >';
            }
            echo'
            </select>
            <label>Groupe</label>
            <select class="form-control" name="modifGroup">
                <option>'.$result['groupe'].'</option>';
            foreach ($groups as $group){
                echo'<option value="'.$group['code'].'">'.$group['title'].'</option>';
            }
            echo'
            </select>
            <label>Demi-groupe</label>
            <select class="form-control" name="modifHalfgroup">
                <option>'.$result['demiGroupe'].'</option>';
            foreach ($halfgroups as $halfgroup){
                echo'<option value="'.$halfgroup['code'].'">'.$halfgroup['title'].'</option>';
            }
            echo'
            </select>
            <input name="modifvalider" type="submit" value="Valider">
            <a class="btn btn-dark btn-lg mb-3" href="http://'.$_SERVER['HTTP_HOST'].'/gestion-des-utilisateurs">Annuler</a>
         </form>';
    }
}