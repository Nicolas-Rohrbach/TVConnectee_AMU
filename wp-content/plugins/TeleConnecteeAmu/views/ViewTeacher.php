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
                        <button class="dropdown-item button is-small is-fullwidth" type="submit" name="affichageprenom" value="prenom">Afficher par prénom</button>
                        <button class="dropdown-item button is-small is-fullwidth" type="submit" name="affichagenom" value="nom">Afficher par nom</button>
                            
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
                        <td class="text-center"><strong>Code ADE</strong></td>
                        <td class="text-center"><strong>Modifier</strong></td>
                        <td class="text-center"><strong>Supprimer </strong></td>
                    </tr>
                </thead>
            <tbody>
        ';
    }

    public function displayAllTeacher($firstname, $lastname, $code, $row, $id){
        $this->displayAll($row, $firstname, $lastname, $code, 0, 0, true);
        echo '
          <td class="text-center"> <a href="http://'.$_SERVER['HTTP_HOST'].'/gestion-des-utilisateurs/modification-utilisateur/'.$id.'" class="btn btn-primary btn-lg" name="modifprof" type="submit" value="Modifier">Modifier</a></td>
          <td class="text-center"> <button class="btn btn-danger btn-lg " name="supprprof" type="submit" value="'.$id.'" >Supprimer</button></td>
        </tr>';
    }

    public function displayModifyTeacher($nom, $prenom){
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
            <a class="btn btn-dark btn-lg mb-3" href="http://'.$_SERVER['HTTP_HOST'].'/gestion-des-utilisateurs">Annuler</a>
         </form>';
    }
}