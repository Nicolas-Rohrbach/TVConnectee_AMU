<?php
/**
 * Created by PhpStorm.
 * User: SFW
 * Date: 06/05/2019
 * Time: 11:01
 */

class ViewAlert extends ViewG
{
    public function displayAlertCreationForm() {
        $dateMin = date('Y-m-d',strtotime("+1 day")); //date minimum pour la date d'expiration

        echo '
            <form id="creationAlert" method="post">
                   Contenu : <input type="text" name="content" required> <br>
                   Date d\'expiration : <input type="date" name="endDateAlert" min="'.$dateMin.'" required > </br>
                    <input type="submit" value="Créer" name="createAlert">
            </form>
        ';
    }

    public function tabHeadAlert(){
        $tab = ["Auteur","Contenu","Date de création","Date de fin"];
        $this->startTab($tab);
    }

    public function displayAllAlert($id, $author, $content, $creationDate, $endDate, $row){
        $tab = [$author, $content, $creationDate, $endDate];
        $this->displayAll($row, $id, $tab);
        echo '
          <td class="text-center"> <a href="http://'.$_SERVER['HTTP_HOST'].'/modification-alert/'.$id.'" class="btn btn-primary btn-lg" name="modifAlert" type="submit" value="Modifier">Modifier</a></td>
        </tr>';
    }

    public function displayModifyAlertForm($content,$endDate)
    {
        $dateMin = date('Y-m-d', strtotime("+1 day"));
        echo '
                <div>
                    <form id="modify_alert" method="post">
                  
                      Contenu : <textarea name="contentInfo">' . $content . '</textarea> </br>
                      Date d\'expiration : <input type="date" name="endDateInfo" min="' . $dateMin . '" value = "' . $endDate . '" required > </br>
                      
                         <input type="submit" name="validateChange" value="Valider" ">
                 </form>
            </div>';
    }
}