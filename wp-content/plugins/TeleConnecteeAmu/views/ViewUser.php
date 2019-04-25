<?php
/**
 * Created by PhpStorm.
 * User: s17018568
 * Date: 22/01/19
 * Time: 15:07
 */

class viewUser
{

    public function afficherInsertEtudiant(){
        echo'
             <form method="post" enctype="multipart/form-data">
				<input type="file" name="excelEtud" class="btn btn-dark"/>
				<br/>
				<button type="submit" name="importEtu" class="btn btn-primary" value="Importer">Importer le fichier</button>
			</form>
			<br/>';
    }

    public function  affichierInsertProf() {
        echo'
             <form method="post" enctype="multipart/form-data">
			    <input type="file" name="excelProf" id="file" class="btn btn-dark" />
			    <br/>
				<button type="submit" name="importProf" class="btn btn-primary" value="Importer" > Importer le fichier</button> 
			 </form>
			 <br/>';
    }

    public function displayFormTele() {
        echo '
 <div class="cadre">
 <div align="center">
    <form method="post" id="registerform">
          <label for="nameTv">Titre de télévision</label>
          <input type="text" class="form-control text-center modal-sm" name="nameTv" placeholder="Titre" required="">
          <label for="pwdTv">Mot de passe</label>
          <input type="password" class="form-control text-center modal-sm" name="pwdTv" placeholder="Mot de passe" required="">
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

    public function displayFormSecre() {
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
        <input type="text" class="form-control text-center modal-sm" name="lastnameSecre" placeholder="Nom">
      <button type="submit" class="btn btn-primary" name="createSecre">Créer</button>
    </form>
    </div>
</div>';
    }

    public function tabHeadEtud(){
        echo '
        <head>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css">
        </head>
         <form action="#" method="post">
            <nav class="navbar" role="navigation" aria-label="main navigation">
              <div class="navbar-brand">
                <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                  <span aria-hidden="true"></span>
                  <span aria-hidden="true"></span>
                  <span aria-hidden="true"></span>
                </a>
              </div>
            
              <div id="navbarBasicExample" class="navbar-menu">
                <div class="navbar-start">
            
                  <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                      Option d\'affichage
                    </a>
            
                    <div class="navbar-dropdown">
                            <button class="dropdown-item button is-small is-fullwidth" type="submit" name="affichagenom" value="nom">Afficher par nom</button>
                            <button class="dropdown-item button is-small is-fullwidth" type="submit" name="affichageprenom" value="prenom">Afficher par prénom</button>
                    </div>
                  </div>
                  <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                      Affichage par groupe
                    </a>
            
                    <div class="navbar-dropdown">
                             <button class="dropdown-item button is-small is-fullwidth" type="submit" name="affichageannee1" value="annee1">Année 1</button>
                            <button class="dropdown-item button is-small is-fullwidth" type="submit" name="affichageannee2" value="annee2">Année 2</button>
                            <button class="dropdown-item button is-small is-fullwidth" type="submit" name="affichagelicence" value="licence">Licence Pro</button>
                    </div>
                  </div>
                </div>
              </div>
            </nav>
        </form>
        <form method="post">
        <table class="table text-center"> 
            <thead>
                <tr class="text-center">
                    <th scope="col">#</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Année</th>
                    <th scope="col">Groupe</th>
                    <th scope="col">Modifier</th>
                    <th scope="col">Supprimer</th>
                 </tr>
            </thead>
            <tbody>
        ';
    }

    public function afficherSupprEtud($nom,$prenom, $annee, $groupe,  $row, $id){
        echo '
    <tr>
      <th scope="row">'.$row.'</th>
      <td class="text-center">'.$prenom.'</td>
      <td class="text-center">'.$nom.'</td>
      <td class="text-center">'.$annee.'</td>
      <td class="text-center">'.$groupe.'</td>
      <td class="text-center"> <a href="http://'.$_SERVER['HTTP_HOST'].'/modifier-lutilisateur/'.$id.'" class="btn btn-primary btn-lg" name="modifetud" type="submit" value="Modifier">Modifier</a></td>
      <td class="text-center"> <button class="btn btn-danger btn-lg " name="suppretud" type="submit" value="'.$id.'" >Supprimer</button></td>
    </tr>';
    }

    public function endTab(){
        echo'
          </tbody>
        </table>
        </form>';
    }

    public function affichageModifEtud($nom, $prenom, $annee, $groupe){
        echo '
         <form action="#" method="post">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Nom</span>
                    </div>
                    <input name="modifnom" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" placeholder="Entrer le titre de linformation à ajouter" value="'.$nom.'">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Prenom</span>
                    </div>
                    <input name="modifprenom" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" placeholder="Entrer le titre de linformation à ajouter" value="'.$prenom.'">
                </div>
                <div class="form-group">
                <label for="exampleFormControlSelect1">Selectionner une année</label>
                    <select class="form-control" name="modifannee">
                          <option>'.$annee.'</option>
                          <option>1</option>
                          <option>2</option>
                          <option>Licence Professionnelle</option>
                    </select>
              </div>
                <div class="form-group">
                <label for="exampleFormControlSelect1">Selectionner un groupe</label>
                    <select class="form-control" name="modifgroupe">
                          <option>'.$groupe.'</option>
                          <option>1</option>
                          <option>2</option>
                          <option>3</option>
                          <option>4</option>
                          <option>5</option>
                    </select>
              </div>
                <button name="modifvalider" type="submit" class="btn btn-primary btn-lg mb-3" value="Valider">Valider</button>
            <a class="btn btn-dark btn-lg mb-3" href="http://'.$_SERVER['HTTP_HOST'].'">Annuler</a>
         </form>';
    }

    public function refreshPage(){
        echo '<meta http-equiv="refresh" content="0">';
    }

    public function tabHeadProf(){
        echo '
        <head>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css">
        </head>
         <form action="#" method="post">
            <nav class="navbar" role="navigation" aria-label="main navigation">
              <div class="navbar-brand">
                <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                  <span aria-hidden="true"></span>
                  <span aria-hidden="true"></span>
                  <span aria-hidden="true"></span>
                </a>
              </div>
            
              <div id="navbarBasicExample" class="navbar-menu">
                <div class="navbar-start">
            
                  <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                      Option d\'affichage
                    </a>
            
                    <div class="navbar-dropdown">
                            <button class="dropdown-item button is-small is-fullwidth" type="submit" name="affichagenom" value="nom">Afficher par nom</button>
                            <button class="dropdown-item button is-small is-fullwidth" type="submit" name="affichageprenom" value="prenom">Afficher par prénom</button>
                    </div>
                  </div>
                </div>
              </div>
            </nav>
        </form>
        <form method="post">
        <table class="table"> 
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <td class="text-center"><strong>Prénom</strong></td>
                    <td class="text-center"><strong>Nom</strong></td>
                    <td class="text-center"><strong>Modifier</strong></td>
                    <td class="text-center"><strong>Supprimer </strong></td>
                 </tr>
            </thead>
            <tbody>
        ';
    }

    public function afficherSupprProf($nom,$prenom,  $row, $id){
        echo '
    <tr>
      <th scope="row">'.$row.'</th>
      <td class="text-center">'.$prenom.'</td>
      <td class="text-center">'.$nom.'</td>
      <td class="text-center"> <a href="http://'.$_SERVER['HTTP_HOST'].'/modifier-un-prof/'.$id.'" class="btn btn-primary btn-lg" name="modifprof" type="submit" value="Modifier">Modifier</a></td>
      <td class="text-center"> <button class="btn btn-danger btn-lg " name="supprprof" type="submit" value="'.$id.'" >Supprimer</button></td>
    </tr>
        ';
    }

    public function affichageModifProf($nom, $prenom){
        echo '
         <form action="#" method="post">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Nom</span>
                    </div>
                    <input name="modifnom" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" placeholder="Entrer le titre de linformation à ajouter" value="'.$nom.'">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Prenom</span>
                    </div>
                    <input name="modifprenom" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" placeholder="Entrer le titre de linformation à ajouter" value="'.$prenom.'">
                </div>
                <button name="modifvalider" type="submit" class="btn btn-primary btn-lg mb-3" value="Valider">Valider</button>
            <a class="btn btn-dark btn-lg mb-3" href="http://'.$_SERVER['HTTP_HOST'].'">Annuler</a>
            </form>';
    }

    public function displayAllTv($row ,$name, $code,  $code2, $code3, $id){
        echo '
    <tr>
      <th scope="row">'.$row.'</th>
      <td class="text-center">'.$name.'</td>    
      <td class="text-center">'.$code.'</td>';
        if($code2 > 0) echo '<td class="text-center">'.$code2.'</td>';
        if($code3 > 0) echo '<td class="text-center">'.$code3.'</td>';
        echo '
      <td class="text-center"> <a href="http://'.$_SERVER['HTTP_HOST'].'/modifier-une-tv/'.$id.'" class="btn btn-primary btn-lg" name="modifyTv" type="submit" value="Modifier">Modifier</a></td>
      <td class="text-center"> <button class="btn btn-danger btn-lg " name="deleteTv" type="submit" value="'.$id.'" >Supprimer</button></td>
    </tr>
        ';
    }

    public function displayModifyTv($name, $code, $code2, $code3){
        echo '
         <form action="#" method="post">
            <label for="newTitleTv"> Titre </label>
            <input name="newTitleTv" type="text" class="form-control" placeholder="Titre" value="'.$name.'">
            <label for="newCode1"> Code 1 </label>
            <input name="newCode1" type="text" class="form-control" placeholder="Code ADE 1" value="'.$code.'">
            <label for="newCode2"> Code 2 </label>
            <input name="newCode2" type="text" class="form-control" placeholder="Code ADE 2" value="'.$code2.'">
            <label for="newCode3"> Code 3 </label>
            <input name="newCode3" type="text" class="form-control" placeholder="Code ADE 3" value="'.$code3.'">
            <button name="modifyValidate" type="submit" class="btn btn-primary btn-lg mb-3" value="Valider">Valider</button>
            <a class="btn btn-dark btn-lg mb-3" href="http://'.$_SERVER['HTTP_HOST'].'/gestions-des-tvs">Annuler</a>
         </form>';
    }
}