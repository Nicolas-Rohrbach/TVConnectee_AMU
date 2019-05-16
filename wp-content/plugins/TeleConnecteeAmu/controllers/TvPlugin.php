<?php
/**
 * @package  TvPlugin
 */

defined( 'ABSPATH' ) or die( 'Hey, what are you doing here? You silly human!' );

if ( !class_exists( 'TvPlugin' ) ) {

    class TvPlugin
    {

        public $plugin;

        function __construct() {
            $this->plugin = plugin_basename( __FILE__ );
        }

        function register() {
            add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );

            add_action( 'admin_menu', array( $this, 'add_admin_pages' ) );

            add_filter( "plugin_action_links_$this->plugin", array( $this, 'settings_link' ) );
        }

        public function settings_link( $links ) {
            $settings_link = '<a href="admin.php?page=tv_plugin">Settings</a>';
            array_push( $links, $settings_link );
            return $links;
        }

        public function add_admin_pages() {
            add_menu_page( 'Tv Plugin', 'Configuration Tv', 'manage_options', 'tv_plugin', array( $this, 'admin_index' ), 'dashicons-welcome-view-site', 110 );
        }

        public function admin_index() {
            require_once plugin_dir_path( __FILE__ ) . 'templates/admin.php';
        }

        protected function create_post_type() {
            add_action( 'init', array( $this, 'custom_post_type' ) );
        }

        function custom_post_type() {
            register_post_type( 'book', ['public' => true, 'label' => 'Books'] );
        }

        function enqueue() {
            // enqueue all our scripts
            wp_enqueue_style( 'mypluginstyle', plugins_url( '/assets/mystyle.css', __FILE__ ) );
            wp_enqueue_script( 'mypluginscript', plugins_url( '/assets/myscript.js', __FILE__ ) );
            //wp_enqueue_script( 'mypluginphp', plugins_url( '/templates/traitement.php', __FILE__ ) );
            wp_enqueue_script( 'mypluginphp', plugins_url( '/templates/traitementLayout.php', __FILE__ ) );
            wp_enqueue_script( 'mypluginphp', plugins_url( '/templates/B.php', __FILE__ ) );
        }


        function activate() {
            require_once plugin_dir_path( __FILE__ ) . 'inc/TvPluginActivate.php';
            TvPluginActivate::activate();
        }

    }
}