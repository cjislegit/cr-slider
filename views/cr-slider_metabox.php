<?php
$meta = get_post_meta($post->ID);
$link_text = get_post_meta($post->ID, 'cr_slider_link_text', true);
$link_url = get_post_meta($post->ID, 'cr_slider_link_url', true);
//var_dump( $link_text, $link_url );

?>

<table class="form-table cr-slider-metabox">
    <!-- Creates a nonce for each slide -->
    <input type="hidden" name="cr_slider_nonce" value="<?=wp_create_nonce("cr_slider_nonce")?>">
    <tr>
        <th>
            <label for="cr_slider_link_text">Link Text</label>
        </th>
        <td>
            <input type="text" name="cr_slider_link_text" id="cr_slider_link_text" class="regular-text link-text"
                value="<?php echo (isset($link_text)) ? esc_html($link_text) : ''; ?>" required>
        </td>
    </tr>
    <tr>
        <th>
            <label for="cr_slider_link_url">Link URL</label>
        </th>
        <td>
            <input type="url" name="cr_slider_link_url" id="cr_slider_link_url" class="regular-text link-url"
                value="<?php echo (isset($link_url)) ? esc_url($link_url) : ''; ?>" required>
        </td>
    </tr>
</table>