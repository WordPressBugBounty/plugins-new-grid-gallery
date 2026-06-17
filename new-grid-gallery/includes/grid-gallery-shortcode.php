<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
add_shortcode('GGAL', 'awl_grid_gallery_shortcode');
function awl_grid_gallery_shortcode($atts) {
	$atts = shortcode_atts( array('id' => 0), $atts, 'GGAL' );
	$grid_gallery_id = intval($atts['id']);
	if ( ! $grid_gallery_id ) {
		return '';
	}

	ob_start();
	//css
	wp_enqueue_style('gg-gridder-css'); 
	wp_enqueue_style('gg-frontend-css'); 
	
	//js
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-effects-core');
	wp_enqueue_script('awl-gridder-js');
	
	$gg_settings     = get_post_meta( $grid_gallery_id, 'awl_gg_settings_' . $grid_gallery_id, true );
	
	if(isset($gg_settings['easing_effect']) && $gg_settings['easing_effect'] !== '') $easing_effect = $gg_settings['easing_effect']; else $easing_effect = "easeInSine";
	if(isset($gg_settings['animation_speed']) && $gg_settings['animation_speed'] !== '') $animation_speed = $gg_settings['animation_speed']; else $animation_speed = 400;
	if(isset($gg_settings['scroll_loading']) && $gg_settings['scroll_loading'] !== '') $scroll_loading = $gg_settings['scroll_loading']; else $scroll_loading = "true";
	if(isset($gg_settings['thumbnail_border'])) $thumbnail_border = $gg_settings['thumbnail_border']; else $thumbnail_border = "hide";
		if($thumbnail_border == "hide"){ $thumb_bor = " "; }
		if($thumbnail_border == "show"){ $thumb_bor = "gg-thumbnail"; }
	
	//hover effect
	if (isset($gg_settings['image_hover_effect_four'])) {
		$image_hover_effect = $gg_settings['image_hover_effect_four'];
	} elseif (isset($gg_settings['image_hover_effect_type'])) {
		if ($gg_settings['image_hover_effect_type'] === 'no') {
			$image_hover_effect = 'none';
		} elseif ($gg_settings['image_hover_effect_type'] === '2d' && isset($gg_settings['image_hover_effect_one'])) {
			$image_hover_effect = $gg_settings['image_hover_effect_one'];
		} else {
			$image_hover_effect = 'hvr-grow';
		}
	} else {
		$image_hover_effect = 'hvr-grow';
	}

	if ($image_hover_effect === 'none' || empty($image_hover_effect)) {
		$image_hover_effect = '';
	} else {
		// hover csss
		wp_enqueue_style('ggp-hover-css', GG_PLUGIN_URL .'assets/css/hover.css');
	}

	if(isset($gg_settings['thumbnail_order'])) $thumbnail_order = $gg_settings['thumbnail_order']; else $thumbnail_order = "ASC";
	if(isset($gg_settings['gal_thumb_size'])) $gal_thumb_size = $gg_settings['gal_thumb_size']; else $gal_thumb_size = "large";
	
	//spacing setting
	if(isset($gg_settings['no_spacing'])) $no_spacing = $gg_settings['no_spacing']; else $no_spacing = "no";
	
	$thumbnail_border = isset($gg_settings['thumbnail_border']) ? $gg_settings['thumbnail_border'] : "hide";
	$thumb_border_thickness = ($thumbnail_border === 'show') ? 8 : 0;
	$thumb_radius_val = ($thumbnail_border === 'show') ? 8 : 0;
	$thumb_radius = $thumb_radius_val . "px";


	if(isset($gg_settings['title_setting'])) $title_setting = $gg_settings['title_setting']; else $title_setting = "show";
	if(isset($gg_settings['title_size'])) $title_size = $gg_settings['title_size']; else $title_size = 20;
	if(isset($gg_settings['title_color'])) $title_color = $gg_settings['title_color']; else $title_color = "#ffffff";
	$desc_setting = "hide";
	if(isset($gg_settings['images_link'])) $images_link = $gg_settings['images_link']; else $images_link = "text";
	if(isset($gg_settings['link_text'])) $link_text = $gg_settings['link_text']; else $link_text = "Read More";
	if(isset($gg_settings['thumb_title'])) $thumb_title = $gg_settings['thumb_title']; else $thumb_title = "show";
	$thumb_desc = "hide";
	if(isset($gg_settings['thumb_title_display'])) $thumb_title_display = $gg_settings['thumb_title_display']; else $thumb_title_display = "hover";
	$g_gallery_load_more = "no";
	if(isset($gg_settings['url_target'])) $url_target = $gg_settings['url_target']; else $url_target = "_new";
	// Resolve per-gallery loading settings (global settings page removed)
	$lazy_loading = 'yes';
	$skeleton_loading = 'no';
	$gallery_loader = isset($gg_settings['gallery_loader']) ? $gg_settings['gallery_loader'] : 'spinner';
	$gallery_loader_color = isset($gg_settings['gallery_loader_color']) ? $gg_settings['gallery_loader_color'] : '#4f46e5';
	$custom_css = isset($gg_settings['custom-css']) ? $gg_settings['custom-css'] : '';
	$preview_layout_mode  = 'overlay';
	$preview_show_exif    = isset($gg_settings['preview_show_exif']) ? $gg_settings['preview_show_exif'] : 'no';

	if ($no_spacing == "yes") {
		$item_margin = "0%";
		$show_width = "100%";
		$show_pad_left = "0%";
		$show_pad_right = "0%";
		$gridder_margin = "0px";
	} else {
		$item_margin = "0.5%";
		$show_width = "100%";
		$show_pad_left = "0.6%";
		$show_pad_right = "0.5%";
		$gridder_margin = "0px";
	}

	$col_large_desktops = isset($gg_settings['col_large_desktops']) ? $gg_settings['col_large_desktops'] : "3_column";
	$col_tablets = $col_large_desktops;
	$col_mobiles = $col_large_desktops;

	$get_col_width = function($col_setting, $no_spacing) {
		if ($no_spacing == "yes") {
			switch ($col_setting) {
				case "1_column": return "100%";
				case "2_column": return "50%";
				case "3_column": return "33.333%";
				case "4_column": return "25%";
				case "5_column": return "20%";
				case "6_column": return "16.666%";
				default: return "33.333%";
			}
		} else {
			switch ($col_setting) {
				case "1_column": return "99%";
				case "2_column": return "49%";
				case "3_column": return "32.33%";
				case "4_column": return "24%";
				case "5_column": return "19%";
				case "6_column": return "15.65%";
				default: return "32.33%";
			}
		}
	};

	$col_width = $get_col_width($col_large_desktops, $no_spacing);
	$tablet_width = $col_width;
	$mobile_width = $col_width;
	$small_mobile_width = $col_width;
	$padding_val = ($thumbnail_border == "show") ? $thumb_border_thickness : 0;

	$inner_thumb_radius = ($thumbnail_border == "show") ? "calc({$thumb_radius} - 4px)" : $thumb_radius;

	$nbp_setting = "in";
	$nav_pos = "absolute";
	$nav_margin_top = "10px";
	if (isset($gg_settings['nbp_setting2'])) $nbp_setting2 = $gg_settings['nbp_setting2']; else $nbp_setting2 = "left";
	if ($nbp_setting2 == "left") {
		$nav_left = "16px";
		$nav_right = "auto";
	} else {
		$nav_left = "auto";
		$nav_right = "16px";
	}
	$nav_align = $nbp_setting2;

	$thumbnail_border_css = "1px solid #ddd";

	$title_font = "'Outfit', 'Inter', sans-serif";
	$title_weight = "700";
	$title_size_px = $title_size . "px";
	$title_color_val = $title_color;
	$title_margin_val = "0 0 12px 0";

	$link_pad_left = "15px";
	$link_pad_right = "15px";
	$link_width = "auto";



	$loader_color = $gallery_loader_color;
	$loader_opacity = ($gallery_loader !== 'none') ? '0' : '1';

	$grid_ratio = isset($gg_settings['grid_ratio']) ? $gg_settings['grid_ratio'] : "4_3";
	if ($grid_ratio == "original") {
		$aspect_ratio_val = "auto";
		$aspect_height_val = "250px";
	} else {
		$ratio_value = "4 / 3";
		switch ($grid_ratio) {
			case "1_1": $ratio_value = "1 / 1"; break;
			case "4_3":
			default: $ratio_value = "4 / 3"; break;
		}
		$aspect_ratio_val = $ratio_value;
		$aspect_height_val = "auto";
	}
	$opacity_1 = '0.95';
	$opacity_2 = '0.4';
	$opacity_3 = '0';

	$overlay_justify = 'flex-end';
	$overlay_gradient = "linear-gradient(to top, rgba(0, 0, 0, $opacity_1) 0%, rgba(0, 0, 0, $opacity_2) 60%, rgba(0, 0, 0, $opacity_3) 100%)";
	$overlay_top = "auto";
	$overlay_bottom = "0";
	$overlay_radius_tl = "0";
	$overlay_radius_tr = "0";
	$overlay_radius_bl = "var(--gg-inner-thumb-radius)";
	$overlay_radius_br = "var(--gg-inner-thumb-radius)";

	if ($thumb_title_display === 'always') {
		$overlay_opacity = '1';
		$overlay_title_transform = 'translateY(0)';
		$preview_opacity = '1';
		$preview_title_transform = 'translateY(0)';
		$preview_pointer_events = 'auto';
	} else {
		$overlay_opacity = '0';
		$overlay_title_transform = 'translateY(15px)';
		$preview_opacity = '0';
		$preview_title_transform = 'translateY(15px)';
		$preview_pointer_events = 'none';
	}

	$preview_align_items = "flex-start";
	$preview_text_align = "left";

	$preview_overlay_top = "auto";
	$preview_overlay_bottom = "0px";
	$preview_overlay_top_offset = "auto";
	$preview_overlay_bottom_offset = "var(--gg-thumb-padding, 4px)";
	$preview_overlay_justify = "flex-end";
	$preview_overlay_gradient = "linear-gradient(to top, rgba(0, 0, 0, $opacity_1) 0%, rgba(0, 0, 0, $opacity_2) 60%, rgba(0, 0, 0, $opacity_3) 100%)";
	
	$preview_radius_tl = "0px";
	$preview_radius_tr = "0px";
	$preview_radius_bl = $thumb_radius;
	$preview_radius_br = $thumb_radius;
	
	$preview_inner_radius_tl = "0px";
	$preview_inner_radius_tr = "0px";
	$preview_inner_radius_bl = $inner_thumb_radius;
	$preview_inner_radius_br = $inner_thumb_radius;

	$dynamic_css = "
	#gg_gallery_wrap_{$grid_gallery_id}, #main_gg_{$grid_gallery_id}, .gg_load_more_{$grid_gallery_id} {
		--gg-item-margin: {$item_margin};
		--gg-show-width: {$show_width};
		--gg-show-pad-left: {$show_pad_left};
		--gg-show-pad-right: {$show_pad_right};
		--gg-gridder-margin: {$gridder_margin};
		
		--gg-col-width: {$col_width};
		--gg-tablet-width: {$tablet_width};
		--gg-mobile-width: {$mobile_width};
		--gg-small-mobile-width: {$small_mobile_width};
		
		--gg-thumb-radius: {$thumb_radius};
		--gg-thumb-padding: {$padding_val}px;
		--gg-inner-thumb-radius: {$inner_thumb_radius};
		
		--gg-nav-pos: {$nav_pos};
		--gg-nav-align: {$nav_align};
		--gg-nav-left: {$nav_left};
		--gg-nav-right: {$nav_right};
		--gg-nav-margin-top: {$nav_margin_top};
		
		--gg-thumbnail-border: {$thumbnail_border_css};
		
		
		--gg-title-font: {$title_font};
		--gg-title-weight: {$title_weight};
		--gg-title-size: {$title_size_px};
		--gg-title-color: {$title_color_val};
		--gg-title-margin: {$title_margin_val};
		
		
		--gg-link-padding-left: {$link_pad_left};
		--gg-link-padding-right: {$link_pad_right};
		--gg-link-width: {$link_width};
		

		--gg-loader-color: {$loader_color};
		--gg-loader-opacity: {$loader_opacity};
		
		--gg-aspect-ratio: {$aspect_ratio_val};
		--gg-aspect-height: {$aspect_height_val};
		
		--gg-overlay-gradient: {$overlay_gradient};
		--gg-overlay-justify: {$overlay_justify};
		--gg-overlay-align-items: {$preview_align_items};
		--gg-overlay-text-align: {$preview_text_align};
		--gg-overlay-opacity: {$overlay_opacity};
		--gg-overlay-title-transform: {$overlay_title_transform};

		--gg-overlay-top: {$overlay_top};
		--gg-overlay-bottom: {$overlay_bottom};
		--gg-overlay-radius-tl: {$overlay_radius_tl};
		--gg-overlay-radius-tr: {$overlay_radius_tr};
		--gg-overlay-radius-bl: {$overlay_radius_bl};
		--gg-overlay-radius-br: {$overlay_radius_br};
		
		--gg-preview-panel-bg: #000000;
		--gg-preview-align-items: {$preview_align_items};
		--gg-preview-text-align: {$preview_text_align};
		--gg-preview-overlay-gradient: {$preview_overlay_gradient};
		--gg-preview-opacity: {$preview_opacity};
		--gg-preview-title-transform: {$preview_title_transform};

		--gg-preview-pointer-events: {$preview_pointer_events};
		
		--gg-preview-overlay-top: {$preview_overlay_top};
		--gg-preview-overlay-bottom: {$preview_overlay_bottom};
		--gg-preview-overlay-top-offset: {$preview_overlay_top_offset};
		--gg-preview-overlay-bottom-offset: {$preview_overlay_bottom_offset};
		--gg-preview-overlay-justify: {$preview_overlay_justify};
		--gg-preview-overlay-gradient: {$preview_overlay_gradient};
		
		--gg-preview-radius-tl: {$preview_radius_tl};
		--gg-preview-radius-tr: {$preview_radius_tr};
		--gg-preview-radius-bl: {$preview_radius_bl};
		--gg-preview-radius-br: {$preview_radius_br};
		
		--gg-preview-inner-radius-tl: {$preview_inner_radius_tl};
		--gg-preview-inner-radius-tr: {$preview_inner_radius_tr};
		--gg-preview-inner-radius-bl: {$preview_inner_radius_bl};
		--gg-preview-inner-radius-br: {$preview_inner_radius_br};
		
	}
	";

	if ( ! empty( $custom_css ) ) {
		$dynamic_css .= wp_strip_all_tags( $custom_css );
	}
	
	// Print dynamic CSS directly in the shortcode output to guarantee FSE/Block theme compatibility
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo "<style type='text/css' id='gg-dynamic-css-" . esc_attr($grid_gallery_id) . "'>" . $dynamic_css . "</style>";

	$inline_js = "
	window.ggInitLazyLoading = function() {
		if ('IntersectionObserver' in window) {
			if (!window.ggLazyBgObs) {
				window.ggLazyBgObs = new IntersectionObserver(function(entries, observer) {
					entries.forEach(function(entry) {
						if (entry.isIntersecting) {
							var el = entry.target;
							var bgUrl = el.getAttribute('data-bg');
							if (bgUrl) {
								if (el.classList.contains('gg-loading')) {
									var img = new Image();
									img.onload = function() {
										if (!el.classList.contains('gg-loaded')) {
											el.style.backgroundImage = 'url(' + bgUrl + ')';
											el.classList.remove('gg-loading');
											el.classList.add('gg-loaded');
										}
									};
									img.src = bgUrl;
									if (img.complete) {
										el.style.backgroundImage = 'url(' + bgUrl + ')';
										el.classList.remove('gg-loading');
										el.classList.add('gg-loaded');
									}
								} else {
									el.style.backgroundImage = 'url(' + bgUrl + ')';
									el.classList.add('gg-loaded');
								}
							}
							observer.unobserve(el);
						}
					});
				}, {
					rootMargin: '200px 0px',
					threshold: 0.01
				});
			}
			document.querySelectorAll('.gg-lazy-bg:not(.gg-observed)').forEach(function(el) {
				el.classList.add('gg-observed');
				window.ggLazyBgObs.observe(el);
			});
		} else {
			document.querySelectorAll('.gg-lazy-bg:not(.gg-loaded)').forEach(function(el) {
				var bgUrl = el.getAttribute('data-bg');
				if (bgUrl) {
					el.style.backgroundImage = 'url(' + bgUrl + ')';
					el.classList.remove('gg-loading');
					el.classList.add('gg-loaded');
				}
			});
		}

		// Handle non-lazy skeleton loaders
		document.querySelectorAll('.gg-loading:not(.gg-lazy-bg)').forEach(function(el) {
			var style = window.getComputedStyle(el);
			var bg = style.backgroundImage;
			if (bg && bg !== 'none') {
				var url = bg.replace(/url\\(['\"]?(.*?)['\"]?\\)/i, '$1');
				if (url) {
					var img = new Image();
					img.onload = function() {
						el.classList.remove('gg-loading');
						el.classList.add('gg-loaded');
					};
					img.src = url;
					if (img.complete) {
						el.classList.remove('gg-loading');
						el.classList.add('gg-loaded');
					}
				}
			} else {
				// If no background image yet, check periodically or remove
				setTimeout(function() {
					el.classList.remove('gg-loading');
					el.classList.add('gg-loaded');
				}, 1000);
			}
		});
	};
	";
	$inline_js .= "
	jQuery(document).ready(function (jQuery) {
		jQuery('.gg-" . esc_js($grid_gallery_id) . "').gridderExpander({
			scroll: " . esc_js($scroll_loading) . ",
			scrollOffset: 100,
			scrollTo: 'panel',
			animationSpeed: " . esc_js($animation_speed) . ",
			animationEasing: '" . esc_js($easing_effect) . "',
			showNav: true,
			nextText: '<svg width=\"18\" height=\"18\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\" style=\"vertical-align: middle;\"><line x1=\"5\" y1=\"12\" x2=\"19\" y2=\"12\"></line><polyline points=\"12 5 19 12 12 19\"></polyline></svg>',
			prevText: '<svg width=\"18\" height=\"18\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\" style=\"vertical-align: middle;\"><line x1=\"19\" y1=\"12\" x2=\"5\" y2=\"12\"></line><polyline points=\"12 19 5 12 12 5\"></polyline></svg>',
			closeText: '<svg width=\"18\" height=\"18\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\" style=\"vertical-align: middle;\"><line x1=\"18\" y1=\"6\" x2=\"6\" y2=\"18\"></line><line x1=\"6\" y1=\"6\" x2=\"18\" y2=\"18\"></line></svg>',
			onStart: function () {
				console.log('Gridder Inititialized');
			},
			onContent: function (f) {
				console.log('Gridder Content Loaded');
				if (f && f.addClass) {
					f.addClass('gg-gridder-show');
					var thumbBor = '" . esc_js(trim($thumb_bor)) . "';
					if (thumbBor) {
						f.find('.gridder-expanded-content').addClass(thumbBor);
					}
				}
			},
			onClosed: function () {
				console.log('Gridder Closed');
			}
		});

		// Initialize lazy loading / skeleton load for initial items
		window.ggInitLazyLoading();

		// Handle gallery loader fade out / fade in
		var \$wrapper = jQuery('#main_gg_" . esc_js($grid_gallery_id) . ", #gg_gallery_wrap_" . esc_js($grid_gallery_id) . "');
		var \$loader = \$wrapper.find('.gg-gallery-loader');
		var \$gallery = \$wrapper.find('.gridder');
		if (\$loader.length) {
			\$loader.fadeOut(300, function() {
				\$gallery.animate({ opacity: 1 }, 400);
			});
		} else {
			\$gallery.css('opacity', 1);
		}
	});
	";

	// Hook JS execution directly into wp_footer to guarantee FSE/Block theme compatibility
	add_action( 'wp_footer', function() use ( $inline_js ) {
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo "<script type='text/javascript'>\n" . $inline_js . "\n</script>";
	}, 100 );

	// load without lightbox gallery output using cache transient
	$is_ajax = isset($_POST['gg_security']);
	$gg_start = isset($_POST['gg_limit_start']) ? intval($_POST['gg_limit_start']) : 0;
	$gg_end = isset($_POST['gg_limit_end']) ? intval($_POST['gg_limit_end']) : 0;
	$gg_ordered_ids = isset($_POST['gg_ordered_ids']) ? sanitize_text_field($_POST['gg_ordered_ids']) : '';

	$cache_version = get_post_meta($grid_gallery_id, '_gg_cache_version', true);
	if (!$cache_version) {
		$cache_version = 1;
		update_post_meta($grid_gallery_id, '_gg_cache_version', $cache_version);
	}

	$global_cache_version = get_option('awl_gg_global_cache_version', 1);
	$cache_key = 'gg_c_opt_' . $grid_gallery_id . '_v' . $cache_version . '_g' . $global_cache_version;
	if ($is_ajax) {
		$cache_key .= '_a_' . $gg_start . '_' . $gg_end . '_' . md5($gg_ordered_ids);
	}

	$cached_html = get_transient($cache_key);
	if ($cached_html !== false) {
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $cached_html;
	} else {
		ob_start();
		require( GG_PLUGIN_DIR . 'includes/grid-gallery-output.php' );
		$gallery_html = ob_get_clean();

		// Apply lazy loading / skeleton loading transformations via regex
		if ($lazy_loading === 'yes') {
			$extra_classes = 'gg-lazy-bg';
			if ($skeleton_loading === 'yes') {
				$extra_classes .= ' gg-loading';
			}
			$gallery_html = preg_replace(
				'/<div\s+style="background-image:\s*url\(([\'"]?)(.*?)\1\)"\s+class="image">/',
				'<div data-bg="$2" class="image ' . $extra_classes . '">',
				$gallery_html
			);
		} elseif ($skeleton_loading === 'yes') {
			$gallery_html = preg_replace(
				'/<div\s+(style="background-image:\s*url\(([\'"]?)(.*?)\2\)")\s+class="image">/',
				'<div $1 class="image gg-loading">',
				$gallery_html
			);
		}

		set_transient($cache_key, $gallery_html, 12 * HOUR_IN_SECONDS);
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $gallery_html;
	}
	return ob_get_clean();
}
?>