<?php

function nyzo_add_settings_page() {
    $menu_title = 'Nyzo settings';
    $menu_navigation_name = 'Nyzo';
    add_options_page( 'Nyzo plugin page', $menu_navigation_name, 'manage_options', 'nyzo-wordpress-plugin',
        'nyzo_render_settings_page' );
}
add_action( 'admin_menu', 'nyzo_add_settings_page' );

function nyzo_render_settings_page() {
    echo '<h1>Nyzo settings</h1>';
    echo '<form action="options.php" method="post">';
    echo '</form>';
}

