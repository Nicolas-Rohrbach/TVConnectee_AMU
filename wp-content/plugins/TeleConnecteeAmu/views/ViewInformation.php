<?php
/**
 * Created by PhpStorm.
 * User: SFW
 * Date: 17/04/2019
 * Time: 11:35
 */

class ViewInformation
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
           <script src="/wp-content/plugins/TeleConnecteeAmu/views/js/formProcessing.js"></script>
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
                        <td>
                            <div class="radio">
                                <label><input type="radio" name="optradio" value="'.$id[$i].'" id="'.$id[$i].'" > </label>
                            </div>
                        </td>
                        <td>'.$title[$i].'</td> 
                        <td>'.$author[$i].'</td>
                        <td class="contentInfo">'.$content[$i].'</td>
                        <td>'.$creationDate[$i].'</td>
                        <td>'.$endDate[$i].'</td>
                    </tr>';
       }
       echo  '</table> 
              </div>
           <button type="submit" value="supprimer" name="Supprimer" onclick="formInformationDelete()" class="btn btn-danger"> Supprimer </button>
           <button type="submit" value="modifier" name="Modifier" onclick="formInformationChange()" class="btn btn-info"> modifier </button>
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

    public function displayInformationCreation(){
        echo '<form id="creation_info">
                  Titre : <input type="text" name="title" placeholder="Inserer un titre"> </br>
                  Contenu : <textarea name="content"> ...</textarea> </br>
                  Ajouter une image : <button name="image" value="ajoutImage"> Ajouter </button> </br>
                  Date d\'expiration : <input type="date"> </br>
                  <input type="submit" value="submit">
              </form>';
    }
}