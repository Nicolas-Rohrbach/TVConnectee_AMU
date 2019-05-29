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
          <div class="cadre">
            <form method="post">
                <label for="verifPwd">Votre mot de passe actuel</label>
                <input type="password" class="form-control text-center" name="verifPwd" placeholder="Mot de passe" required="">';
    }

    public function displayModifyPassword(){
        echo '
                <label for="newPwd">Votre nouveau mot de passe</label>
                <input type="password" class="form-control text-center" name="newPwd" placeholder="Mot de passe" required="">
                <button type="submit" name="modifyMyPwd">Modifier</button>
            </form>
          </div>';
    }

    public function displayDeleteAccount(){
        echo '
                <button type="submit" name="deleteMyAccount">Confirmer</button>
                </form>
                </div>';
    }

    public function displayModificationValidate(){
        echo '<div class="alert alert-success" role="alert">La modification à été réussie !</div>';
    }

    public function displayWrongPassword(){
        echo '<div class="alert alert-danger"> Mauvais mot de passe </div>';
    }

    public function displayMailSend(){
        echo '<div class="alert alert-success"> Un mail a été envoyé à votre adresse mail, merci de bien vouloir entrer le code reçu</div>';
    }

    public function displayEnterCode(){
        echo '
      <div class="cadre">
        <form method="post">
            <label for="codeDelete"> Code de suppression de compte</label>
            <input type="text" class="form-control text-center" name="codeDelete" placeholder="Code à rentrer" required="">
            <button type="submit" name="deleteAccount">Supprimer</button>
        </form>
      </div>';
    }
}