<?php
if (! defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Register all GG frontend assets early so they're available in any context.
 */
add_action('wp_enqueue_scripts', 'awl_gg_elementor_register_assets', 5);
function awl_gg_elementor_register_assets() {
    wp_register_script('awl-gridder-js', GG_PLUGIN_URL . 'assets/js/jquery.gridder.min.js', array('jquery', 'jquery-effects-core'), GG_PLUGIN_VER, true);
    wp_register_style('gg-gridder-css', GG_PLUGIN_URL . 'assets/css/jquery.gridder.min.css', array(), GG_PLUGIN_VER); 
    wp_register_style('gg-frontend-css', GG_PLUGIN_URL . 'assets/css/grid-gallery-frontend.css', array(), GG_PLUGIN_VER);
    wp_register_style('ggp-hover-css', GG_PLUGIN_URL . 'assets/css/hover.css', array(), GG_PLUGIN_VER);
}

/**
 * Force-enqueue gallery assets on Elementor preview pages.
 */
add_action('elementor/preview/enqueue_styles', 'awl_gg_elementor_enqueue_preview_assets');
function awl_gg_elementor_enqueue_preview_assets() {
    wp_enqueue_style('gg-gridder-css');
    wp_enqueue_style('gg-frontend-css');
    wp_enqueue_style('ggp-hover-css');
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-effects-core');
    wp_enqueue_script('awl-gridder-js');
}

/**
 * Register Elementor Widget for Grid Gallery
 */
add_action('elementor/widgets/register', 'awl_grid_gallery_register_elementor_widget');
function awl_grid_gallery_register_elementor_widget($widgets_manager) {
    if (class_exists('\Elementor\Widget_Base')) {

        class Elementor_Grid_Gallery_Widget extends \Elementor\Widget_Base {

            public function get_name() {
                return 'ggp_grid_gallery';
            }

            public function get_title() {
                return esc_html__('Grid Gallery', 'new-grid-gallery');
            }

            public function get_icon() {
                return 'eicon-grid';
            }

            public function get_categories() {
                return array('general');
            }

            public function get_keywords() {
                return array('grid', 'gallery', 'photo', 'image');
            }

            public function get_style_depends() {
                return array('gg-gridder-css', 'gg-frontend-css', 'ggp-hover-css');
            }

            public function get_script_depends() {
                return array('jquery', 'jquery-effects-core', 'awl-gridder-js');
            }

            protected function register_controls() {
                $this->start_controls_section(
                    'content_section',
                    array(
                        'label' => esc_html__('Gallery Settings', 'new-grid-gallery'),
                        'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                    )
                );

                // Fetch Galleries List
                $all_galleries = get_posts(array(
                    'post_type'      => 'grid_gallery',
                    'posts_per_page' => -1,
                    'post_status'    => 'any',
                    'orderby'        => 'title',
                    'order'          => 'ASC',
                ));

                $options = array('' => esc_html__('-- Select Gallery --', 'new-grid-gallery'));
                if (!empty($all_galleries)) {
                    foreach ($all_galleries as $g) {
                        $options[$g->ID] = $g->post_title ? $g->post_title . ' (ID: ' . $g->ID . ')' : esc_html__('(no title)', 'new-grid-gallery') . ' (ID: ' . $g->ID . ')';
                    }
                }

                $this->add_control(
                    'gallery_id',
                    array(
                        'label'     => esc_html__('Choose Grid Gallery', 'new-grid-gallery'),
                        'type'      => \Elementor\Controls_Manager::SELECT,
                        'options'   => $options,
                        'default'   => '',
                    )
                );

                $this->end_controls_section();
            }

            protected function render() {
                $settings = $this->get_settings_for_display();
                
                if (empty($settings['gallery_id'])) {
                    echo '<div style="padding:20px; border:1px dashed #ccc; text-align:center;">' . esc_html__('Please select a Grid Gallery.', 'new-grid-gallery') . '</div>';
                    return;
                }

                $gallery_id = (int)$settings['gallery_id'];

                // Detect Elementor editor/preview context
                $is_elementor_editor = false;
                if (class_exists('\Elementor\Plugin')) {
                    if (\Elementor\Plugin::$instance->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode()) {
                        $is_elementor_editor = true;
                    }
                }

                if ($is_elementor_editor) {
                    // In Elementor editor: inject CSS <link> tags directly into the HTML output
                    // because wp_enqueue_style() calls are ignored during AJAX widget re-renders.
                    $css_files = array(
                        GG_PLUGIN_URL . 'assets/css/jquery.gridder.min.css',
                        GG_PLUGIN_URL . 'assets/css/grid-gallery-frontend.css',
                        GG_PLUGIN_URL . 'assets/css/hover.css',
                    );
                    $ver = GG_PLUGIN_VER;
                    foreach ($css_files as $css_url) {
                        $css_url_versioned = esc_url($css_url) . '?ver=' . esc_attr($ver);
                        echo '<link rel="stylesheet" href="' . $css_url_versioned . '" type="text/css" media="all" />' . "\n";
                    }
                    // Inline override style to make sure it is visible
                    echo '<style type="text/css">
                        .gg-gallery-outer-wrap .gridder { opacity: 1 !important; }
                        .gg-gallery-loader { display: none !important; }
                    </style>';
                }

                // Render the gallery shortcode
                echo do_shortcode('[GGAL id=' . $gallery_id . ']');

                if ($is_elementor_editor) {
                    // In Elementor editor: inject inline JS to initialize Gridder and show gallery.
                    $gg_settings = get_post_meta($gallery_id, 'awl_gg_settings_' . $gallery_id, true);
                    $scroll_loading = isset($gg_settings['scroll_loading']) && $gg_settings['scroll_loading'] !== '' ? $gg_settings['scroll_loading'] : "true";
                    $animation_speed = isset($gg_settings['animation_speed']) && $gg_settings['animation_speed'] !== '' ? intval($gg_settings['animation_speed']) : 400;
                    $easing_effect = isset($gg_settings['easing_effect']) && $gg_settings['easing_effect'] !== '' ? $gg_settings['easing_effect'] : "easeInSine";
                    $thumbnail_border = isset($gg_settings['thumbnail_border']) ? $gg_settings['thumbnail_border'] : "hide";
                    $thumb_bor = ($thumbnail_border === "show") ? "gg-thumbnail" : "";
                    ?>
                    <script type="text/javascript">
                    (function() {
                        function ggInitGallery() {
                            if (typeof jQuery === 'undefined') return;
                            var $ = jQuery;
                            var $grid = $('.gg-<?php echo esc_js($gallery_id); ?>');
                            if (!$grid.length) return;
                            if (typeof $.fn.gridderExpander === 'undefined') return;

                            $grid.gridderExpander({
                                scroll: <?php echo esc_js($scroll_loading); ?>,
                                scrollOffset: 100,
                                scrollTo: 'panel',
                                animationSpeed: <?php echo esc_js($animation_speed); ?>,
                                animationEasing: '<?php echo esc_js($easing_effect); ?>',
                                showNav: true,
                                nextText: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle;"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>',
                                prevText: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle;"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                                closeText: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle;"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>',
                                onContent: function (f) {
                                    if (f && f.addClass) {
                                        f.addClass('gg-gridder-show');
                                        var thumbBor = '<?php echo esc_js($thumb_bor); ?>';
                                        if (thumbBor) {
                                            f.find('.gridder-expanded-content').addClass(thumbBor);
                                        }
                                    }
                                }
                            });

                            if (typeof window.ggInitLazyLoading === 'function') {
                                window.ggInitLazyLoading();
                            } else {
                                $('.gg-lazy-bg').each(function() {
                                    var bgUrl = $(this).attr('data-bg');
                                    if (bgUrl) {
                                        $(this).css('background-image', 'url(' + bgUrl + ')').addClass('gg-loaded');
                                    }
                                });
                            }
                        }

                        ggInitGallery();
                        setTimeout(ggInitGallery, 500);
                        setTimeout(ggInitGallery, 1500);
                    })();
                    </script>
                    <?php
                }
            }
        }

        // Register widget instance
        $widgets_manager->register(new \Elementor_Grid_Gallery_Widget());
    }
}
