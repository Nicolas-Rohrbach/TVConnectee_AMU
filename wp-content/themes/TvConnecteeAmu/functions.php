<?php

if (function_exists('register_sidebar')) register_sidebar();
if (function_exists('register_sidebar')) register_sidebar(2);

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

//function wpc_theme_support(){
//    add_theme_support('custom-logo', array(
//        'flex-height' => true,
//        'flex-width' => true,
//    ));
//}
//add_action('after_setup_theme','wpc_theme_support');
//
//function wpc_customize_register($wp_customize) {
//    $wp_customize->add_section('wpc_logo_section', array(
//            'title'          => __('Logo', 'wptv'),
//            'priority'       => 30,
//            'description'    => __('Upload a logo to replace the default site name and description in the header', 'textdomain')
//        )
//    );
//    $wp_customize->add_setting('wpc_logo');
//    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'wpc_logo', array(
//                'label'      => __('Logo', 'wptv'),
//                'section'    => 'wpc_logo_section',
//                'settings'   => 'wpc_logo')
//        )
//    );
//}
//add_action('customize_register', 'wpc_customize_register');

function theme_prefix_setup() {
    add_theme_support( 'custom-logo' );
}
add_action( 'after_setup_theme', 'theme_prefix_setup' );

add_theme_support( 'custom-logo', array(
    'height'      => 50,
    'width'       => 50,
    'flex-width' => true,
) );

add_theme_support( 'custom-logo', array(
    'header-text' => array( 'site-title', 'site-description' ),
) );


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

if ( function_exists('register_sidebar') ) {
    register_sidebar(array(
        'name' => 'Header',
        'before_widget' => '<div id="header">',
        'after_widget' => '</div>',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
    ));
    register_sidebar(array(
        'name' => 'Footer',
        'before_widget' => '<div id="footer">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => 'Colonne Gauche',
        'before_widget' => '<div id="sidebar-left">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => 'Colonne Droite',
        'before_widget' => '<div id="sidebar-right">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
}