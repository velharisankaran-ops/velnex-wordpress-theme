<?php
/**
 * Velnex Platform Child theme functions.
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Ensure platform flow pages exist.
 */
function velnex_platform_child_create_platform_pages() {
    $pages = array(
        'platform-login'   => 'Platform Login',
        'request-access'   => 'Request Access',
        'business-signup'  => 'Business Signup',
        'investor-signup'  => 'Investor Signup',
        'vendor-signup'    => 'Vendor Signup',
        'pending-approval' => 'Pending Approval',
        'approved-flow'    => 'Approved Flow',
        'foundation-stage' => 'Foundation Stage',
    );

    foreach ($pages as $slug => $title) {
        if (get_page_by_path($slug)) {
            continue;
        }

        wp_insert_post(
            array(
                'post_title'   => $title,
                'post_name'    => $slug,
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_content' => '',
            )
        );
    }
}
add_action('after_switch_theme', 'velnex_platform_child_create_platform_pages');
add_action('init', 'velnex_platform_child_create_platform_pages');

/**
 * Enqueue child theme platform assets.
 */
function velnex_platform_child_enqueue_assets() {
    $platform_css_path = get_stylesheet_directory() . '/assets/platform.css';
    $platform_js_path = get_stylesheet_directory() . '/assets/platform.js';

    $platform_pages = array(
        'platform-login',
        'request-access',
        'business-signup',
        'investor-signup',
        'vendor-signup',
        'pending-approval',
        'approved-flow',
        'foundation-stage',
    );

    if (!is_page($platform_pages)) {
        return;
    }

    wp_enqueue_style(
        'velnex-platform-child',
        get_stylesheet_directory_uri() . '/assets/platform.css',
        array('velnex-site'),
        file_exists($platform_css_path) ? filemtime($platform_css_path) : '1.0.0'
    );

    wp_enqueue_script(
        'velnex-platform-child',
        get_stylesheet_directory_uri() . '/assets/platform.js',
        array(),
        file_exists($platform_js_path) ? filemtime($platform_js_path) : '1.0.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'velnex_platform_child_enqueue_assets', 20);
