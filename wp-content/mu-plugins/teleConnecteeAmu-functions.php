<?php
/*
Plugin Name: Télé Connectée Amu functions
Description: L'ensemble des fonctions globales du site.
Version: 0.2
License: GPL
Author: Nicolas Rohrbach
Author URI: https://wptv/
*/


add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}

// Rediriger les non-administrateurs vers la page d'accueil À partir de l'administration
add_action( 'init', 'wpm_admin_redirection' );
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
    return get_bloginfo( 'http://'.$_SERVER['HTTP_HOST'].'/' );
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