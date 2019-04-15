<?php
/**
 * Created by PhpStorm.
 * User: s17018568
 * Date: 22/01/19
 * Time: 15:07
 */

class viewUser
{

    /**
     * viewUser constructor.
     */
    public function __construct()
    {
    }
    public function afficherInsert(){
        echo'
		<h1 style="font-size:50px ; color:#003E53;">Création des comptes</h1>
        <div style="width:100%; border-style:outset; border-width: 3px; border-color:#00688B; padding:5px; margin-top : 100px; margin-bottom : 100px; background-color: #99C2D0;">
			<div style="float:left;width:35%;margin-right: 0%; border-width: 4px; padding: 5px; min-width: 35%;border-style:outset;border-color:#003E53; padding-bottom:30px; padding-left:10px;padding-right:10px;display: block;margin : auto; background-color: #D6E6EC;">
				  <h2 class="display-2 text-black-50" style="font-size:25px; color:#00688B; text-align:center;">Créer des comptes étudiants</h2>
				  <a href="http://tv-connectee-amu.alwaysdata.net/wp-content/plugins/TeleConnecteeAmu/Excel/vide.xlsx"
   download="exempleExcelEtu">Fichier modèle à remplir</a>
					   <form method="post" enctype="multipart/form-data">
							<input type="file" name="excelEtud" class="btn btn-dark" style="text-align : center";/>
							<button type="submit" name="importEtu" class="btn btn-primary" value="Importer">Importer le fichier</button>
					   </form>
			</div>
			<div style="margin-left:60%; width="80%">
				<img src="https://image.noelshack.com/fichiers/2019/09/4/1551391861-exempleetu.png">
				<TABLE border="1" width="100%" class="table" style="background-color: #D6E6EC;">
					<TR>
						<TD width="50%">Le numéro ENT correspond au numéro ent de l\'étudiant
						<TD width="50%">L\'email correspond à l\'email AMU de l\'étudiant
					<TR>
						<TD width="50%">La colonne alternant prends 1 si l\'étudiant est alternant, 0 sinon
						<TD width="50%">La colonne langue correspond à la langue secondaire de l\'étudiant
				</TABLE>
			</div>
		</div>
		
		 <div style="width:100%; border-style:outset; border-width: 3px; border-color:#00688B; padding:5px; background-color: #99C2D0;">
			<div style="float:left;width:35%;margin-right: 0%; border-width: 4px; padding: 5px; min-width: 35%;border-style:outset;border-color:#003E53; padding-bottom:30px; padding-left:10px;padding-right:10px;display: block;margin : auto;background-color: #D6E6EC">
				 <h2 class="display-2 text-black-50" style="font-size:25px; color:#00688B; text-align:center;">Créer des comptes professeurs</h2>
			       <a href="http://tv-connectee-amu.alwaysdata.net/wp-content/plugins/TeleConnecteeAmu/Excel/profVide.xlsx"
   download="exempleExcelProfs">Fichier modèle à remplir</a>
				   <form method="post" enctype="multipart/form-data">
			       <input type="file" name="excelProf" id="file" class="btn btn-dark" />
				   <button type="submit" name="importProf" class="btn btn-primary" value="Importer" > Importer le fichier</button> 
			   </form>
		  </div> 
	   	<div style="margin-left:60%; width="80%">
					<img src="https://image.noelshack.com/fichiers/2019/09/4/1551391861-exempleprof.png" height="400" width="700">
					<TABLE border="1" width="100%" class="table" style="background-color: #D6E6EC;">
						<TR>
							<TD width="50%">Le numéro ENT correspond au numéro ent du professeur
							<TD width="50%">L\'email correspond à l\'email AMU du professeur
						<TR>
							<TD width="50%">Le code corespond au numéros attribués au professeur sur l\'emploi du temps ADE
					</TABLE>
				</div>
			</div>
			 ';
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
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom</th>
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
      <td class="text-center">'.$nom.'</td>
      <td class="text-center">'.$prenom.'</td>    
      <td class="text-center">'.$annee.'</td>
      <td class="text-center">'.$groupe.'</td>
      <td class="text-center"> <a href="http://tv-connectee-amu.alwaysdata.net/modifier-un-etudiant/'.$id.'" class="btn btn-primary btn-lg" name="modifetud" type="submit" value="Modifier">Modifier</a></td>
      <td class="text-center"> <button class="btn btn-danger btn-lg " name="suppretud" type="submit" value="'.$id.'" >Supprimer</button></td>
    </tr>
        ';
    }

    public function endTab(){
        echo'
          </tbody>
        </table>
        </form>
        ';
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
            <a class="btn btn-dark btn-lg mb-3" href="http://tv-connectee-amu.alwaysdata.net">Annuler</a>
            </form>';
    }

    public function refreshEtud(){
        echo ' <meta http-equiv="refresh" content="0; url=http://tv-connectee-amu.alwaysdata.net/supprimer-des-etudiants/" />';
    }

    public function refreshProf(){
        echo ' <meta http-equiv="refresh" content="0; url=http://tv-connectee-amu.alwaysdata.net/professeurs/" />';
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
                    <td class="text-center"><strong>Nom</strong></td>
                    <td class="text-center"><strong>Prénom</strong></td>
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
      <td class="text-center">'.$nom.'</td>
      <td class="text-center">'.$prenom.'</td>    
      <td class="text-center"> <a href="http://tv-connectee-amu.alwaysdata.net/modifier-un-prof/'.$id.'" class="btn btn-primary btn-lg" name="modifprof" type="submit" value="Modifier">Modifier</a></td>
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
            <a class="btn btn-dark btn-lg mb-3" href="http://tv-connectee-amu.alwaysdata.net">Annuler</a>
            </form>';
    }


}