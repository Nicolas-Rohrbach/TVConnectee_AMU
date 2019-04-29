<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 25/04/2019
 * Time: 10:52
 */

class ViewSecretary extends ViewG
{
    public function displayFormSecretary() {
        echo '
         <div class="cadre">
             <div align="center">
                <form method="post" id="registerform">
                    <label for="nameSecre">Login</label>
                    <input type="text" class="form-control text-center modal-sm" name="loginSecre" placeholder="Login" required="">
                    <label for="pwdSecre">Mot de passe</label>
                    <input type="password" class="form-control text-center modal-sm" name="pwdSecre" placeholder="Mot de passe" required="">
                    <label for="firstnameSecre">Prénom</label>
                    <input type="text" class="form-control text-center modal-sm" name="firstnameSecre" placeholder="Prénom" required="">
                    <label for="lastnameSecre">Nom</label>
                    <input type="text" class="form-control text-center modal-sm" name="lastnameSecre" placeholder="Nom" required="">
                    <label for="emailSecre">Email</label>
                    <input type="email" class="form-control text-center modal-sm" name="emailSecre" placeholder="Email" required="">
                  <button type="submit" class="btn btn-primary" name="createSecre">Créer</button>
                </form>
            </div>
         </div>';
    }
}