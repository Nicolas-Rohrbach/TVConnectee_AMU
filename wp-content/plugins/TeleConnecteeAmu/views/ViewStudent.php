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
        $tab = ["Numéro étudiant", "Année", "Groupe", "Demi groupe"];
        $this->startTab($tab);
    }

    public function displayAllStudent($result, $year, $group, $halfgroup, $row){
        $tab = [$result['user_login'], $year, $group, $halfgroup];
        $this->displayAll($row, $result['ID'], $tab);
        echo '
          <td class="text-center"> <a href="http://'.$_SERVER['HTTP_HOST'].'/gestion-des-utilisateurs/modification-utilisateur/'.$result['ID'].'" class="btn btn-primary btn-lg" name="modifetud" type="submit" value="Modifier">Modifier</a></td>
        </tr>';
    }

    public function displayModifyStudent($result, $years, $groups, $halfgroups){
        echo '
         <h3>'.$result['user_login'].'</h3>
         <form method="post">
            <label>Année</label>
            <select class="form-control" name="modifYear">
                <option>'.$result['code1'].'</option>
            ';
            foreach ($years as $year) {
                echo '<option value="'.$year['code'].'">'.$year['title'].'</option >';
            }
            echo'
            </select>
            <label>Groupe</label>
            <select class="form-control" name="modifGroup">
                <option>'.$result['code2'].'</option>';
            foreach ($groups as $group){
                echo'<option value="'.$group['code'].'">'.$group['title'].'</option>';
            }
            echo'
            </select>
            <label>Demi-groupe</label>
            <select class="form-control" name="modifHalfgroup">
                <option>'.$result['code3'].'</option>';
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