<?php

include_once 'inc/customizer/back-office.php';

/**
 * Used by hook: 'customize_preview_init'
 *
 * @see add_action('customize_preview_init',$func)
 */
function mytheme_customizer_live_preview()
{
    wp_enqueue_script(
        'mytheme-themecustomizer',			//Give the script an ID
        get_template_directory_uri().'/assets/js/theme-customizer.js',//Point to file
        array( 'jquery','customize-preview' ),	//Define dependencies
        '',						//Define a version (optional)
        true						//Put script in footer?
    );
}
add_action( 'customize_preview_init', 'mytheme_customizer_live_preview' );

function wpdocs_theme_name_scripts() {
    wp_register_style('bootstrap-style', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css', array(), true);
    wp_enqueue_style('bootstrap-style');
    wp_register_style('main-style', get_template_directory_uri().'/style.css', array(), true);
    wp_enqueue_style('main-style');
}
add_action( 'wp_enqueue_scripts', 'wpdocs_theme_name_scripts' );

function admin_css() {

    $admin_handle = 'admin_css';
    $admin_stylesheet = get_template_directory_uri() . '/assets/css/admin.css';

    wp_enqueue_style( $admin_handle, $admin_stylesheet );
}
add_action('admin_print_styles', 'admin_css', 11 );

/**
 * Change the image of the logo
 */
function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri()."/assets/images/logo.png" ?>);
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
    wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/assets/css/login.css' );
}
add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );