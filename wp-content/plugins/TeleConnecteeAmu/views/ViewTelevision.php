<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 25/04/2019
 * Time: 10:46
 */

class ViewTelevision extends ViewG{

    public function displaySelect($years, $groups, $halfgroups){
        echo '<option value="0">Aucun</option>
                        <optgroup label="Année">';
                    foreach ($years as $year) {

                        echo '<option value="'.$year['code'].'">'.$year['title'].'</option >';
                    }
                    echo '</optgroup>
                          <optgroup label="Groupe">';
                    foreach ($groups as $group){
                        echo '<option value="'.$group['code'].'">'.$group['title'].'</option>';
                    }
                    echo '</optgroup>
                          <optgroup label="Demi groupe">';
                    foreach ($halfgroups as $halfgroup){
                        echo '<option value="'.$halfgroup['code'].'">'.$halfgroup['title'].'</option>';
                    }
                    echo '</optgroup>';
                    echo'
                    </select>';
    }

    public function displayFormTelevision($years, $groups, $halfgroups) {
        echo '
        <script src="/wp-content/plugins/TeleConnecteeAmu/views/js/addOrDeleteTvCode.js"></script>
         <div class="cadre">
            <div align="center">
                <form method="post" id="registerTvForm">
                    <label for="loginTv">Login</label>
                    <input type="text" class="form-control text-center modal-sm" name="loginTv" placeholder="Nom de compte" required="">
                    <label for="pwdTv">Mot de passe</label>
                    <input type="password" class="form-control text-center modal-sm" name="pwdTv" placeholder="Mot de passe" required="">
                    <label>Premier emploi du temps</label> <button onclick="addButton()"> Add input</button>
                    <select class="form-control" name="selectTv[]" required="">';
        $this->displaySelect($years, $groups, $halfgroups);

        echo'
                    <button type="submit" class="btn btn-primary" name="createTv">Créer</button>
                </form>
            </div>
         </div>';
    }

    public function displayHeaderTabTv(){
        $tab = ["Login", "Nombre de vues"];
        $this->displayStartTab($tab);
    }

    public function displayAllTv($id, $login,  $nbCode, $row){
        $tab = [$login, $nbCode];
        $this->displayAll($row, $id, $tab);
        echo '<td class="text-center"> <a href="http://'.$_SERVER['HTTP_HOST'].'/gestion-des-utilisateurs/modification-utilisateur/'.$id.'" class="btn btn-primary btn-lg" name="modif" type="submit" value="Modifier">Modifier</a></td>
        </tr>';
    }

    public function displaySelectSelected($years, $groups, $halfgroups, $name){
        $selected = $_POST[$name];
        echo '<option value="0">Aucun</option>
                        <optgroup label="Année">';
        foreach ($years as $year) {
            echo '<option value="'.$year['code'].'" '; if($year['code'] == $selected) echo "selected"; echo'>'.$year['title'].'</option >';
        }
        echo '</optgroup>
                          <optgroup label="Groupe">';
        foreach ($groups as $group){
            echo '<option value="'.$group['code'].'"'; if($group['code'] == $selected) echo "selected"; echo'>'.$group['title'].'</option>';
        }
        echo '</optgroup>
                          <optgroup label="Demi groupe">';
        foreach ($halfgroups as $halfgroup){
            echo '<option value="'.$halfgroup['code'].'" '; if($halfgroup['code'] == $selected) echo "selected"; echo'>'.$halfgroup['title'].'</option>';
        }
        echo '</optgroup>
        </select>';
    }

    public function displayModifyTv($result, $years, $groups, $halfgroups){
        $code = unserialize($result['code']);
        echo '
         <h3>'.$result['user_login'].'</h3>
         <form method="post">
            <label>Premier emploi du temps</label>
            <select class="form-control" name="firstCode" required="">
                <option value="'.$code[0].'">'.$code[0].'</option>';
        $this->displaySelectSelected($years, $groups, $halfgroups, "firstCode");
        echo'
            <label>Deuxième emploi du temps (Optionel)</label>
            <select class="form-control" name="secondCode">
                <option value="'.$code[1].'">'.$code[1].'</option>';
        $this->displaySelectSelected($years, $groups, $halfgroups, "secondCode");
        echo '
            <label>Troisième emploi du temps (Optionel)</label>
            <select class="form-control" name="thirdCode">
                <option value="'.$code[2].'">'.$code[2].'</option>';
        $this->displaySelectSelected($years, $groups, $halfgroups, "thirdCode");
        echo '
            <input name="modifValidate" type="submit" value="Valider">
            <a class="btn btn-dark btn-lg mb-3" href="http://'.$_SERVER['HTTP_HOST'].'/gestion-des-utilisateurs">Annuler</a>
         </form>';
    }

    public function displayErrorLogin(){
        echo '<div class="alert alert-danger"> Le login est déjà utilisé ! </div>';
    }
}