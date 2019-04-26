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
     * Affiche toute la liste des informations présente dans la BD
     * @param $id
     * @param $title
     * @param $author
     * @param $content
     * @param $creationDate
     * @param $endDate
     */
    public function displayInformationList($id, $title, $author, $content, $creationDate, $endDate) {
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
    } //displayInformationList()


    public function displayInformationView($title, $content){
        $cpt = 0;
        echo '<div class="container-fluid">
                <div class="row">
                    <div id="information" class="col-sm-5">
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


    }


//    public function displayChangeInfo($title, $content, $endDate) {
//        echo '
//            <form action="#" method="POST">
//                <div class="input-group mb-3">
//                    <div class="input-group-prepend">
//                        <span class="input-group-text" id="inputGroup-sizing-default">Titre</span>
//                    </div>
//                    <input name="modiftitre" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" placeholder="Entrer le titre de l\'information à ajouter" value="'.$title.'">
//                </div>
//                <div class="input-group mb-3">
//                    <div class="input-group-prepend">
//                        <span class="input-group-text">Contenu</span>
//                    </div>
//                    <textarea name="modifcontenu" class="form-control" aria-label="Contenu" placeholder="Entrer des précisions sur l\'information à ajouter" >'.$content.'</textarea>
//                </div>
//                <div class="input-group mb-3">
//                    <div class="input-group-prepend">
//                        <span class="input-group-text" id="inputGroup-sizing-default">Date</span>
//                    </div>
//                    <input name="modifdate" type="date" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" placeholder="Entrer la date d\'expiration de votre information" value="'.$endDate.'">
//                </div>
//                <div class="form-check mb-3">
//                      <input type="checkbox" class="form-check-input" id="exampleCheck1">
//                      <label class="form-check-label" for="exampleCheck1">Urgent</label>
//                </div>
//                <button name="modifvalider" type="submit" class="btn btn-primary btn-lg mb-3" value="Valider">Valider</button>
//            <a class="btn btn-dark btn-lg mb-3" href="http://tv-connectee-amu.alwaysdata.net">Annuler</a>
//            </form>';
//    } //displayChangeInfo()
}