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

    public function displayAllStudent($id, $login, $year, $group, $halfgroup, $row){
        $tab = [$login, $year, $group, $halfgroup];
        $this->displayAll($row, $id, $tab);
        echo '<td class="text-center"> <a href="http://'.$_SERVER['HTTP_HOST'].'/gestion-des-utilisateurs/modification-utilisateur/'.$id.'" class="btn btn-primary btn-lg" name="modif" type="submit" value="Modifier">Modifier</a></td>
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
        $selected = $_POST['modifYear'];
        foreach ($years as $year) {
                echo '<option value="'.$year['code'].'"'; if($year['code'] == $selected) echo "selected"; echo'>'.$year['title'].'</option >';
        }
        echo'
            </select>
            <label>Groupe</label>
            <select class="form-control" name="modifGroup">
                <option>'.$result['code2'].'</option>';
        $selected = $_POST['modifGroup'];
        foreach ($groups as $group){
            echo'<option value="'.$group['code'].'"'; if($group['code'] == $selected) echo "selected"; echo'>'.$group['title'].'</option>';
        }
        echo'
            </select>
            <label>Demi-groupe</label>
            <select class="form-control" name="modifHalfgroup">
                <option>'.$result['code3'].'</option>';
        $selected = $_POST['modifHalfgroup'];
        foreach ($halfgroups as $halfgroup){
            echo'<option value="'.$halfgroup['code'].'"'; if($halfgroup['code'] == $selected) echo "selected"; echo'>'.$halfgroup['title'].'</option>';
        }
        echo'
            </select>
            <input name="modifvalider" type="submit" value="Valider">
            <a class="btn btn-dark btn-lg mb-3" href="http://'.$_SERVER['HTTP_HOST'].'/gestion-des-utilisateurs">Annuler</a>
         </form>';
    }
}