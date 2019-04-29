<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 25/04/2019
 * Time: 10:46
 */

class ViewTelevision extends ViewG
{
    public function displayFormTelevision() {
        echo '
         <div class="cadre">
            <div align="center">
                <form method="post" id="registerform">
                    <label for="loginTv">Login</label>
                    <input type="text" class="form-control text-center modal-sm" name="loginTv" placeholder="Nom de compte" required="">
                    <label for="pwdTv">Mot de passe</label>
                    <input type="password" class="form-control text-center modal-sm" name="pwdTv" placeholder="Mot de passe" required="">
                    <label for="nameTv">Titre de télévision</label>
                    <input type="text" class="form-control text-center modal-sm" name="nameTv" placeholder="Titre" required="">
                    <label for="codeADE1">Emploi du temps (code ADE)</label>
                    <input type="text" class="form-control text-center modal-sm" name="codeADE1" placeholder="Code ADE" required="">
                    <label for="codeADE2">Emploi du temps 2</label>
                    <input type="text" class="form-control text-center modal-sm" name="codeADE2" placeholder="Code ADE2">
                    <label for="codeADE3">Emploi du temps 3</label>
                    <input type="text" class="form-control text-center modal-sm" name="codeADE3" placeholder="Code ADE3">
                    <button type="submit" class="btn btn-primary" name="createTv">Créer</button>
                </form>
            </div>
         </div>';
    }
}