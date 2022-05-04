<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <?php
        $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'main_options';
    ?>
    <h2 class="nav-tab-wrapper">
        <a href="?page=tc_carousel_admin&tab=main_options" class="nav-tab <?php echo $active_tab == 'main_options' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Main Options', 'tc-carousel' ); ?></a>
        <a href="?page=tc_carousel_admin&tab=additional_options" class="nav-tab <?php echo $active_tab == 'additional_options' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Additional Options', 'tc-carousel' ); ?></a>
    </h2>
    <form action="options.php" method="post">
    <?php
        if( $active_tab == 'main_options' ){
            settings_fields( 'tc_carousel_group' );
            do_settings_sections( 'tc_carousel_page1' );
        } else{
            settings_fields( 'tc_carousel_group' );
            do_settings_sections( 'tc_carousel_page2' );
        }
        submit_button( esc_html__( 'Save Settings', 'tc-carousel' ) );
    ?>
    </form>
</div>
