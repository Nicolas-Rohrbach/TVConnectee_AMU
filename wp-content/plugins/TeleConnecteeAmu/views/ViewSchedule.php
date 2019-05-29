<?php
/**
 * Created by PhpStorm.
 * User: r17000292
 * Date: 30/01/2019
 * Time: 11:54
 */

class ViewSchedule extends ViewG
{
    public function displayName($title) {
        echo '<h1>'.$title.'</h1>';
    }

    public function displayStartSlide(){
        echo '
            <div class="slideshow-container">
                <div class="mySlides">';
    }

    public function displayMidSlide(){
        echo '
                </div>
              <div class="mySlides">';
    }

    public function displayEndSlide() {
        echo '          
                       </div>
                   </div>';
    }

    public function displayEmptySchedule(){
        echo '<div> Vous n\'avez pas cours !</div>';
    }

    public function displayWelcome(){
        echo '<h2> Bienvenue sur la télé connectée </h2>';
    }

    public function displaySelectSchedule(){
        echo '<div> Veuillez sélectionner un emploi du temps </div>';
    }
}