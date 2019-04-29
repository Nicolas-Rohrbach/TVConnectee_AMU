<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 25/04/2019
 * Time: 10:44
 */

class ViewStudent extends ViewG
{
    public function displayInsertImportFileStudent() {
        $this->displayInsertImportFile("Etu");
    }

    public function tabHeadStudent(){
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
                        <th scope="col">Demi groupe</th>
                        <th scope="col">Modifier</th>
                        <th scope="col">Supprimer</th>
                     </tr>
                </thead>
                <tbody>
        ';
    }

    public function displayAllStudent($firstname, $lastname, $year, $group, $halfgroup, $row, $id){
        $this->displayAll($row ,$firstname, $lastname, $year,  $group, $halfgroup, false);
        echo '
          <td class="text-center"> <a href="http://'.$_SERVER['HTTP_HOST'].'/gestion-des-utilisateurs/modification-utilisateur/'.$id.'" class="btn btn-primary btn-lg" name="modifetud" type="submit" value="Modifier">Modifier</a></td>
          <td class="text-center"> <button class="btn btn-danger btn-lg " name="suppretud" type="submit" value="'.$id.'" >Supprimer</button></td>
        </tr>';
    }

    public function displayModifyStudent($nom, $prenom, $annee, $groupe, $demiGroupe){
        echo '
         <form method="post">
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
              <div class="form-group">
                <label for="exampleFormControlSelect1">Selectionner un demi groupe</label>
                    <select class="form-control" name="modifdemigroupe">
                          <option>'.$demiGroupe.'</option>
                          <option>A</option>
                          <option>B</option>
                    </select>
              </div>
              <input name="modifvalider" type="submit" value="Valider">
              <button name="modifvalider"  type="submit" class="btn btn-primary btn-lg mb-3" value="Valider">Valider</button>
            <a class="btn btn-dark btn-lg mb-3" href="http://'.$_SERVER['HTTP_HOST'].'/gestion-des-utilisateurs">Annuler</a>
         </form>';
    }
}