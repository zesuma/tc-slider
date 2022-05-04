<?php

if( ! class_exists( 'TC_Carousel_Shortcode' ) ){
    class TC_Carousel_Shortcode{
        public function __construct(){
            add_shortcode( 'tc_carousel', array( $this, 'add_shortcode' ) );
        }

        public function add_shortcode( $atts = array(), $content = null, $tag = '' ){
            $atts = array_change_key_case( (array) $atts, CASE_LOWER );

            extract( shortcode_atts(
                array(
                    'id'        => '',
                    'orderby'   => 'date'
                ),
                $atts,
                $tag
            ));

            if( !empty( $id ) ){
                $id = array_map( 'absint', explode( ',', $id ) );
            }

            ob_start();
            require( TC_CAROUSEL_PATH . 'views/tc-carousel_shortcode.php' );
            wp_enqueue_style( 'tc-carousel-main-css' );
            tc_carousel_options();
            return ob_get_clean();
        }
    }
}
