<?php
/**
 * Created by PhpStorm.
 * User: SFW
 * Date: 17/04/2019
 * Time: 11:35
 */

class ViewInformation
{
    public function displayInformationList($title, $author, $content, $creationDate, $endDate) {
        echo '<div style="overflow-x:auto;">
                <table class="table table-hover">
                    <tr>
                        <th> Titre </th>
                        <th> Auteur </th>
                        <th> Contenu </th>
                        <th> Date de création </th>
                        <th> Date de fin </th>
                    </tr>';
       for($i=1; $i <= sizeof($title); ++$i) {
           echo    '<tr>
                        <td>'.$title[$i].'</td> 
                        <td>'.$author[$i].'</td>
                        <td>'.$content[$i].'</td>
                        <td>'.$creationDate[$i].'</td>
                        <td>'.$endDate[$i].'</td>
                    </tr>';
       }
       echo  '</table>
              <!--<button type="button" class="btn-warning">Modifier</button>
              <button type="button" class="btn-danger">Supprimer</button>-->';
    }
}