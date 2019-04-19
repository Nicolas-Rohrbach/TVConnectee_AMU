<?php
/**
 * Created by PhpStorm.
 * User: SFW
 * Date: 17/04/2019
 * Time: 11:35
 */

class ViewInformation
{
    public function displayInformationList($title, $author, $content) {
        echo '<div style="overflow-x:auto;">
                <table>
                    <tr>
                        <th> Titre </th>
                        <th> Auteur </th>
                        <th> Contenu </th>
                    </tr>';
       for($i=1; $i <= sizeof($title); ++$i) {
           echo    '<tr>
                        <td>'.$title[$i].'</td> 
                        <td>'.$author[$i].'</td>
                        <td>'.$content[$i].'</td>
                    </tr>';
       }
       echo  '</table>';
    }
}