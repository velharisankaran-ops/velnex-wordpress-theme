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
    $style_path = get_template_directory() . '/assets/styles.css';
    $script_path = get_template_directory() . '/assets/script.js';

    wp_enqueue_style(
        'velnex-fonts',
        'https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Source+Sans+3:wght@300;400;500;600;700&display=swap',
        array(),
        null
    );

    wp_enqueue_style(
        'velnex-site',
        get_template_directory_uri() . '/assets/styles.css',
        array('velnex-fonts'),
        file_exists($style_path) ? filemtime($style_path) : '1.0.0'
    );

    wp_enqueue_script(
        'velnex-site',
        get_template_directory_uri() . '/assets/script.js',
        array(),
        file_exists($script_path) ? filemtime($script_path) : '1.0.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'velnex_enqueue_assets');

function velnex_create_opportunities_page() {
    $page = get_page_by_path('opportunities');

    if ($page) {
        return;
    }

    wp_insert_post(
        array(
            'post_title' => 'Opportunities',
            'post_name' => 'opportunities',
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_content' => '',
        )
    );
}
add_action('after_switch_theme', 'velnex_create_opportunities_page');
add_action('init', 'velnex_create_opportunities_page');

function velnex_home_seo_meta() {
    if (!is_front_page()) {
        return;
    }

    $description = 'Velnex is a business management and operations company built to work with small and mid-sized businesses and investors across the UAE and India.';
    $url = home_url('/');
    ?>
    <meta name="description" content="<?php echo esc_attr($description); ?>">
    <meta property="og:title" content="Velnex | Business Management & Operations">
    <meta property="og:description" content="<?php echo esc_attr($description); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo esc_url($url); ?>">
    <meta name="twitter:card" content="summary_large_image">
    <script type="application/ld+json">
    <?php
    echo wp_json_encode(
        array(
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => 'Velnex Business Management and Operations',
            'url' => $url,
            'founder' => array(
                '@type' => 'Person',
                'name' => 'Velhari Sankaran',
            ),
            'areaServed' => array('United Arab Emirates', 'India'),
            'description' => $description,
        ),
        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
    );
    ?>
    </script>
    <?php
}
add_action('wp_head', 'velnex_home_seo_meta', 5);
