<?php

if(! function_exists( 'tc_carousel_get_placeholder_image' )){
    function tc_carousel_get_placeholder_image(){
        return "<img src='" . TC_CAROUSEL_URL . "plugins/tc-slider/assets/images/default.jpg' class='img-fluid wp-post-image' />";
    }
}

if( ! function_exists( 'tc_carousel_options' ) ){
    function tc_carousel_options(){
        $show_nav = isset( TC_Carousel_Settings::$options['tc_carousel_bullets'] ) && TC_Carousel_Settings::$options['tc_carousel_bullets'] == 1 ? true : false;
        wp_enqueue_script( 'tc-carousel-main-js', TC_CAROUSEL_URL . 'assets/js/main.js', array( 'jquery' ), TC_CAROUSEL_VERSION, true );
        wp_localize_script( 'tc-carousel-main-js', 'CAROUSEL_OPTIONS', array(
            'navControls' => $show_nav
        ));
    }
}
