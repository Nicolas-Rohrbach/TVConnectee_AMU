<?php
/**
 * Created by PhpStorm.
 * User: SFW
 * Date: 17/04/2019
 * Time: 11:35
 */

class ViewInformation extends ViewG
{
    /**
     * Affiche toute la page de gestions des informations
     * @param $id
     * @param $title
     * @param $author
     * @param $content
     * @param $creationDate
     * @param $endDate
     */
    public function displayInformationManagement($id, $title, $author, $content, $creationDate, $endDate) {
        echo '
        
           <form name="formInfo" method="post">
            <table class="table">
                    <tr>
                        <th></th>
                        <th>  Titre </th>
                        <th>  Auteur </th>
                        <th>  Contenu </th>
                        <th>  Date de création </th>
                        <th>  Date de fin </th>
                    </tr>';
       for($i=0; $i < sizeof($title); ++$i) {
           echo    '
                    <tr>
                        <td>'.$title[$i].'</td> 
                        <td>'.$author[$i].'</td>
                        <td>'.$content[$i].'</td>
                        <td>'.$creationDate[$i].'</td>
                        <td>'.$endDate[$i].'</td>
                        <td>
                            <div class="button_modif">
                                <label><button type="submit" value="modifier" name="changeInfo" class="btn btn-info"> Modifier </button></label>
                            </div>
                        </td>
                        <td>
                            <div class="radio">
                                <label><input type="radio" name="radioID" value="'.$id[$i].'" > </label>
                            </div>
                        </td>
                    </tr>';
       }
       echo  '</table> 
              </div>
           <button type="submit" value="supprimer" name="deleteInfo" class="btn btn-danger"> Supprimer </button>
            </form>';
    } //displayInformationManagement()


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
                    <form id="modify_info" method="get">
                  
                      Titre : <input type="text" name="titleInfo" value="'.$title.'" required> </br>
                      Contenu : <textarea name="contentInfo">'.$content.'</textarea> </br>
                      Ajouter une image : <button name="image" value="ajoutImage"> Ajouter </button> </br>
                      Date d\'expiration : <input type="date" name="endDateInfo" min="'.$dateMin.'" value = "'.$endDate.'" required > </br>
                      
                         <input type="submit" name="executeModifInfo" value="Modifier">
                 </form>
             
            </div>';
             

    }
}