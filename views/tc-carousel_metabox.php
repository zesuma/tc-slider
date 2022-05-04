<?php
    $meta = get_post_meta( $post->ID );
    $link_text = get_post_meta( $post->ID, 'tc_carousel_link_text', true );
    $link_url = get_post_meta( $post->ID, 'tc_carousel_link_url', true );
?>
<table class="form-table tc-carousel-metabox">
    <input type="hidden" name="tc_carousel_nonce" value="<?php echo wp_create_nonce("tc_carousel_nonce"); ?>">
    <tr>
        <th>
            <label for="tc_carousel_link_text"><?php esc_html_e('Link Text', 'tc-carousel'); ?></label>
        </th>
        <td>
            <input 
                type="text" 
                name="tc_carousel_link_text" 
                id="tc_carousel_link_text" 
                class="regular-text link-text" 
                value="<?php echo ( isset( $link_text ) ) ? esc_html( $link_text ) : ''; ?>" 
                required
            >
        </td>
    </tr>
    <tr>
        <th>
            <label for="tc_carousel_link_url"><?php esc_html_e('Link URL', 'tc-carousel'); ?></label>
        </th>
        <td>
            <input 
                type="url" 
                name="tc_carousel_link_url" 
                id="tc_carousel_link_url" 
                class="regular-text link-url" 
                value="<?php echo ( isset ( $link_url ) ) ? esc_url( $link_url ) : ''; ?>" 
                required
            >
        </td>
    </tr>
</table>
