<?php
/**
 * Created by PhpStorm.
 * User: s17018568
 * Date: 16/01/19
 * Time: 14:03
 */

class Card
{
	public function afficherCardFooter($titre, $user, $contenu, $date)
    	{
    		echo '
				<div class="flex-footer">
					<div class="auteurtitre-footer">
						<p class="titre-footer" id="changeTitre">
						</p>
						<div class="auteurdate-footer">
						<div class="parLe-footer" id="Par"></div>
							<p class="auteur-footer" id="changeAuteur">
							</p>
							<div class="parLe-footer" id="Le"></div>
							<p class="date-footer" id="changeDate">
							</p>
						</div>
					</div>
					<p class="informations-footer" id="changeContenu">
					</p>
				</div>
            	<input type="hidden" value="'.$user.'" id="user">
            	<input type="hidden" value="'.$titre.'" id="titre">
            	<input type="hidden" value="'.$contenu.'" id="leContenu">
				<input type="hidden" value="'.$date.'" id="date">

				<script>
            		var auteur = document.getElementById("user").value;
					var listAuteur = auteur.split("/");
					
    				var titre = document.getElementById("titre").value;
   				    var listTitre =  titre.split("/");
    
    				var contenu = document.getElementById("leContenu").value;
    				var listContenu =  contenu.split("/");
					
					var date = document.getElementById("date").value;
    				var listDate =  date.split("/");
    
					var counter = 0;
					var Par = "Par &nbsp;"
					var Le = "&nbsp le &nbsp;"
					document.getElementById("Par").innerHTML = Par ;
					document.getElementById("Le").innerHTML = Le ;
					var Titre = document.getElementById("changeTitre");
					var Auteur = document.getElementById("changeAuteur");
					var Contenu = document.getElementById("changeContenu");
					var Date = document.getElementById("changeDate");
					var inst = setInterval(change, 5000);
					

					function change() {
				    	Titre.innerHTML = listTitre[counter];
					    Auteur.innerHTML = listAuteur[counter];
					    Contenu.innerHTML = listContenu[counter];
					    Date.innerHTML = listDate[counter];
					    counter++;
					    if (counter >= listTitre.length-1) {
					  		counter = 0;
						    // clearInterval(inst); // uncomment this if you want to stop refreshing after one cycle
					    }
					}
				</script>';

    }
	
	public function afficherCardMobile($titre, $user, $contenu, $date)
    	{
//     		echo '<div>
// 					<div>
// 						<p id="changeTitreMobile">
// 						'.$titre.'
// 						</p>
// 						<div>
// 						<div id="ParMobile"></div>
// 							<p id="changeAuteurMobile">
// 							'.$user.'
// 							</p>
// 							<div id="LeMobile"></div>
// 							<p id="changeDateMobile">
// 							'.$date.'
// 							</p>
// 						</div>
// 					</div>
// 					<p id="changeContenuMobile">
// 					'.$contenu.'
// 					</p>
// 				</div>
//             	<input type="hidden" value="'.$user.'" id="userMobile">
//             	<input type="hidden" value="'.$titre.'" id="titreMobile">
//             	<input type="hidden" value="'.$contenu.'" id="leContenuMobile">
// 				<input type="hidden" value="'.$date.'" id="dateMobile">

// 				<script>
//             		var auteurMobile = document.getElementById("userMobile").value;
// 					var listAuteurMobile = auteurMobile.split("/");
					
//     				var titreMobile = document.getElementById("titreMobile").value;
//    				    var listTitreMobile =  titreMobile.split("/");
    
//     				var contenuMobile = document.getElementById("leContenuMobile").value;
//     				var listContenuMobile =  contenuMobile.split("/");
					
// 					var dateMobile = document.getElementById("dateMobile").value;
//     				var listDateMobile =  dateMobile.split("/");
    
// 					var cpt = 0;
// 					var ParMobile = "Par &nbsp;"
// 					var LeMobile = "&nbsp le &nbsp;"
// 					document.getElementById("ParMobile").innerHTML = ParMobile ;
// 					document.getElementById("LeMobile").innerHTML = LeMobile ;
// 					var TitreMobile = document.getElementById("changeTitreMobile");
// 					var AuteurMobile = document.getElementById("changeAuteurMobile");
// 					var ContenuMobile = document.getElementById("changeContenuMobile");
// 					var DateMobile = document.getElementById("changeDateMobile");
					

// 					function changer() {
// 				    	TitreMobile.innerHTML = listTitreMobile[cpt];
// 					    AuteurMobile.innerHTML = listAuteurMobile[cpt];
// 					    ContenuMobile.innerHTML = listContenuMobile[cpt];
// 					    DateMobile.innerHTML = listDateMobile[cpt];
// 					    cpt++;
// 					    if (cpt >= listTitreMobile.length-1) {
// 					  		cpt = 0;
// 						    // clearInterval(inst); // uncomment this if you want to stop refreshing after one cycle
// 					    }
// 					}
// 				</script>';

    	}	



