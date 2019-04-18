<?php
/*
Plugin Name: WordPress Channel functions
Description: L'ensemble des fonctions globales du site.
Version: 0.1
License: GPL
Author: Nicolas Rohrbach
Author URI: https://wpchannel.com/
*/

/**
 * Function Name: front_end_login_fail.
 * Description: This redirects the failed login to the custom login page instead of default login page with a modified url
 **/
//add_action( 'wp_login_failed', 'front_end_login_fail' );
//function front_end_login_fail( $username ) {
//
//    $referrer = $_SERVER['HTTP_REFERER'];
//// if there's a valid referrer, and it's not the default log-in screen
//    if( !empty( $referrer ) && !strstr( $referrer,'wp-login' ) && !strstr( $referrer,'wp-admin' ) ) {
//
//        wp_redirect( "http://wptv/connexion?login=failed" );
//        exit;
//    }
//}


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

//prise en compte de ma nouvelle feuille de style par mon thème enfant
function my_login_stylesheet() {
    wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/login/login-style.css' );
}
add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );

// changer l'URL du logo de la page de connexion afin qu'elle pointe vers votre site
function my_login_logo_url() {
    return get_bloginfo( 'http://wptv/' );
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return 'TvConnecteeAmu - Pour un emploi du temps sain';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );

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