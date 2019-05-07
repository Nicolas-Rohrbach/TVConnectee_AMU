<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 06/05/2019
 * Time: 08:42
 */

class ViewMyAccount extends ViewG
{
    public function verifyPassword(){
        echo'
        <form method="post">
            <label for="verifPwd">Votre mot de passe actuel</label>
            <input type="password" class="form-control text-center modal-sm" name="verifPwd" placeholder="Mot de passe" required="">';
    }

    public function modifyPassword(){
        echo '
                <label for="newPwd">Votre nouveau mot de passe</label>
                <input type="password" class="form-control text-center modal-sm" name="newPwd" placeholder="Mot de passe" required="">
                <button type="submit" class="btn btn-primary" name="modifyMyPwd">Modifier</button>
            </form>';
    }

    public function modificationValidate(){
        echo '<div class="alert alert-success" role="alert">La modification à été réussie !</div>';
    }
}