<?php
/**
 * Created by PhpStorm.
 * User: SFW
 * Date: 17/04/2019
 * Time: 11:35
 */

class ViewInformation extends ViewG
{
    public function tabHeadInformation(){
        $tab = ["Titre","Auteur","Contenu","Date de création","Date de fin"];
        $this->startTab($tab);
    }


public function displayAllInformation($result, $title, $author, $content, $creationDate, $endDate, $row){
    $tab = [$title, $author, $content, $creationDate, $endDate];
    $this->displayAll($row, $result['ID_Info'], $tab);
    echo '
          <td class="text-center"> <a href="http://'.$_SERVER['HTTP_HOST'].'/modification-information/'.$result['ID_info'].'" class="btn btn-primary btn-lg" name="modifetud" type="submit" value="Modifier">Modifier</a></td>
        </tr>';
}


    /**
     * Affiche les informations sur la page d'accueil avec un carousel
     * @param $title
     * @param $content
     */
    public function displayInformationView($title, $content){
        $cpt = 0;
        echo '<div class="container-fluid">
                <div class="row">
                    <div id="information_carousel" class="col-sm-5">
                        <div id="demo" class="carousel slide" data-ride="carousel">
                            
                            <!--The slides -->
                            <div class="carousel-inner">
';
                                for($i=0; $i < sizeof($title); ++$i) {
                                    $var = ($cpt == 0) ? ' active">' : '">';
                                    echo '<div class="carousel-item' . $var.'
                                                <div class="title">'.$title[$i].' </div>
                                                <div class="content_info">'.$content[$i].'</div> 
                                           </div>';
                                    $cpt++;
                                }
echo'                        </div>
                            </div>
                        </div>';
    } //DisplayInformationView()

    /**
     * Affiche le formulaire de création d'une information.
     */
    public function displayInformationCreation(){
        $dateMin = date('Y-m-d',strtotime("+1 day"));
        echo '<form id="creation_info" method="post">
                  Titre : <input type="text" name="titleInfo" placeholder="Inserer un titre" required> </br>
                  Contenu : <textarea name="contentInfo">...</textarea> </br>
                  Ajouter une image : <button name="image" value="ajoutImage"> Ajouter </button> </br>
                  Date d\'expiration : <input type="date" name="endDateInfo" min="'.$dateMin.'" required > </br>
                  <input type="submit" value="createInfo" name="createInfo">
              </form>';
    } //displayInformationCreation()



    public function displayModifyInformationForm($title,$content,$endDate){
        $dateMin = date('Y-m-d',strtotime("+1 day"));
        echo '
                <div>
                    <form id="modify_info" method="post">
                  
                      Titre : <input type="text" name="titleInfo" value="'.$title.'" required> </br>
                      Contenu : <textarea name="contentInfo">'.$content.'</textarea> </br>
                      Ajouter une image : <button name="image" value="ajoutImage"> Ajouter </button> </br>
                      Date d\'expiration : <input type="date" name="endDateInfo" min="'.$dateMin.'" value = "'.$endDate.'" required > </br>
                      
                         <input type="submit" name="validateChange" value="Valider" ">
                 </form>
            </div>';

             

    }
}