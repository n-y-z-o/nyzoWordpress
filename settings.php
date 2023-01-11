<?php

function nyzo_add_settings_page() {
    $menu_title = 'Nyzo settings';
    $menu_navigation_name = 'Nyzo';
    add_options_page( 'Nyzo plugin page', $menu_navigation_name, 'manage_options', 'nyzo_plugin',
        'nyzo_render_settings_page' );
}
add_action( 'admin_menu', 'nyzo_add_settings_page' );

function nyzo_render_settings_page() {
    echo '<h1>Nyzo settings</h1>';
    echo '<form action="options.php" method="post">';
    settings_fields( 'nyzo_plugin_options' );
    do_settings_sections( 'nyzo_plugin' );
    echo '<input name="submit" class="button button-primary" type="submit" value="Save" />';
    echo '</form>';
}

function nyzo_register_settings() {
    register_setting( 'nyzo_plugin_options', 'nyzo_plugin_options', 'nyzo_plugin_options_validate' );
    add_settings_section( 'account_settings', 'Account Settings', 'nyzo_plugin_section_text', 'nyzo_plugin' );

    add_settings_field( 'nyzo_plugin_setting_receiver_id', 'receiver ID', 'nyzo_plugin_setting_receiver_id',
        'nyzo_plugin', 'account_settings' );
}
add_action( 'admin_init', 'nyzo_register_settings' );

function nyzo_plugin_section_text() {
}

function nyzo_plugin_setting_receiver_id() {
    $options = get_option( 'nyzo_plugin_options' );
    echo '<input id="nyzo_plugin_setting_receiver_id" name="nyzo_plugin_options[receiver_id]" type="text" value="' .
        esc_attr( $options['receiver_id'] ) . '" />';
}

function nyzo_plugin_options_validate( $input ) {
    // TODO: ensure the receiver_id is a valid Nyzo string public identifier.
    return $input;
}