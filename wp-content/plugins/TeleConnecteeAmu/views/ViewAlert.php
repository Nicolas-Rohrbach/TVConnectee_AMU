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
                   Contenu : <input type="text" name="content" required maxlength="140"> <br>
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
        $this->displayStartTab($tab);
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
          <td class="text-center"> <a href="http://'.$_SERVER['HTTP_HOST'].'/modification-alerte/'.$id.'" name="modifetud" type="submit" value="Modifier">Modifier</a></td>
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
                  
                      Contenu : <textarea name="contentInfo" maxlength="140">' . $content . '</textarea> </br>
                      Date d\'expiration : <input type="date" name="endDateInfo" min="' . $dateMin . '" value = "' . $endDate . '" required > </br>
                      
                         <input type="submit" name="validateChange" value="Valider" ">
                 </form>
            </div>';
    } //displayModifyAlertForm()

    /**
     * Display alerts in the main page with a scrolling effect.
     * @param $content
     */
    public function displayAlertMain($content) {
                echo '
        <div class="alerts" id="alert">
             <div class="ti_wrapper">
                <div class="ti_slide">
                    <div class="ti_content">';
                        for($i = 0; $i < sizeof($content); ++$i){
                            echo '<div class="ti_news"><span>' .$content[$i].'</span> </div>';
                        }
                        echo '
                    </div>
                </div>
            </div>
        </div>
        ';
    } //displayAlertMain()

}