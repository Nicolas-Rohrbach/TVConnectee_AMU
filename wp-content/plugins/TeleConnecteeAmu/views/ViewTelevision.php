<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 25/04/2019
 * Time: 10:46
 */

class ViewTelevision extends ViewG
{
    public function displayFormTelevision($years, $groups, $halfgroups) {
        echo '
         <div class="cadre">
            <div align="center">
                <form method="post" id="registerform">
                    <label for="loginTv">Login</label>
                    <input type="text" class="form-control text-center modal-sm" name="loginTv" placeholder="Nom de compte" required="">
                    <label for="pwdTv">Mot de passe</label>
                    <input type="password" class="form-control text-center modal-sm" name="pwdTv" placeholder="Mot de passe" required="">
                    <label>Premier emploi du temps</label>
                    <select class="form-control" name="modifYear">';
                    foreach ($years as $year) {
                        echo '<option value="'.$year['code'].'">'.$year['title'].'</option >';
                    }
                    echo'
                    </select>
                    <label>Deuxième emploi du temps (Optionel)</label>
                    <select class="form-control" name="modifGroup">';
                    foreach ($groups as $group){
                        echo '<option value="'.$group['code'].'">'.$group['title'].'</option>';
                    }
                    echo'
                    </select>
                    <label>Troisième emploi du temps (Optionel)</label>
                    <select class="form-control" name="modifHalfgroup">';
                    foreach ($halfgroups as $halfgroup){
                        echo '<option value="'.$halfgroup['code'].'">'.$halfgroup['title'].'</option>';
                    }
                    echo'
                    </select>
                    <button type="submit" class="btn btn-primary" name="createTv">Créer</button>
                </form>
            </div>
         </div>';
    }
}