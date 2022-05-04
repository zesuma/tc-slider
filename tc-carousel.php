<?php
/**
 *
 * @link              https://trevercumming.com
 * @since             1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:       TC Carousel by trevercumming.com
 * Plugin URI:        https://trevercumming.com
 * Description:       Simple Logo Carousel by trevercumming.com
 * Version:           1.0
 * Author:            TreverCumming
 * Author URI:        https://trevercumming.com
 * License:           GPL-2.0 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       tc-Carousel
 * Domain Path:       /languages
 *
 */

 /*
TC Carousel is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
TC Carousel is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with TC Carousel. If not, see {URI to Plugin License}.
*/


if( ! defined( 'ABSPATH' ) ){
    exit;
}


if( ! class_exists( 'TC_Carousel' ) ){
    class TC_Carousel{
        function __construct(){
            $this->define_constants();
            $this->load_textdomain();

            add_action( 'admin_menu', array( $this, 'add_menu' ) );

            require_once( TC_CAROUSEL_PATH . 'functions/functions.php' );

            require_once( TC_CAROUSEL_PATH . 'post-types/class.tc-carousel-cpt.php' );
            $TC_Carousel_Post_Type = new TC_Carousel_Post_Type();

            require_once( TC_CAROUSEL_PATH . 'class.tc-carousel-settings.php' );
            $TC_Carousel_Settings = new TC_Carousel_Settings();

            require_once( TC_CAROUSEL_PATH . 'shortcodes/class.tc-carousel-shortcode.php' );
            $TC_Carousel_Shortcode = new TC_Carousel_Shortcode();

            add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ), 999 );
            add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );
        }

        public function define_constants(){
            define( 'TC_CAROUSEL_PATH', plugin_dir_path( __FILE__ ) );
            define( 'TC_CAROUSEL_URL', plugin_dir_url( __FILE__ ) );
            define( 'TC_CAROUSEL_VERSION', '1.0.0' );
        }

        public static function activate(){
            update_option( 'rewrite_rules', '' );
        }

        public static function deactivate(){
            flush_rewrite_rules();
            unregister_post_type( 'tc-carousel' );
        }

        public static function uninstall(){
            delete_options( 'tc_carousel_options' );

            $posts = get_posts(
                array(
                    'post_type'     => 'tc-carousel',
                    'number_posts'  => -1,
                    'post_status'   => 'any'
                )
            );

            foreach( $posts as $post ){
                wp_delete_post( $post->ID, true );
            }
        }

        public function load_textdomain(){
            load_plugin_textdomain(
                'tc-carousel',
                false,
                dirname( plugin_basename( __FILE__ ) ) . '/languages/'
            );
        }

        public function add_menu(){
            add_menu_page(
                esc_html__( 'TC Carousel Options', 'tc-carousel' ),
                'TC Carousel',
                'manage_options',
                'tc_carousel_admin',
                array( $this, 'tc_carousel_settings_page' ),
                'dashicons-images-alt2'
            );

            add_submenu_page( 
              'tc_carousel_admin',
              esc_html__('Manage Carousels', 'tc-carousel'),
              esc_html__('Manage Carousels', 'tc-carousel'),
              'manage_options',
              'edit.php?post_type=tc-carousel',  
              null,
              null 
            );

            add_submenu_page( 
                'tc_carousel_admin',
                esc_html__('Add New Carousel', 'tc-carousel'),
                esc_html__('Add New Carousel', 'tc-carousel'),
                'manage_options',
                'post-new.php?post_type=tc-carousel',  
                null,
                null 
              );
        }

        public function tc_carousel_settings_page(){
            if( ! current_user_can( 'manage_options' ) ){
                return;
            }

            if( isset( $_GET['settings-updated'] ) ){
                add_settings_error( 'tc_carousel_options', 'tc_carousel_message', esc_html__('Settings Saved', 'tc-carousel'), 'success' );
            }

            settings_errors( 'tc_carousel_options' );
            require( TC_CAROUSEL_PATH . 'views/settings-page.php' );
        }

        public function register_scripts(){
            //wp_register_script( 'tc-carousel-main-js', TC_CAROUSEL_URL . 'assets/js/main.js', array( 'jquery' ), TC_CAROUSEL_VERSION, true );
            wp_register_style('tc-carousel-main-css', TC_CAROUSEL_URL . 'assets/css/main.css', array(), TC_CAROUSEL_VERSION, 'all' );
        }

        public function register_admin_scripts(){
            global $typenow;
            if( $typenow == 'tc-carousel' ){
                wp_enqueue_style( 'tc-carousel-admin', TC_CAROUSEL_URL . 'assets/css/admin.css', array(), TC_CAROUSEL_VERSION, 'all' );
            }
        }

    }
}

if( class_exists( 'TC_Carousel' ) ){
    register_activation_hook( __FILE__, array( 'TC_Carousel', 'activate' ) );
    register_deactivation_hook( __FILE__, array( 'TC_Carousel', 'deactivate' ) );
    register_uninstall_hook( __FILE__, array( 'TC_Carousel', 'uninstall' ) );
   
    $tc_carousel = new TC_Carousel();
}
