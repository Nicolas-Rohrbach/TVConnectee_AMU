<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 25/04/2019
 * Time: 10:58
 */

class ViewTeacher extends ViewG
{
    /**
     * Display the input for read a file
     */
    public function displayInsertImportFileTeacher() {
        $this->displayInsertImportFile("Prof");
    }

    /**
     * Header from the table
     */
    public function displayTabHeadTeacher(){
        $tab = ["Numéro Ent", "Code ADE"];
        $this->displayStartTab($tab);
    }

    /**
     * Display the content of all teacher per row in a table
     * @param $result
     * @param $row
     */
    public function displayAllTeacher($result, $row){
        $tab = [$result['user_login'], $result['code1']];
        $this->displayAll($row, $result['ID'], $tab);
        echo '
          <td class="text-center"> <a href="http://'.$_SERVER['HTTP_HOST'].'/gestion-des-utilisateurs/modification-utilisateur/'.$result['ID'].'" class="btn btn-primary btn-lg" name="modif" type="submit" value="Modifier">Modifier</a></td>
        </tr>';
    }

    /**
     * Display the page for modify the code of the teacher
     * @param $result
     */
    public function displayModifyTeacher($result){
        echo '
         <form method="post">
            <h3>'.$result['user_login'].'</h3>
            <label>Code ADE</label>
            <input name="modifCode" type="text" class="form-control" placeholder="Entrer le Code ADE" value="'.$result['code1'].'" required="">
            <button name="modifValidate" type="submit" class="btn btn-primary btn-lg mb-3" value="Valider">Valider</button>
            <a class="btn btn-dark btn-lg mb-3" href="http://'.$_SERVER['HTTP_HOST'].'/gestion-des-utilisateurs">Annuler</a>
         </form>';
    }
}