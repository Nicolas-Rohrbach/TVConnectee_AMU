<?php
/**
 * Created by PhpStorm.
 * User: Léa Arnaud
 * Date: 17/04/2019
 * Time: 11:35
 */

class ViewInformation extends ViewG
{
    /**
     * Ajoute le haut du tableau de gestion des informations
     */
    public function tabHeadInformation()
    {
        $tab = ["Titre", "Auteur", "Contenu", "Date de création", "Date de fin"];
        $this->startTab($tab);
    } //tabHeadInformation()


    /**
     * Affiche la page de gestion des informations
     * @param $id
     * @param $title
     * @param $author
     * @param $content
     * @param $creationDate
     * @param $endDate
     * @param $row
     */
    public function displayAllInformation($id, $title, $author, $content, $creationDate, $endDate, $row)
    {
        $tab = [$title, $author, $content, $creationDate, $endDate];
        $this->displayAll($row, $id, $tab);
        echo '
              <td class="text-center"> <a href="http://' . $_SERVER['HTTP_HOST'] . '/modification-information/' . $id . '" 
              class="btn btn-primary btn-lg" name="modifetud" type="submit" value="Modifier">Modifier</a></td>
            </tr>';
    } // displayAllInformation()


    /**
     * Affiche les informations sur la page principal avec un carousel
     * @param $title
     * @param $content
     */
    public function displayInformationView($id, $title, $content, $type)
    {
        echo '   
                <div class="title">' . $title . ' </div>
                    <div class="content_info">';
        if ($type == "tab") {$this->readExcel($id);}
        else {echo $content;}
                echo '</div>
             </div>';
    } //displayInformationView()

    public function displayStartSlide(){
        echo '
            <div class="slideshow-container-info">
                <div class="mySlides-info">';
    }

    public function displayMidSlide(){
        echo '
                </div>
              <div class="mySlides-info">';
    }

    public function displayEndSlide() {
        echo '          
                       </div>
                   </div>
        <script src="/wp-content/plugins/TeleConnecteeAmu/views/js/slideshow.js"></script>
        <script src="/wp-content/plugins/TeleConnecteeAmu/views/js/test.js"></script>';
    }

    /**
     * Affiche un formulaire pour choisir le type d'information que l'on veut créer
     * et affiche le formulaire de création en fonction.
     */
    public function displayInformationCreation()
    {

        $dateMin = date('Y-m-d', strtotime("+1 day"));

        echo 'Quel type de contenu voulez vous pour votre information ? </br>

              <form method="post">
                <label> Texte : <input type="radio" name="typeChoice" value="text"></label></br>
                <label> Affiche : <input type="radio" name="typeChoice" value="image"></label></br>
                <label> Tableau : <input type="radio" name="typeChoice" value="tab"></label></br>
                <button type="submit"> Selectionner </button>
              </form>';


        $choice = $_POST['typeChoice'];
        if ($choice == 'text') {
            echo '<form method="post">
                        Titre : <input type="text" name="titleInfo" placeholder="Inserer un titre" required maxlength="20"> </br>
                        Date d\'expiration : <input type="date" name="endDateInfo" min="' . $dateMin . '" required ></br>
                        Contenu : <textarea name="contentInfo" maxlength="200"></textarea> </br>
                        <input type="submit" value="creer" name="createText">
                      </form>';
        } elseif ($choice == 'image') {
            echo '<form method="post" enctype="multipart/form-data">
                        Titre : <input type="text" name="titleInfo" placeholder="Inserer un titre" required maxlength="20"> </br>
                        Date d\'expiration : <input type="date" name="endDateInfo" min="' . $dateMin . '" required ></br>
                        Ajouter une image :<input type="file" name="contentFile" /> </br>
                        <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
                         
                        <input type="submit" value="creer" name="createImg">
                      </form>';
        } elseif ($choice == 'tab') {
            echo '<form method="post" enctype="multipart/form-data">
                        Titre : <input type="text" name="titleInfo" placeholder="Inserer un titre" required maxlength="20"> </br>
                        Date d\'expiration : <input type="date" name="endDateInfo" min="' . $dateMin . '" required ></br>
                        Ajout du fichier Xls (ou xlsx) : <input type="file" name="contentFile" /> </br>
                        <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
                        <input type="submit" value="creer" name="createTab">
                      </form>';
        }
        echo '<a href="http://wptv/gerer-les-informations/"> Page de gestion</a>';
    } //displayInformationCreation()


    /**
     * Affiche le formulaire de modification d'information en fonction du type
     * @param $title
     * @param $content
     * @param $endDate
     */
    public function displayModifyInformationForm($title, $content, $endDate, $typeInfo)
    {
        $dateMin = date('Y-m-d', strtotime("+1 day"));
        if ($typeInfo == "text") {
            echo '
                <div>
                    <form id="modify_info" method="post">
                  
                      Titre : <input type="text" name="titleInfo" value="' . $title . '" required maxlength="20"> </br>
                      Contenu : <textarea name="contentInfo" maxlength="200">' . $content . '</textarea> </br>
                      Date d\'expiration : <input type="date" name="endDateInfo" min="' . $dateMin . '" value = "' . $endDate . '" required > </br>
                      <input type="submit" name="validateChange" value="Modifier" ">
                 </form>
                 <a href="http://wptv/gerer-les-informations/"> Page de gestion</a>
            </div>';
        } elseif ($typeInfo == "img") {
            echo '
                <div>
                    <form id="modify_info" method="post" enctype="multipart/form-data">
                      Titre : <input type="text" name="titleInfo" value="' . $title . '" required maxlength="20"> </br>
                      ' . $content . ' </br>
                       Changer l\'image :<input type="file" name="contentFile" /> </br>
                       <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
                      Date d\'expiration : <input type="date" name="endDateInfo" min="' . $dateMin . '" value = "' . $endDate . '" required > </br>
                       <input type="submit" name="validateChangeImg" value="Modifier"/>
                 </form>
               <a href="http://wptv/gerer-les-informations/"> Page de gestion</a>
            </div>';
        } elseif ($typeInfo == "tab") {
            echo 'Work in progress';
        } else {
            echo 'Désolé, une erreur semble être survenue.';
        }
    } //displayModifyInformationForm()

    public function readExcel($id)
    {

        $file = glob($_SERVER['DOCUMENT_ROOT'] . "/wp-content/plugins/TeleConnecteeAmu/views/Media/{$id}.*");
        foreach ($file as $i) {
            $filename = $i;
        }
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(TRUE);
        $spreadsheet = $reader->load($filename);

        $worksheet = $spreadsheet->getActiveSheet();
        echo $highestRow = $worksheet->getHighestRow() . '</br>';

        echo '<table>' . PHP_EOL;
        foreach ($worksheet->getRowIterator() as $row) {
            echo '<tr>' . PHP_EOL;
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
            //    even if a cell value is not set.
            // By default, only cells that have a value
            //    set will be iterated.


            $content = 'test';
            $max = $highestRow;
            $mod = 0;
            for ($i = 0; $i < $max; $i++) {
                $mod = $i % 3;
                if ($mod == 0) {
                    $content .= '<tr>';
                }
                $content .= '<td>' . $i . '</td>';
                if ($mod == 2) {
                    $content .= '</tr>';
                }
            }
            if ($mod != 2 && $i > 0) {
                $content .= '</tr>';
            }


//            foreach ($cellIterator as $cell) {
//                echo '<td>' .
//                    $cell->getValue() .
//                    '</td>' . PHP_EOL;
//            }
//            echo '</tr>' . PHP_EOL;
//        }
//        echo '</table>' . PHP_EOL;

        }
    }
}