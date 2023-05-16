<div class="wrap">
    <h1><?=esc_html(get_admin_page_title());?></h1>
    <form action="option.php" method="post">
        <?php
settings_fields('cr_slider_group');
do_settings_sections('cr_slider_page1');
do_settings_sections('cr_slider_page2');
submit_button('Save Settings');
?>
    </form>
</div>