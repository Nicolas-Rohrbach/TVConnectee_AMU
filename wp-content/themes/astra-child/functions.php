<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 11/04/2019
 * Time: 09:30
 */

add_action('wp_enqueue_scripts', 'gkp_insert_css_in_head');
function gkp_insert_css_in_head() {
    // On ajoute le css general du theme
    wp_register_style('style', get_bloginfo( 'stylesheet_url' ),'',false,'screen');
    wp_enqueue_style( 'style' );
}