    public function startFooter()
    {
        echo '
			<footer class="site-footer">';

    }

    public function endFooter()
    {
        echo '
			</footer>';
    }

    public function afficherCardPage($titre, $user, $contenu, $date, $id)
    {
        echo '
            <form action="#" method="post">
            <div class="col-sm-6">
                <div class="card text-white bg-dark" style="width: 18rem; height: auto; min-height: 25rem">
                        <div class="card-body text-center">
                            <h3 class="card-title font-weight-bold text-white">' . $titre . '</h3>
                             <p class="card-text font-italic">' . $contenu . '</p>
                         <p class="card-text">Posté par ' . $user . ' le ' . $date . '</p>
                         <a class="btn btn-light btn-lg btn-block" href="http://tv-connectee-amu.alwaysdata.net/affichageinfo/'.$id.'">Modifier</a>
                         <button class="btn btn-danger btn-lg btn-block" name="supprinfo" type="submit" value="Supprimer">Supprimer</button>
                         <input type="hidden" name="ident" value="'. $id .'">
                        </div>
                    </div>
                 </div>
                </form>';
    }

    public function creerLigne(){
        echo '<div class="row form-group"><br>';
    }

    public function fermerdiv(){
        echo'</div>';
    }

    public function ouvrirDiv(){
        echo'<div style="margin-left: 19%">';
    }

    public function affichage_ajout_info(){
        echo '
                    <form action="#" method="POST">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Titre</span>
                            </div>
                            <input name="titre" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" placeholder="Entrer le titre de l\'information à ajouter">
                        </div>
                        <div class="input-group  mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" >With textarea</span>
                            </div>
                            <textarea name="contenu" class="form-control" aria-label="With textarea" placeholder="Entrer des précisions sur l\'information à ajouter"></textarea>
                        </div>
                        <div class="input-group mb-3"> 
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Date</span>
                            </div>
                            <input name="date" type="date" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" placeholder="Entrer la date d\'expiration de votre information">
                        </div>
                          <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">Urgent</label>
                          </div>
                        <button name="envoyerform" type="submit" class="btn btn-primary btn-lg mb-3" value="Envoyer">Ajouter</button>
                    </form>';
    }
public function affichage_modif_info($titre, $contenu, $date){
echo '
            <form action="#" method="POST">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Titre</span>
                    </div>
                    <input name="modiftitre" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" placeholder="Entrer le titre de l\'information à ajouter" value="'.$titre.'">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Contenu</span>
                    </div>
                    <textarea name="modifcontenu" class="form-control" aria-label="Contenu" placeholder="Entrer des précisions sur l\'information à ajouter" >'.$contenu.'</textarea>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Date</span>
                    </div>
                    <input name="modifdate" type="date" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" placeholder="Entrer la date d\'expiration de votre information" value="'.$date.'">
                </div>
                <div class="form-check mb-3">
                      <input type="checkbox" class="form-check-input" id="exampleCheck1">
                      <label class="form-check-label" for="exampleCheck1">Urgent</label>
                </div>
                <button name="modifvalider" type="submit" class="btn btn-primary btn-lg mb-3" value="Valider">Valider</button>
            <a class="btn btn-dark btn-lg mb-3" href="http://tv-connectee-amu.alwaysdata.net">Annuler</a>
            </form>';
}

public function alertSuccess($strAlerte){
        echo '<div class="alert alert-success" role="alert">
                <strong>Well done!</strong> '.$strAlerte.' 
              </div>';
    }

}
