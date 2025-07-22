<?php

function add_social_links_settings() {
    add_settings_section(
        'social_links_section', // Section ID
        'Social Media Links', // Section title
        null, // Callback for description
        'general' // Page where the section will be displayed
    );

    // LinkedIn field
    add_settings_field(
        'linkedin_url', // Field ID
        'LinkedIn URL', // Field label
        'display_linkedin_field', // Function that renders the field
        'general', // Page where the field will be displayed
        'social_links_section' // Section where the field will be displayed
    );

    // Twitter (X) field
    add_settings_field(
        'twitter_url', // Field ID
        'Twitter (X) URL', // Field label
        'display_twitter_field', // Function that renders the field
        'general', // Page where the field will be displayed
        'social_links_section' // Section where the field will be displayed
    );

    // Facebook field
    add_settings_field(
        'facebook_url', // Field ID
        'Facebook URL', // Field label
        'display_facebook_field', // Function that renders the field
        'general', // Page where the field will be displayed
        'social_links_section' // Section where the field will be displayed
    );

    // Instagram field
    add_settings_field(
        'instagram_url', // Field ID
        'Instagram URL', // Field label
        'display_instagram_field', // Function that renders the field
        'general', // Page where the field will be displayed
        'social_links_section' // Section where the field will be displayed
    );

    // Threads field
    add_settings_field(
        'threads_url', // Field ID
        'Threads URL', // Field label
        'display_threads_field', // Function that renders the field
        'general', // Page where the field will be displayed
        'social_links_section' // Section where the field will be displayed
    );

    // Register the options to save them to the database
    register_setting('general', 'linkedin_url', 'esc_url');
    register_setting('general', 'twitter_url', 'esc_url');
    register_setting('general', 'facebook_url', 'esc_url');
    register_setting('general', 'instagram_url', 'esc_url');
    register_setting('general', 'threads_url', 'esc_url');
}
add_action('admin_init', 'add_social_links_settings');

// Functions to display each field
function display_linkedin_field() {
    $linkedin_url = get_option('linkedin_url', '');
    echo '<input type="url" id="linkedin_url" name="linkedin_url" value="' . esc_attr($linkedin_url) . '" class="regular-text ltr">';
}

function display_twitter_field() {
    $twitter_url = get_option('twitter_url', '');
    echo '<input type="url" id="twitter_url" name="twitter_url" value="' . esc_attr($twitter_url) . '" class="regular-text ltr">';
}

function display_facebook_field() {
    $facebook_url = get_option('facebook_url', '');
    echo '<input type="url" id="facebook_url" name="facebook_url" value="' . esc_attr($facebook_url) . '" class="regular-text ltr">';
}

function display_instagram_field() {
    $instagram_url = get_option('instagram_url', '');
    echo '<input type="url" id="instagram_url" name="instagram_url" value="' . esc_attr($instagram_url) . '" class="regular-text ltr">';
}

function display_threads_field() {
    $threads_url = get_option('threads_url', '');
    echo '<input type="url" id="threads_url" name="threads_url" value="' . esc_attr($threads_url) . '" class="regular-text ltr">';
}
