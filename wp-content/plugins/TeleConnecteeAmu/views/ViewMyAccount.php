<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 06/05/2019
 * Time: 08:42
 */

class ViewMyAccount extends ViewG
{
    public function displayVerifyPassword(){
        echo'
        <form method="post">
            <label for="verifPwd">Votre mot de passe actuel</label>
            <input type="password" class="form-control text-center modal-sm" name="verifPwd" placeholder="Mot de passe" required="">';
    }

    public function displayModifyPassword(){
        echo '
                <label for="newPwd">Votre nouveau mot de passe</label>
                <input type="password" class="form-control text-center modal-sm" name="newPwd" placeholder="Mot de passe" required="">
                <button type="submit" class="btn btn-primary" name="modifyMyPwd">Modifier</button>
            </form>';
    }

    public function displayDeleteAccount(){
        echo '
                <button type="submit" class="btn btn-primary" name="deleteMyAccount">Supprimer</button>
                </form>';
    }

    public function displayModificationValidate(){
        echo '<div class="alert alert-success" role="alert">La modification à été réussie !</div>';
    }

    public function displayWrongPassword(){
        echo '<div class="alert alert-danger"> Mauvais mot de passe </div>';
    }
}