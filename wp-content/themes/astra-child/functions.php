<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 11/04/2019
 * Time: 09:30
 */

//redirige vers notre page de connexion si l'id et le mdp sont faux
//redirige vers notre page de connexion si l'id et le mdp sont faux
/**
 * Function Name: front_end_login_fail.
 * Description: This redirects the failed login to the custom login page instead of default login page with a modified url
 **/
add_action( 'wp_login_failed', 'front_end_login_fail' );
function front_end_login_fail( $username ) {

// Getting ViewSchedule of the login page
    $referrer = $_SERVER['HTTP_REFERER'];
// if there's a valid referrer, and it's not the default log-in screen
    if( !empty( $referrer ) && !strstr( $referrer,'wp-login' ) && !strstr( $referrer,'wp-admin' ) ) {

        wp_redirect( get_permalink(7408) . "?login=failed" );
        exit;
    }
}

/**
 * Function Name: check_username_password.
 * Description: This redirects to the custom login page if user name or password is   empty with a modified url
 **/
add_action( 'authenticate', 'check_username_password', 1, 3);
function check_username_password( $login, $username, $password ) {

// Getting ViewSchedule of the login page
    $referrer = $_SERVER['HTTP_REFERER'];

// if there's a valid referrer, and it's not the default log-in screen
    if( !empty( $referrer ) && !strstr( $referrer,'wp-login' ) && !strstr( $referrer,'wp-admin' ) ) {
        if( $username == "" || $password == "" ){
            wp_redirect( get_permalink(7408) . "?login=empty" );
            exit;

        }
    }

}
// Replace my constant 'LOGIN_PAGE_ID' with your custom login page id.

add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}

// Rediriger les non-administrateurs vers la page d'accueil À partir de l'administration
function wpm_admin_redirection() {
    //Si on essaye d'accéder à L'administration Sans avoir le rôle administrateur
    if ( is_admin() && ! current_user_can( 'administrator' ) ) {
        // On redirige vers la page d'accueil
        wp_redirect( home_url() );
        exit;
    }
}
add_action( 'init', 'wpm_admin_redirection' );

add_action( 'wp_enqueue_scripts', 'custom_enqueue_script' );
function custom_enqueue_script() {
    wp_enqueue_script( 'refresh', get_bloginfo( 'stylesheet_directory' ) . '/js/refresh.js',
        array( 'jquery' ), '', true );
}