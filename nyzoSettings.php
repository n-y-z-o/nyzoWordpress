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
add_action('admin_menu', 'nyzo_add_settings_page');

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

    // Add the settings section.
    add_settings_section('nyzo_settings', '', 'nyzo_plugin_section_text', 'nyzo_plugin');

    // Add the receiver ID.
    add_settings_field('nyzo_plugin_setting_receiver_id', 'receiver ID', 'nyzo_plugin_setting_receiver_id',
        'nyzo_plugin', 'nyzo_settings');

    // Add the client endpoint.
    add_settings_field('nyzo_plugin_setting_client_endpoint', 'client endpoint', 'nyzo_plugin_setting_client_endpoint',
        'nyzo_plugin', 'nyzo_settings');

    // Add the automatic tip element option.
    add_settings_field('nyzo_plugin_setting_automatic_tip_element', 'automatic tip element on all pages',
        'nyzo_plugin_setting_automatic_tip_element', 'nyzo_plugin', 'nyzo_settings');

    // Add the default shortcode tip element option.
    add_settings_field('nyzo_plugin_setting_default_shortcode_tip_element', 'default shortcode tip element',
        'nyzo_plugin_setting_default_shortcode_tip_element', 'nyzo_plugin', 'nyzo_settings');
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
    echo '<input id="nyzo-plugin-setting-receiver-id" name="nyzo_plugin_options[receiver_id]" class="regular-text" ' .
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

function nyzo_plugin_setting_automatic_tip_element() {
    $options = get_option('nyzo_plugin_options');
    $selectValues = ['none', 'hidden', 'small', 'large'];
    try {
        $style = $options['automatic_tip_element'];
    } catch (Throwable $t) {
        $style = 'none';
    }

    echo '<select id="nyzo_plugin_setting_automatic_tip_element" name="nyzo_plugin_options[automatic_tip_element]">';
    for ($i = 0; $i < count($selectValues); $i++) {
        echo '<option value="' . $selectValues[$i] .'"' . ($style == $selectValues[$i] ? ' selected' : '')  . '>' .
            $selectValues[$i] . '</option>';
    }
    echo '</select>';
}

function nyzo_plugin_setting_default_shortcode_tip_element() {
    $options = get_option('nyzo_plugin_options');
    $selectValues = ['hidden', 'small', 'large'];
    try {
        $style = $options['default_shortcode_tip_element'];
    } catch (Throwable $t) {
        $style = 'hidden';
    }

    echo '<select id="nyzo_plugin_setting_default_shortcode_tip_element" ';
    echo 'name="nyzo_plugin_options[default_shortcode_tip_element]">';
    for ($i = 0; $i < count($selectValues); $i++) {
        echo '<option value="' . $selectValues[$i] .'"' . ($style == $selectValues[$i] ? ' selected' : '')  . '>' .
            $selectValues[$i] . '</option>';
    }
    echo '</select>';
}

function nyzo_plugin_options_validate($newValues) {

    // Get the current values.
    $options = get_option('nyzo_plugin_options');

    // Validate the receiver identifier.
    $identifierString = $newValues['receiver_id'];
    if (empty($identifierString)) {
        add_settings_error('nyzo_messages', 'nyzo_message', __('Receiver ID is required', 'nyzo'), 'error');
        $newValues['receiver_id'] = $options['receiver_id'];
    } else {
        $publicIdentifierObject = NyzoStringEncoder::decode($identifierString);
        if ($publicIdentifierObject === null) {
            add_settings_error('nyzo_messages', 'nyzo_message',
                __('Receiver ID must be a valid Nyzo string public identifier', 'nyzo'), 'error');
            $newValues['receiver_id'] = $options['receiver_id'];
        }
    }

    // Get the client endpoint for validation.
    try {
        $clientEndpoint = $newValues['client_endpoint'];
    } catch (Throwable $t) {
        $clientEndpoint = '';
    }

    // Get the scheme from the client endpoint.
    try {
        $scheme = strtolower(parse_url($clientEndpoint, PHP_URL_SCHEME));
    } catch (Throwable $t) {
        $scheme = '';
    }

    // Ensure the client endpoint is a valid URL.
    if (!filter_var($clientEndpoint, FILTER_VALIDATE_URL)) {
        add_settings_error('nyzo_messages', 'nyzo_message', __('Client endpoint must be a valid URL', 'nyzo'), 'error');
        $newValues['client_endpoint'] = $options['client_endpoint'];
    }

    // Ensure the endpoint URL scheme is http or https.
    if (strcmp($scheme, 'http') && strcmp($scheme, 'https')) {
        add_settings_error('nyzo_messages', 'nyzo_message', __('Client endpoint must be http or https', 'nyzo'),
            'error');
        $newValues['client_endpoint'] = $options['client_endpoint'];
    }

    return $newValues;
}

function nyzo_admin_enqueue_scripts() {
    wp_enqueue_script('nyzo_nacl', plugins_url('javascript/nacl.min.js', __FILE__));
    wp_enqueue_script('nyzo_sha256', plugins_url('javascript/sha256.min.js', __FILE__));
    wp_enqueue_script('nyzo_byte_buffer', plugins_url('javascript/byteBuffer.js', __FILE__));
    wp_enqueue_script('nyzo_string', plugins_url('javascript/nyzoString.js', __FILE__));
    wp_enqueue_script('nyzo_util', plugins_url('javascript/util.js', __FILE__));
    wp_enqueue_script('nyzo_settings', plugins_url('javascript/settings.js', __FILE__));
}
add_action('admin_enqueue_scripts', 'nyzo_admin_enqueue_scripts');