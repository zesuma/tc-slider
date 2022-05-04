<?php

if( ! class_exists( 'TC_Carousel_Settings' ) ){
    class TC_Carousel_Settings{
        public static $options;

        public function __construct(){
            self::$options = get_option( 'tc_carousel_options' );
            add_action( 'admin_init', array( $this, 'admin_init' ) );
        }

        public function admin_init(){

            register_setting( 'tc_carousel_group', 'tc_carousel_options', array( $this, 'tc_carousel_validate' ) );

            add_settings_section(
                'tc_carousel_main_section',
                esc_html__( 'How does it work?', 'tc-carousel' ),
                null,
                'tc_carousel_page1'
            );  
            
            add_settings_section(
                'tc_carousel_second_section',
                esc_html__( 'Other Plugin Options', 'tc-carousel' ),
                null,
                'tc_carousel_page2'
            ); 
            
            add_settings_field(
                'tc_carousel_shortcode',
                esc_html__( 'Shortcode', 'tc-carousel' ),
                array( $this, 'tc_carousel_shortcode_callback' ),
                'tc_carousel_page1',
                'tc_carousel_main_section'
            );

            add_settings_field(
                'tc_carousel_bullets',
                esc_html__( 'Display Nav Controls', 'tc-carousel' ),
                array( $this, 'tc_carousel_bullets_callback' ),
                'tc_carousel_page2',
                'tc_carousel_second_section',
                array(
                    'label_for'  => 'tc_carousel_bullets'
                )
            );
        }

        public function tc_carousel_shortcode_callback(){
            ?>
            <span><?php esc_html_e( 'Use the shorcode [tc_carousel] to display the carousel in any page/post/widget', 'tc-carousel' ); ?></span>
            <?php
        }

        public function tc_carousel_bullets_callback( $args ){
            ?>
                <input 
                type="checkbox" 
                name="tc_carousel_options[tc_carousel_bullets]" 
                id="tc_carousel_bullets" 
                value="1" 
                <?php  
                    if( isset( self::$options['tc_carousel_bullets'] ) ){
                        checked( "1", self::$options['tc_carousel_bullets'], true );
                    }
                ?>  
                />
                <label for="tc_carousel_bullets"><?php _e( 'Whether to display nav controls or not', 'tc-carousel'); ?></label>
            <?php
        }

        public function tc_carousel_validate( $input ){
            $new_input = array();
            foreach( $input as $key => $value ){
                switch ($key){
                    case 'tc_carousel_url':
                        if( empty ( $value ) ){
                            $value = 'Please add a url';
                        }
                        $new_input[$key] = sanitize_url_field( $value );
                    break;
                    case 'tc_carousel_int':
                        $new_input[$key] = absint( $value );
                    break;
                    default:
                        $new_input[$key] = sanitize_text_field( $value );
                    break;
                }
                
            }
            return $new_input;
        }
    }
}
