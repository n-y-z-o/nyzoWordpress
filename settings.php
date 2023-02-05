<?php

if (!defined('__NYZO_EXTENSION_ROOT__')) { define('__NYZO_EXTENSION_ROOT__', dirname(__FILE__)); }
require_once(__NYZO_EXTENSION_ROOT__ . '/lib/nyzoStringEncoder.php');
require_once(__NYZO_EXTENSION_ROOT__ . '/lib/nyzoStringPublicIdentifier.php');

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
    settings_fields('nyzo_plugin_options');
    do_settings_sections('nyzo_plugin');
    echo '<input name="submit" class="button button-primary" type="submit" value="Save" />';
    echo '</form>';
}

function nyzo_register_settings() {
    register_setting('nyzo_plugin_options', 'nyzo_plugin_options', 'nyzo_plugin_options_validate');
    add_settings_section('account_settings', 'Account Settings', 'nyzo_plugin_section_text', 'nyzo_plugin');

    add_settings_field('nyzo_plugin_setting_receiver_id', 'receiver ID', 'nyzo_plugin_setting_receiver_id',
        'nyzo_plugin', 'account_settings');
    add_settings_field('nyzo_plugin_setting_client_endpoint', 'client endpoint', 'nyzo_plugin_setting_client_endpoint',
        'nyzo_plugin', 'account_settings');
}
add_action('admin_init', 'nyzo_register_settings');

function nyzo_plugin_section_text() {
}

function nyzo_plugin_setting_receiver_id() {
    $options = get_option('nyzo_plugin_options');
    try {
        $receiverId = $options['receiver_id'];
    } catch (Throwable $t) {
        $receiverId = '';
    }
    echo '<input id="nyzo_plugin_setting_receiver_id" name="nyzo_plugin_options[receiver_id]" class="regular-text" ' .
        'type="text" value="' . esc_attr($receiverId) . '" />';
}

function nyzo_plugin_setting_client_endpoint() {
    $options = get_option('nyzo_plugin_options');
    try {
        $clientEndpoint = $options['client_endpoint'];
    } catch (Throwable $t) {
        $clientEndpoint = '';
    }
    echo '<input id="nyzo_plugin_setting_client_endpoint" name="nyzo_plugin_options[client_endpoint]" ' .
        'class="regular-text" type="text" value="' . esc_attr($clientEndpoint) . '" />';
}

function nyzo_plugin_options_validate($newValues) {

    $identifierString = $newValues['receiver_id'];
    if (empty($identifierString)) {
        add_settings_error('nyzo_messages', 'nyzo_message', __('Receiver ID is required', 'nyzo'), 'error');
    } else {
        $publicIdentifierObject = NyzoStringEncoder::decode($identifierString);
        if ($publicIdentifierObject === null) {
            add_settings_error('nyzo_messages', 'nyzo_message',
                __('Receiver ID must be a valid Nyzo string public identifier', 'nyzo'), 'error');
        }
    }

    return $newValues;
}