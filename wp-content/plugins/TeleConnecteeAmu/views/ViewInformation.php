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
     * Set the head of the table for the information's management page.
     */
    public function tabHeadInformation(){
        $tab = ["Titre","Auteur","Contenu","Date de création","Date de fin"];
        $this->displayStartTab($tab);
    } //tabHeadInformation()


    /**
     * Display the table of the management page, with delete and modify button.
     * @param $id
     * @param $title
     * @param $author
     * @param $content
     * @param $creationDate
     * @param $endDate
     * @param $row
     */
    public function displayAllInformation($id, $title, $author, $content, $creationDate, $endDate, $row){
        $tab = [$title, $author, $content, $creationDate, $endDate];
        $this->displayAll($row, $id, $tab);
        echo '
              <td class="text-center"> <a href="http://'.$_SERVER['HTTP_HOST'].'/modification-information/'.$id.'" class="btn btn-primary btn-lg" name="modifetud" type="submit" value="Modifier">Modifier</a></td>
            </tr>';
}


    /**
     * Display information in main page with a carousel
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
                            <div class="carousel-inner">';
                                for($i=0; $i < sizeof($title); ++$i) {
                                    $var = ($cpt == 0) ? ' active">' : '">';
                                    echo '<div class="carousel-item' . $var.'
                                                <div class="title">'.$title[$i].' </div>
                                                <div class="content_info">'.$content[$i].'</div> 
                                           </div>';
                                    $cpt++;
                                }
                        echo'   </div>
                            </div>
                        </div>';
    } //displayInformationView()

    /**
     * Display information creation form
     */
    public function displayInformationCreation(){

        $dateMin = date('Y-m-d',strtotime("+1 day"));

            echo 'Quel type de contenu voulez vous pour votre information ? </br>

              <form method="post">
                <label> Texte : <input type="radio" name="typeChoice" value="text"></label></br>
                <label> Affiche : <input type="radio" name="typeChoice" value="image"></label></br>
                <label> Tableau de note : <input type="radio" name="typeChoice" value="tab"></label></br>
                <button type="submit"> Selectionner </button>
              </form>';


            $choice = $_POST['typeChoice'];
            if($choice == 'text'){
                echo '<form method="post">
                        Titre : <input type="text" name="titleInfo" placeholder="Inserer un titre" required maxlength="20"> </br>
                        Date d\'expiration : <input type="date" name="endDateInfo" min="'.$dateMin.'" required ></br>
                        Contenu : <textarea name="contentInfo" maxlength="200"></textarea> </br>
                        <input type="submit" value="creer" name="createText">
                      </form>';
            }
            elseif ($choice == 'image') {
                echo '<form method="post" enctype="multipart/form-data">
                        Titre : <input type="text" name="titleInfo" placeholder="Inserer un titre" required maxlength="20"> </br>
                        Date d\'expiration : <input type="date" name="endDateInfo" min="'.$dateMin.'" required ></br>
                        Ajouter une image :<input type="file" name="contentFile" /> </br>
                        <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
                         
                        <input type="submit" value="creer" name="createImg">
                      </form>';
            }
            elseif ($choice == 'tab') {
                echo '<form method="post">
                        Titre : <input type="text" name="titleInfo" placeholder="Inserer un titre" required maxlength="20"> </br>
                        Date d\'expiration : <input type="date" name="endDateInfo" min="'.$dateMin.'" required ></br>
                        
                        <input type="submit" value="creer" name="createTab">
                      </form>';
            }
            echo '<a href="http://wptv/gerer-les-informations/"> Page de gestion</a>';
    } //displayInformationCreation()


    /**
     * Display information modify form
     * @param $title
     * @param $content
     * @param $endDate
     */
    public function displayModifyInformationForm($title, $content, $endDate,$typeInfo){
        $dateMin = date('Y-m-d',strtotime("+1 day"));
        if($typeInfo == "text") {
            echo '
                <div>
                    <form id="modify_info" method="post">
                  
                      Titre : <input type="text" name="titleInfo" value="'.$title.'" required maxlength="20"> </br>
                      Contenu : <textarea name="contentInfo" maxlength="200">'.$content.'</textarea> </br>
                      Date d\'expiration : <input type="date" name="endDateInfo" min="'.$dateMin.'" value = "'.$endDate.'" required > </br>
                      <input type="submit" name="validateChange" value="Modifier" ">
                 </form>
                 <a href="http://wptv/gerer-les-informations/"> Page de gestion</a>
            </div>';
        }
        elseif ($typeInfo == "img"){
            echo '
                <div>
                    <form id="modify_info" method="post" enctype="multipart/form-data">
                      Titre : <input type="text" name="titleInfo" value="'.$title.'" required maxlength="20"> </br>
                      '.$content.' </br>
                       Changer l\'image :<input type="file" name="contentFile" /> </br>
                       <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
                      Date d\'expiration : <input type="date" name="endDateInfo" min="'.$dateMin.'" value = "'.$endDate.'" required > </br>
                       <input type="submit" name="validateChangeImg" value="Modifier"/>
                 </form>
               <a href="http://wptv/gerer-les-informations/"> Page de gestion</a>
            </div>';
        }
        elseif ($typeInfo == "tab"){
            echo 'Work in progress';
        } else { echo 'Désolé, une erreur semble être survenue.';}
    } //displayModifyInformationForm()

}