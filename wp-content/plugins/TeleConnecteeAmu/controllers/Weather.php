<?php
/**
 * Created by PhpStorm.
 * User: r17000292
 * Date: 15/04/2019
 * Time: 09:29
 */

class Weather{
    private $view;

    /**
     * Affiche la météo si l'utilisateur est connectée
     */
    public function displayWeather()
    {
        if (is_user_logged_in()) {
            $this->view = new ViewWeather();
            $this->view->displayWeather();
        }
    }
}