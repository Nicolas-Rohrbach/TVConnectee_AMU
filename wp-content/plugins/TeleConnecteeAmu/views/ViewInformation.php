<?php
/**
 * Created by PhpStorm.
 * User: SFW
 * Date: 17/04/2019
 * Time: 11:35
 */

class ViewInformation
{
    public function displayInformation($title, $author, $content) {
       for($i=1; $i <= sizeof($title); ++$i) {
           echo ''.$title[$i].'_ 
                 ['.$author[$i].']_
                 '.$content[$i].'  </br>';
       }
    }
}