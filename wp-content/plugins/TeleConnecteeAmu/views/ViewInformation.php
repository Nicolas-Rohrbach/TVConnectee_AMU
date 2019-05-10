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
        $this->startTab($tab);
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

        echo '<form id="creation_info" method="post">
                  Titre : <input type="text" name="titleInfo" placeholder="Inserer un titre" required> </br>
                  Contenu : <textarea name="contentInfo">...</textarea> </br>
                  Date d\'expiration : <input type="date" name="endDateInfo" min="'.$dateMin.'" required > </br>
                
                  <input type="submit" value="createInfo" name="createInfo">
              </form>
              ';
    } //displayInformationCreation()

//    /**
//     *
//     */
//    public function displayUploadFileForm(){
//        echo '<form action="" method="post" enctype="multipart/form-data">
//                Select image to upload:
//                <input type="file" name="fileToUpload" id="fileToUpload">
//                <input type="submit" value="Upload Image" name="submit">
//              </form>';
//    }

    /**
     * Display information modify form
     * @param $title
     * @param $content
     * @param $endDate
     */
    public function displayModifyInformationForm($title, $content, $endDate){
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
    } //displayModifyInformationForm()
}