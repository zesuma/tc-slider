<div class="tc-carousel">
    <div class="image-container" id="imgs">

    <?php

        $args = array(
            'post_type'       => 'tc-carousel',
            'post_status'     => 'publish',
            'post__in'        => $id,
            'orderby'         => $orderby
        );

        $my_query = new WP_Query( $args );

        if( $my_query->have_posts() ):
            while( $my_query->have_posts() ) : $my_query->the_post();

            $title_text = get_post_meta( get_the_ID(), 'tc_carousel_link_text', true );
            $title_url = get_post_meta( get_the_ID(), 'tc_carousel_link_url', true );

            ?>
            <div class="carousel-wrapper">
                <a href="<?php echo esc_attr( $title_url ); ?>" title="<?php echo esc_html( $title_text ); ?>" class="link">
                <?php
                    if( has_post_thumbnail() ){
                        the_post_thumbnail( 'full', array( 'class' => 'img-fluid' ) );
                    } else {
                        echo tc_carousel_get_placeholder_image();
                    }
                ?>  
                </a>
            </div>
            <?php
            endwhile;
            wp_reset_postdata();
        endif;
    ?>
    </div>
    <div class="buttons-container">
        <button id="left"><span class="dashicons dashicons-arrow-left-alt2"></span></button>
        <button id="play" class="play"><span class="dashicons dashicons-controls-pause"></span></button>
        <button id="right"><span class="dashicons dashicons-arrow-right-alt2"></span></button>
    </div>
</div>
