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

add_filter( 'wp_nav_menu_items', 'add_menu', 10, 1);
function add_menu( $items) {
    $current_user = wp_get_current_user();
    $model = new CodeAdeManager();
    $years = $model->getCodeYear();
    if (!is_user_logged_in()) {
        $items .= '<li><a href="'. site_url('wp-login.php') .'">Connexion</a></li>';
    }
    elseif($current_user->role != "television" && is_user_logged_in()){
        $items .= '
            <li class="menu-item-type-custom menu-item-object-custom menu-item-has-children white">
                <a href="#" title="Emploi du temps">Emploi du temps</a>
                <button class="ast-menu-toggle" role="button" aria-expanded="true"><span class="screen-reader-text">Permutateur de Menu</span></button>
                <ul class="sub-menu">';
        foreach ($years as $year){
            $items .= '<li class="menu-item menu-item-type-post_type menu-item-object-page"><a class="dropdown-item" href="'.home_url().'/emploi-du-temps/'.$year['code'].'">'.$year['title'].'</a></li>';
        }
        $items .= '</ul>
        </li>';
        if($current_user->role == "secretaire" || $current_user->role == "administrator"){
            $items .= '
            <li class="menu-item-type-custom menu-item-object-custom menu-item-has-children">
                <a href="#" title="Gestion des utilisateurs">Gestion des utilisateurs</a>
                <button class="ast-menu-toggle" role="button" aria-expanded="true"><span class="screen-reader-text">Permutateur de Menu</span></button>
                <ul class="sub-menu">
                    <li><a href="/creation-des-comptes"> Création des comptes</a></li>
                    <li><a href="/gestion-des-utilisateurs">Gestion des utilisateurs</a></li>
                </ul>
            </li>';

            $items .= '
            <li><a href="/gestion-codes-ade/"> Gestion des codes ADE</a></li>
            <li class="menu-item-type-custom menu-item-object-custom menu-item-has-children">
                <a href="#" title="Gestion des alertes & informations">Gestion des alertes & informations</a>
                <button class="ast-menu-toggle" role="button" aria-expanded="true"><span class="screen-reader-text">Permutateur de Menu</span></button>
                <ul class="sub-menu">
                    <li><a href="/alertes">Alertes</a></li>
                    <li><a href="/informations">Informations</a></li>
                 </ul>
             </li>';
        }
        $items .= '<li><a href="/mon-compte">Mon compte</a></li>';
        $items .= '<li><a href="'. wp_logout_url() .'">Déconnexion</a></li>';
    }
    else {
        $items .= '<li class="ninja"><a href="'. wp_logout_url() .'">Déconnexion</a></li>';
    }
    return $items;
}