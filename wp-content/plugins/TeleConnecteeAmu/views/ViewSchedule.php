<?php
/**
 * Created by PhpStorm.
 * User: r17000292
 * Date: 30/01/2019
 * Time: 11:54
 */

class ViewSchedule extends ViewG
{
    public function displayName($current_user) {
        echo '<h1 class="text-center text-black-50">'.$current_user->display_name. '</h1>';
    }

    public function displayHome($current_user) {
        echo '<h1 class="text-center text-black-50"> Bienvenue '.$current_user->display_name.' sur la tv connectée ! </h1>';
    }

    public function startSlide(){
        echo '
            <div class="slideshow-container">
                <div class="mySlides">';
    }

    public function midSlide(){
        echo '
                </div>
              <div class="mySlides">';
    }

    public function endSlide() {
        echo '          
                       </div>
                   </div>
        <script src="/wp-content/plugins/TeleConnecteeAmu/views/js/slideshow.js"></script>';
    }
}