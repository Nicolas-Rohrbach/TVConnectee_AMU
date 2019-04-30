<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 25/04/2019
 * Time: 10:58
 */

class ViewTeacher extends ViewG
{
    public function displayInsertImportFileTeacher() {
        $this->displayInsertImportFile("Prof");
    }

    public function tabHeadTeacher(){
        echo '
         <form method="post">
             <table class="table"> 
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <td class="text-center"><strong>Login</strong></td>
                        <td class="text-center"><strong>Code ADE</strong></td>
                        <td class="text-center"><strong>Modifier</strong></td>
                        <td class="text-center"><strong>Supprimer </strong></td>
                    </tr>
                </thead>
            <tbody>
        ';
    }

    public function displayAllTeacher($result, $row){
        $this->displayAll($row, $result['user_login'], $result['annee']);
        echo '
          <td class="text-center"> <a href="http://'.$_SERVER['HTTP_HOST'].'/gestion-des-utilisateurs/modification-utilisateur/'.$result['ID'].'" class="btn btn-primary btn-lg" name="modifprof" type="submit" value="Modifier">Modifier</a></td>
          <td class="text-center"> <button class="btn btn-danger btn-lg " name="supprprof" type="submit" value="'.$result['ID'].'" >Supprimer</button></td>
        </tr>';
    }

    public function displayModifyTeacher($result){
        echo '
         <form method="post">
            <h3>'.$result['user_login'].'</h3>
            <label>Code ADE</label>
            <input name="modifCode" type="text" class="form-control" placeholder="Entrer le Code ADE" value="'.$result['annee'].'" required="">
            <button name="modifValidate" type="submit" class="btn btn-primary btn-lg mb-3" value="Valider">Valider</button>
            <a class="btn btn-dark btn-lg mb-3" href="http://'.$_SERVER['HTTP_HOST'].'/gestion-des-utilisateurs">Annuler</a>
         </form>';
    }
}