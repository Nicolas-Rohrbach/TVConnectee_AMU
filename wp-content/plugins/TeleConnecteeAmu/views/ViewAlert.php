<?php
/**
 * Created by PhpStorm.
 * User: SFW
 * Date: 06/05/2019
 * Time: 11:01
 */

class ViewAlert extends ViewG
{
    /**
     * Display the creation form.
     */
    public function displayAlertCreationForm() {
        $dateMin = date('Y-m-d',strtotime("+1 day")); //date minimum pour la date d'expiration

        echo '
            <form id="creationAlert" method="post">
                   Contenu : <input type="text" name="content" required> <br>
                   Date d\'expiration : <input type="date" name="endDateAlert" min="'.$dateMin.'" required > </br>
                    <input type="submit" value="Créer" name="createAlert">
            </form>
        ';
    } //displayCreationForm();

    /**
     * Set the head of the table for the alert's management page.
     */
    public function tabHeadAlert(){
        $tab = ["Auteur","Contenu","Date de création","Date de fin"];
        $this->startTab($tab);
    }//tabHeadAlert();

    /**
     * Display the table of the management page, with delete and modify button.
     * @param $id
     * @param $author
     * @param $content
     * @param $creationDate
     * @param $endDate
     * @param $row
     */
    public function displayAllAlert($id, $author, $content, $creationDate, $endDate, $row){
        $tab = [$author, $content, $creationDate, $endDate];
        $this->displayAll($row, $id, $tab);
        echo '
          <td class="text-center"> <a href="http://'.$_SERVER['HTTP_HOST'].'/modification-alerte/'.$id.'" class="btn btn-primary btn-lg" name="modifetud" type="submit" value="Modifier">Modifier</a></td>
        </td>';
    } //displayAllAlert()

    /**
     * Display the modification form.
     * @param $content
     * @param $endDate
     */
    public function displayModifyAlertForm($content, $endDate)
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
    } //displayModifyAlertForm()

    public function displayAlertMain($content) {
        echo '
    <script src="js/jquery.easy-ticker.js"></script>
    <script src="js/jquery.min.js"></script>
    
    
        <div class="ticker1">
            <div class="innerWrap">
                <div class="list"> List 1 </div>
                <div class="list"> List 2 </div>
                <div class="list"> List 3 </div>
                <div class="list"> List 4 </div>
            </div>
        </div>
        
        <div class="ticker2">
            <ul>
                <li> List 1 </li>
                <li> List 2 </li>
                <li> List 3 </li>
                <li> List 4 </li>
            </ul>
        </div>
        
        <script>
            $(".ticker1, .ticker2").easyTicker({
                direction: "up",
                easing: "swing",
                speed: "slow",
                interval: 2000,
                height: "auto",
                visible: 0,
                mousePause: 1,
                controls: {
                    up: "",
                    down: "",
                    toggle: "",
                    playText: "Play",
                    stopText: "Stop"
                }
            });
        </script>
        ';
    }
}