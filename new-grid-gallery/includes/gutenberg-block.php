<?php
if (! defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Register Gutenberg Block for Grid Gallery
 */
add_action('init', 'awl_grid_gallery_register_gutenberg_block');
function awl_grid_gallery_register_gutenberg_block() {
    if (!function_exists('register_block_type')) {
        return;
    }

    // Register all frontend styles/scripts on init so they're available for editor_style
    wp_register_style('gg-gridder-css', GG_PLUGIN_URL . 'assets/css/jquery.gridder.min.css', array(), GG_PLUGIN_VER);
    wp_register_style('gg-frontend-css', GG_PLUGIN_URL . 'assets/css/grid-gallery-frontend.css', array(), GG_PLUGIN_VER);
    wp_register_style('ggp-hover-css', GG_PLUGIN_URL . 'assets/css/hover.css', array(), GG_PLUGIN_VER);

    // Register editor-only override styles (force visibility in editor preview)
    wp_register_style('awl-gg-block-editor-css', false);
    wp_add_inline_style('awl-gg-block-editor-css', '
        .gridder { opacity: 1 !important; display: block !important; }
        .gg-gallery-loader { display: none !important; }
    ');
    
    wp_register_script(
        'ggp-gutenberg-block-js',
        GG_PLUGIN_URL . 'assets/js/gg-gutenberg-block.js',
        array('wp-blocks', 'wp-element', 'wp-components', 'wp-block-editor', 'wp-server-side-render', 'jquery', 'jquery-effects-core', 'awl-gridder-js'),
        GG_PLUGIN_VER,
        true
    );

    register_block_type('new-grid-gallery/gallery-select', array(
        'api_version'     => 3,
        'editor_script'   => 'ggp-gutenberg-block-js',
        'editor_style'    => array('gg-gridder-css', 'gg-frontend-css', 'ggp-hover-css', 'awl-gg-block-editor-css'),
        'render_callback' => 'awl_grid_gallery_block_render',
        'attributes'      => array(
            'galleryId' => array(
                'type'    => 'string',
                'default' => '',
            ),
        ),
    ));
}

add_action('enqueue_block_editor_assets', 'awl_grid_gallery_gutenberg_localize');
function awl_grid_gallery_gutenberg_localize() {
    $all_galleries = get_posts(array(
        'post_type'      => 'grid_gallery',
        'posts_per_page' => -1,
        'post_status'    => 'any',
        'orderby'        => 'title',
        'order'          => 'ASC',
    ));
    
    $galleries_data = array();
    if (!empty($all_galleries)) {
        foreach ($all_galleries as $g) {
            $galleries_data[] = array(
                'id'    => $g->ID,
                'title' => $g->post_title ? $g->post_title : __('(no title)', 'new-grid-gallery'),
            );
        }
    }
    
    wp_localize_script('ggp-gutenberg-block-js', 'ggp_gutenberg_data', array(
        'galleries'  => $galleries_data,
    ));
}

/**
 * Gutenberg Block Render Callback
 * Used for both frontend and ServerSideRender editor preview.
 */
function awl_grid_gallery_block_render($attributes) {
    $gallery_id = isset($attributes['galleryId']) ? (int)$attributes['galleryId'] : 0;
    if ($gallery_id) {
        return do_shortcode('[GGAL id=' . $gallery_id . ']');
    }
    return '';
}
