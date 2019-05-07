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

add_action( 'wp_enqueue_scripts', 'custom_enqueue_script' );
function custom_enqueue_script() {
    wp_enqueue_script( 'jquery331', get_bloginfo( 'stylesheet_directory' ) . '/js/jquery-3.3.1.min.js',
        array( 'jquery' ), '', false);
}

add_action( 'wp_enqueue_scripts', 'custom_enqueue_script2' );
function custom_enqueue_script2() {
    wp_enqueue_script( 'jqueryUI', get_bloginfo( 'stylesheet_directory' ) . '/js/jquery-ui.min.js',
        array( 'jquery' ), '', false);
}