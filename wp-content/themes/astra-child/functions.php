<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 11/04/2019
 * Time: 09:30
 */

define( 'ASTRA_THEME_DIR', trailingslashit( get_template_directory() ) );
require_once 'inc/class-astra-dynamic-css.php';

add_action('wp_enqueue_scripts', 'gkp_insert_css_in_head');
function gkp_insert_css_in_head() {
    // On ajoute le css general du theme
    wp_register_style('style', get_bloginfo( 'stylesheet_url' ),'',false,'screen');
    wp_enqueue_style( 'style' );
}

/**
 * Change the image of the logo
 */
function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri()."/logo.png" ?>);
            height:65px;
            width:320px;
            background-size: 120px 120px;
            background-repeat: no-repeat;
            padding-bottom: 60px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

/**
 * Ajoute une nouvelle feuille de style pour la page de connexion
 */
function my_login_stylesheet() {
    wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/login/login-style.css' );
}
add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );

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

add_action( 'wp_enqueue_scripts', 'custom_enqueue_script3' );
function custom_enqueue_script3() {
    wp_enqueue_script( 'jqueryUI', get_bloginfo( 'stylesheet_directory' ) . '/js/jquery-ui.min.js',
        array( 'jquery' ), '', false);
}

add_action( 'wp_enqueue_scripts', 'custom_enqueue_script4' );
function custom_enqueue_script4() {
    wp_enqueue_script( 'jqueryEasyTicker', get_bloginfo( 'stylesheet_directory' ) . '/js/jquery.easy-ticker.js',
        array( 'jquery' ), '', false);
}