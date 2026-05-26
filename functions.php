<?php
/**
 * Velnex block theme functions.
 */

if (!defined('ABSPATH')) {
    exit;
}

function velnex_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'velnex_theme_setup');

function velnex_enqueue_assets() {
    wp_enqueue_style(
        'velnex-fonts',
        'https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Source+Sans+3:wght@300;400;500;600&display=swap',
        array(),
        null
    );

    wp_enqueue_style(
        'velnex-site',
        get_template_directory_uri() . '/assets/styles.css',
        array('velnex-fonts'),
        '1.0.0'
    );

    wp_enqueue_script(
        'velnex-site',
        get_template_directory_uri() . '/assets/script.js',
        array(),
        '1.0.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'velnex_enqueue_assets');
