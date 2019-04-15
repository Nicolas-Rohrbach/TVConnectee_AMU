<?php
/**
 * Created by PhpStorm.
 * User: s17018568
 * Date: 16/01/19
 * Time: 14:06
 */

class Info
{
    private $bdInfo;
    private $card;

    /**
     * Info constructor.
     */

    public function __construct(){
        $this->bdInfo = new BdInfo();
        $this->card = new ViewCard();
    }

    public function traitement_formulaire_info($action, $titre, $contenu, $date){
        $this->card->affichage_ajout_info();
        if ($action === 'Envoyer') {
            $this->bdInfo->insererInfo($titre, $contenu, $date);
            $this->card->alertSuccess("Info ajoutée avec succès ! ");
        }
    }


    public function affichage_infos_footer()
    {

        $result = $this->bdInfo->getInfos();
		
		$this->card->startFooter();
		
		$listContenu = '';
		$listTitre = '';
		$listUser = '';
		$listDate = '';

        foreach ($result as $row) {
				
            $titre = $row['titre'];
            $contenu = $row['contenu'];
            $date = date('d-m-Y',strtotime($row['date']));
            $user = $row['name'];
            $role = $row['role'];
			$listContenu .= $contenu . '/' ;
			$listTitre .= $titre . '/' ;
			$listUser  .=  $user . '/' ;
			$listDate .= $date . '/' ;

        }
		
		$this->card->afficherCardFooter($listTitre,$listUser,$listContenu,$listDate);
		
		$this->card->endFooter();
		
	}
	
	public function affichage_infos_mobile()
    {

      $result = $this->bdInfo->getInfos();

        $listContenu = '';
    	$listTitre = '';
		$listUser = '';
		$listDate = '';

        foreach ($result as $row) {

            $titre = $row['titre'];
            $contenu = $row['contenu'];
            $date = date('d-m-Y',strtotime($row['date']));
            $user = $row['name'];
            $role = $row['role'];
 			$listContenu .= $contenu . '/';
 			$listTitre .= $titre . '/';
			$listUser  .=  $user . '/' ;
			$listDate .= $date . '/' ;

//			echo '<div class="banniere-mobile">
//					<div class="flex-mobile">
//						<div class="auteurtitre-mobile" style="margin-top: 1%; margin-right: 2%;">
//							<p class="titre-mobile" id="changeTitreMobile" style="margin-bottom: 1%;">
//							'.$titre.'
//							</p>
//							<div class="auteurdate-mobile">
//							<div class="parLe-mobile" id="ParMobile">Par &nbsp</div>
//								<p class="auteur-mobile" id="changeAuteurMobile">
//								'.$user.'
//								</p>
//								<div class="parLe-mobile" id="LeMobile">&nbsp le &nbsp</div>
//								<p class="date-mobile" id="changeDateMobile">
//								'.$date.'
//								</p>
//							</div>
//						</div>
//						<p class="informations-mobile" id="changeContenuMobile" style="margin-top: 1.3%;">
//						'.$contenu.'
//						</p>
//					</div>
//				</div>';
    	}
		
    }
	
    public function affichage_infos_pages(){

        $current_user = wp_get_current_user();

        if ( isset($current_user) ) {
            $user = $current_user->user_login;
        }

        $result = $this->bdInfo->getInfosUser($user);

        $cpt = 0;
        $this->card->ouvrirDiv();

        foreach($result as $row){

            $titre = $row['titre'];
            $contenu = $row['contenu'];
            $date = $row['date'];
            $user = $row['name'];
            $id = $row['id'];

            if($cpt === 0){
                $this->card->creerLigne();
                $this->card->afficherCardPage($titre,$user,$contenu,$date, $id);
            }
            elseif ($cpt % 3 === 0){
                $this->card->fermerdiv();
                $this->card->creerLigne();
                $this->card->afficherCardPage($titre,$user,$contenu,$date, $id);
            }
            else{
                $this->card->afficherCardPage($titre,$user,$contenu,$date, $id);
            }
            ++$cpt;
        }

        $this->card->fermerdiv();
    }

    public function suppr_info($action, $id){
        if($action === 'Supprimer'){
            $this->bdInfo->supprInfos($id);
            $this->card->alertSuccess("Info supprimée avec succès ! ");
        }
    }

    public function modifier_info($action, $titre, $contenu, $date){

        $adresse = $_SERVER['REQUEST_URI'];
        $id =  '';

        for($i = 1; $i < strlen($adresse); ++$i){
            if($adresse[$i] === '/'){
                for($j = $i + 1; $j < strlen($adresse) - 1; ++$j){
                    $id .= $adresse[$j];
                }
            }
        }

        $result = $this->bdInfo->getUneInfo($id);
        $this->card->affichage_modif_info($result['titre'], $result['contenu'], $result['date']);

        if($action === 'Valider'){
            $this->bdInfo->supprInfos($id);
            $this->bdInfo->insererInfo($titre, $contenu, $date);
            $this->card->alertSuccess("Info modifiée avec succès ! ");
        }
    }

}