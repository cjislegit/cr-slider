<div class="wrap">
    <h1><?=esc_html(get_admin_page_title());?></h1>
    <?php
$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'main_options';
?>
    <h2 class="nav-tab-wrapper">
        <a href="?page=cr_slider_admin&tab=main_options" class="nav_tab"
            <?=$active_tab == 'main_options' ? 'nave-tab-active' : ';'?>>Main Options</a>
        <a href="?page=cr_slider_admin&tab=additional_options" class="nav_tab"
            <?=$active_tab == 'additional_options' ? 'nave-tab-active' : ';'?>>Additional Options</a>
    </h2>
    <form action="options.php" method="post">
        <?php
if ($active_tab == 'main_options') {
    settings_fields('cr_slider_group');
    do_settings_sections('cr_slider_page1');

} else {
    settings_fields('cr_slider_group');
    do_settings_sections('cr_slider_page2');
}
submit_button('Save Settings');
?>
    </form>
</div>