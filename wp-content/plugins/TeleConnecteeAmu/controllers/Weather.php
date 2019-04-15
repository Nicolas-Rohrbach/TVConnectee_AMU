<?php
/**
 * Created by PhpStorm.
 * User: r17000292
 * Date: 15/04/2019
 * Time: 09:29
 */

class Weather
{
    private $view;
    public function displayMyWeather() {
        $this->view = new ViewWeather();
        $this->view->displayWeather();
    }
}