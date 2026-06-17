<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Enqueue Indigo CSS for the new admin layout
wp_enqueue_style('awl-gg-admin-style-css', GG_PLUGIN_URL . 'assets/css/gg-admin-style.css', array('dashicons'), GG_PLUGIN_VER);

$gg_settings = get_post_meta( $post->ID, 'awl_gg_settings_' . $post->ID, true );
$grid_gallery_id = esc_attr($post->ID);
?>
<style>
/* hide permalink */
#edit-slug-box {
	display:none;
}
</style>
	<!-- Tab 2: Layout & Style -->
	<div class="awl-gg-tab-content" id="tab-layout-style">
		<!-- Card 1: Grid Columns & Layout -->
		<div class="awl-gg-card gg-card-compact">
			<h3><?php esc_html_e('Grid Columns & Layout', 'new-grid-gallery'); ?></h3>
			
			<!-- Grid Columns -->
			<div class="awl-gg-setting-row">
				<div class="awl-gg-setting-label">
					<h4><?php esc_html_e('Grid Columns', 'new-grid-gallery'); ?></h4>
					<p><?php esc_html_e('Select the number of columns to display.', 'new-grid-gallery'); ?></p>
				</div>
				<div class="awl-gg-setting-field">
					<?php if(isset($gg_settings['col_large_desktops'])) $col_large_desktops = $gg_settings['col_large_desktops']; else $col_large_desktops = "3_column"; ?>
					<select id="col_large_desktops" name="col_large_desktops" class="gg-select" style="width: 300px;">
						<option value="1_column" <?php selected($col_large_desktops, "1_column"); ?>><?php esc_html_e('1 Column', 'new-grid-gallery'); ?></option>
						<option value="2_column" <?php selected($col_large_desktops, "2_column"); ?>><?php esc_html_e('2 Column', 'new-grid-gallery'); ?></option>
						<option value="3_column" <?php selected($col_large_desktops, "3_column"); ?>><?php esc_html_e('3 Column', 'new-grid-gallery'); ?></option>
						<option value="4_column" <?php selected($col_large_desktops, "4_column"); ?>><?php esc_html_e('4 Column', 'new-grid-gallery'); ?></option>
						<option value="5_column" <?php selected($col_large_desktops, "5_column"); ?>><?php esc_html_e('5 Column', 'new-grid-gallery'); ?></option>
						<option value="6_column" <?php selected($col_large_desktops, "6_column"); ?>><?php esc_html_e('6 Column', 'new-grid-gallery'); ?></option>
					</select>
				</div>
			</div>

			<!-- Image Source Quality -->
			<div class="awl-gg-setting-row">
				<div class="awl-gg-setting-label">
					<h4><?php esc_html_e('Image Source Quality', 'new-grid-gallery'); ?></h4>
					<p><?php esc_html_e('Choose which WordPress image resolution to load for the grid thumbnails to optimize page load speeds.', 'new-grid-gallery'); ?></p>
				</div>
				<div class="awl-gg-setting-field">
					<?php if(isset($gg_settings['gal_thumb_size'])) $gal_thumb_size = $gg_settings['gal_thumb_size']; else $gal_thumb_size = "large"; ?>
					<select id="gal_thumb_size" name="gal_thumb_size" class="gg-select" style="width: 300px;">
						<option value="thumbnail" <?php selected($gal_thumb_size, "thumbnail"); ?>><?php esc_html_e('Thumbnail – 150 × 150', 'new-grid-gallery'); ?></option>
						<option value="medium" <?php selected($gal_thumb_size, "medium"); ?>><?php esc_html_e('Medium – 300 × 169', 'new-grid-gallery'); ?></option>
						<option value="large" <?php selected($gal_thumb_size, "large"); ?>><?php esc_html_e('Large – 1280 × 720', 'new-grid-gallery'); ?></option>
						<option value="full" <?php selected($gal_thumb_size, "full"); ?>><?php esc_html_e('Full Size', 'new-grid-gallery'); ?></option>
					</select>
				</div>
			</div>

			<!-- Thumbnail Aspect Ratio -->
			<div class="awl-gg-setting-row">
				<div class="awl-gg-setting-label">
					<h4><?php esc_html_e('Grid Crop Shape (Aspect Ratio)', 'new-grid-gallery'); ?></h4>
					<p><?php esc_html_e('Choose the geometric shape/ratio for the grid thumbnails (e.g. Square, Widescreen, Portrait).', 'new-grid-gallery'); ?></p>
				</div>
				<div class="awl-gg-setting-field">
					<?php if(isset($gg_settings['grid_ratio']) && $gg_settings['grid_ratio'] !== 'original') $grid_ratio = $gg_settings['grid_ratio']; else $grid_ratio = "4_3"; ?>
					<select id="grid_ratio" name="grid_ratio" class="gg-select" style="width: 300px;">
						<option value="1_1" <?php selected($grid_ratio, "1_1"); ?>><?php esc_html_e('1:1 Square', 'new-grid-gallery'); ?></option>
						<option value="4_3" <?php selected($grid_ratio, "4_3"); ?>><?php esc_html_e('4:3 Classic', 'new-grid-gallery'); ?></option>
					</select>
				</div>
			</div>

		</div>

		<!-- Card 2: Borders, Frames & Animations -->
		<div class="awl-gg-card gg-card-compact">
			<h3><?php esc_html_e('Spacing, Frames & Hover Effect', 'new-grid-gallery'); ?></h3>

			<!-- Show Spacing (Gaps) -->
			<div class="awl-gg-setting-row">
				<div class="awl-gg-setting-label">
					<h4><?php esc_html_e('Show Spacing (Gaps)', 'new-grid-gallery'); ?></h4>
					<p><?php esc_html_e('Enable spacing and margins between thumbnails.', 'new-grid-gallery'); ?></p>
				</div>
				<div class="awl-gg-setting-field">
					<?php if(isset($gg_settings['no_spacing'])) $no_spacing = $gg_settings['no_spacing']; else $no_spacing = "no"; ?>
					<div class="gg-segmented-control">
						<input type="radio" name="no_spacing" id="no_spacing1" value="no" <?php checked($no_spacing, "no"); ?>>
						<label for="no_spacing1"><?php esc_html_e('Yes', 'new-grid-gallery'); ?></label>
						<input type="radio" name="no_spacing" id="no_spacing2" value="yes" <?php checked($no_spacing, "yes"); ?>>
						<label for="no_spacing2"><?php esc_html_e('No', 'new-grid-gallery'); ?></label>
					</div>
				</div>
			</div>

			<!-- Show Thumbnail Frame Container -->
			<div class="awl-gg-setting-row">
				<div class="awl-gg-setting-label">
					<h4><?php esc_html_e('Show Thumbnail Frame Container', 'new-grid-gallery'); ?></h4>
					<p><?php esc_html_e('Enable a padded background frame (card outline) around each thumbnail.', 'new-grid-gallery'); ?></p>
				</div>
				<div class="awl-gg-setting-field">
					<?php if(isset($gg_settings['thumbnail_border'])) $thumbnail_border = $gg_settings['thumbnail_border']; else $thumbnail_border = "hide"; ?>
					<div class="gg-segmented-control">
						<input type="radio" name="thumbnail_border" id="thumbnail_border2" value="show" <?php checked($thumbnail_border, "show"); ?>>
						<label for="thumbnail_border2"><?php esc_html_e('Yes', 'new-grid-gallery'); ?></label>
						<input type="radio" name="thumbnail_border" id="thumbnail_border1" value="hide" <?php checked($thumbnail_border, "hide"); ?>>
						<label for="thumbnail_border1"><?php esc_html_e('No', 'new-grid-gallery'); ?></label>
					</div>
				</div>
			</div>
			
			<!-- Hover Animation Style -->
			<div class="awl-gg-setting-row">
				<div class="awl-gg-setting-label">
					<h4><?php esc_html_e('Hover Animation Style', 'new-grid-gallery'); ?></h4>
					<p><?php esc_html_e('Choose the hover effect applied to thumbnails.', 'new-grid-gallery'); ?></p>
				</div>
				<div class="awl-gg-setting-field">
					<?php if(isset($gg_settings['image_hover_effect_four'])) $image_hover_effect_four = $gg_settings['image_hover_effect_four']; else $image_hover_effect_four = "hvr-grow"; ?>
					<select name="image_hover_effect_four" id="image_hover_effect_four" class="gg-select" style="width: 250px;">
						<option value="hvr-grow" <?php selected($image_hover_effect_four, "hvr-grow"); ?>><?php esc_html_e('Grow', 'new-grid-gallery'); ?></option>
						<option value="hvr-shrink" <?php selected($image_hover_effect_four, "hvr-shrink"); ?>><?php esc_html_e('Shrink', 'new-grid-gallery'); ?></option>
						<option value="hvr-float-shadow" <?php selected($image_hover_effect_four, "hvr-float-shadow"); ?>><?php esc_html_e('Float Shadow', 'new-grid-gallery'); ?></option>
						<option value="hvr-shadow-radial" <?php selected($image_hover_effect_four, "hvr-shadow-radial"); ?>><?php esc_html_e('Shadow Radial', 'new-grid-gallery'); ?></option>
						<option value="hvr-box-shadow-outset" <?php selected($image_hover_effect_four, "hvr-box-shadow-outset"); ?>><?php esc_html_e('Box Shadow Outset', 'new-grid-gallery'); ?></option>
						<option value="none" <?php selected($image_hover_effect_four, "none"); ?>><?php esc_html_e('None', 'new-grid-gallery'); ?></option>
					</select>
				</div>
			</div>
		</div>

		<!-- Card 3: Grid Loading & Sort Order -->
		<div class="awl-gg-card gg-card-compact">
			<h3><?php esc_html_e('Grid Loading & Sort Order', 'new-grid-gallery'); ?></h3>
			
			<!-- Loading Spinner Type -->
			<div class="awl-gg-setting-row">
				<div class="awl-gg-setting-label">
					<h4><?php esc_html_e('Gallery Loading Icon Style', 'new-grid-gallery'); ?></h4>
					<p><?php esc_html_e('Select loading spinner for the gallery during initialization.', 'new-grid-gallery'); ?></p>
				</div>
				<div class="awl-gg-setting-field gg-flex-wrap">
					<?php if(isset($gg_settings['gallery_loader'])) $gallery_loader = $gg_settings['gallery_loader']; else $gallery_loader = "spinner"; ?>
					<div class="gg-segmented-control">
						<input type="radio" id="loader_spinner" name="gallery_loader" value="spinner" <?php checked($gallery_loader, 'spinner'); ?>>
						<label for="loader_spinner"><?php esc_html_e('Spinner', 'new-grid-gallery'); ?></label>
						
						<input type="radio" id="loader_pulse" name="gallery_loader" value="pulse" <?php checked($gallery_loader, 'pulse'); ?>>
						<label for="loader_pulse"><?php esc_html_e('Pulse', 'new-grid-gallery'); ?></label>

						<input type="radio" id="loader_dots" name="gallery_loader" value="dots" <?php checked($gallery_loader, 'dots'); ?>>
						<label for="loader_dots"><?php esc_html_e('Dots', 'new-grid-gallery'); ?></label>

						<input type="radio" id="loader_none" name="gallery_loader" value="none" <?php checked($gallery_loader, 'none'); ?>>
						<label for="loader_none"><?php esc_html_e('Disabled', 'new-grid-gallery'); ?></label>
					</div>
				</div>
			</div>

			<!-- Loading Icon Color -->
			<div class="awl-gg-setting-row loader-color-row" <?php echo ($gallery_loader == 'none') ? 'style="display:none;"' : ''; ?>>
				<div class="awl-gg-setting-label">
					<h4><?php esc_html_e('Loading Icon Color', 'new-grid-gallery'); ?></h4>
					<p><?php esc_html_e('Select color of the loading animation.', 'new-grid-gallery'); ?></p>
				</div>
				<div class="awl-gg-setting-field">
					<?php if(isset($gg_settings['gallery_loader_color'])) $gallery_loader_color = $gg_settings['gallery_loader_color']; else $gallery_loader_color = "#4f46e5"; ?>
					<input type="text" id="gallery_loader_color" name="gallery_loader_color" value="<?php echo esc_attr($gallery_loader_color); ?>" default-color="#4f46e5" class="ig-color-picker">
				</div>
			</div>

			<!-- Thumbnail Sort Order -->
			<div class="awl-gg-setting-row">
				<div class="awl-gg-setting-label">
					<h4><?php esc_html_e('Thumbnail Sort Order', 'new-grid-gallery'); ?></h4>
					<p><?php esc_html_e('Choose the chronological order for displaying thumbnails.', 'new-grid-gallery'); ?></p>
				</div>
				<div class="awl-gg-setting-field">
					<?php if(isset($gg_settings['thumbnail_order'])) $thumbnail_order = $gg_settings['thumbnail_order']; else $thumbnail_order = "ASC"; ?>
					<div class="gg-segmented-control">
						<input type="radio" name="thumbnail_order" id="thumbnail_order1" value="ASC" <?php checked($thumbnail_order, "ASC"); ?>>
						<label for="thumbnail_order1"><?php esc_html_e('Date Added (Oldest First)', 'new-grid-gallery'); ?></label>
						<input type="radio" name="thumbnail_order" id="thumbnail_order2" value="DESC" <?php checked($thumbnail_order, "DESC"); ?>>
						<label for="thumbnail_order2"><?php esc_html_e('Date Added (Newest First)', 'new-grid-gallery'); ?></label>
						<input type="radio" name="thumbnail_order" id="thumbnail_order3" value="RANDOM" <?php checked($thumbnail_order, "RANDOM"); ?>>
						<label for="thumbnail_order3"><?php esc_html_e('Randomized', 'new-grid-gallery'); ?></label>
					</div>
				</div>
			</div>

		</div>
	</div>

	<!-- Tab 3: Typography & Navigation -->
	<div class="awl-gg-tab-content" id="tab-typography-nav">
		<!-- Card 1: Text Overlay & Expanded Preview Settings -->
		<div class="awl-gg-card gg-card-compact">
			<h3><?php esc_html_e('Text Overlay & Expanded Preview Settings', 'new-grid-gallery'); ?></h3>
			

			<!-- Display Title on Thumbnails -->
			<div class="awl-gg-setting-row">
				<div class="awl-gg-setting-label">
					<h4><?php esc_html_e('Show Titles on Thumbnails', 'new-grid-gallery'); ?></h4>
					<p><?php esc_html_e('Display the image title text overlay on the grid thumbnails.', 'new-grid-gallery'); ?></p>
				</div>
				<div class="awl-gg-setting-field">
					<?php if(isset($gg_settings['thumb_title'])) $thumb_title = $gg_settings['thumb_title']; else $thumb_title = "show"; ?>
					<div class="gg-segmented-control">
						<input type="radio" name="thumb_title" id="thumb_title2" value="show" <?php checked($thumb_title, "show"); ?>>
						<label for="thumb_title2"><?php esc_html_e('Yes', 'new-grid-gallery'); ?></label>
						<input type="radio" name="thumb_title" id="thumb_title1" value="hide" <?php checked($thumb_title, "hide"); ?>>
						<label for="thumb_title1"><?php esc_html_e('No', 'new-grid-gallery'); ?></label>
					</div>
				</div>
			</div>

			<!-- Display Title in Preview Panel -->
			<div class="awl-gg-setting-row">
				<div class="awl-gg-setting-label">
					<h4><?php esc_html_e('Show Title in Detail Panel', 'new-grid-gallery'); ?></h4>
					<p><?php esc_html_e('Display the image title inside the expanded detail panel. Enabling this reveals typography customizer styles below.', 'new-grid-gallery'); ?></p>
				</div>
				<div class="awl-gg-setting-field gg-flex-wrap">
					<?php if(isset($gg_settings['title_setting'])) $title_setting = $gg_settings['title_setting']; else $title_setting = "show"; ?>
					<div class="gg-segmented-control">
						<input type="radio" name="title_setting" id="title_setting2" value="show" <?php checked($title_setting, "show"); ?>>
						<label for="title_setting2"><?php esc_html_e('Yes', 'new-grid-gallery'); ?></label>
						<input type="radio" name="title_setting" id="title_setting1" value="hide" <?php checked($title_setting, "hide"); ?>>
						<label for="title_setting1"><?php esc_html_e('No', 'new-grid-gallery'); ?></label>
					</div>

					<div class="tfs gg-inline-options" style="<?php echo ($title_setting == 'show') ? '' : 'display:none;'; ?>">
						<div style="display:flex; flex-direction:column; gap:10px;">
							<label style="font-weight:600; font-size:13px;"><?php esc_html_e('Title Text Size', 'new-grid-gallery'); ?></label>
							<?php if(isset($gg_settings['title_size'])) $title_size = $gg_settings['title_size']; else $title_size = 20; ?>
							<div class="range-slider">
								<input id="title_size" name="title_size" class="range-slider__range" type="range" value="<?php echo esc_attr($title_size); ?>" min="18" max="50" step="2">
								<span class="range-slider__value"><?php echo esc_html($title_size); ?></span>
							</div>
						</div>

						<div style="display:flex; flex-direction:column; gap:10px; margin-left: 20px;">
							<label style="font-weight:600; font-size:13px;"><?php esc_html_e('Title Text Color', 'new-grid-gallery'); ?></label>
							<?php if(isset($gg_settings['title_color'])) $title_color = $gg_settings['title_color']; else $title_color = "#ffffff"; ?>
							<input type="text" id="title_color" name="title_color" value="<?php echo esc_attr($title_color); ?>" default-color="<?php echo esc_attr($title_color); ?>">
						</div>
					</div>
				</div>
			</div>

			<!-- Show Image EXIF Data -->
			<div class="awl-gg-setting-row">
				<div class="awl-gg-setting-label">
					<h4><?php esc_html_e('Show Camera EXIF Metadata', 'new-grid-gallery'); ?></h4>
					<p><?php esc_html_e('Automatically read and display technical camera properties (such as ISO, Shutter speed, Aperture, and Lens) inside the expanded detail panel.', 'new-grid-gallery'); ?></p>
				</div>
				<div class="awl-gg-setting-field">
					<?php $preview_show_exif = isset($gg_settings['preview_show_exif']) ? $gg_settings['preview_show_exif'] : 'no'; ?>
					<div class="gg-segmented-control">
						<input type="radio" name="preview_show_exif" id="preview_show_exif_yes" value="yes" <?php checked($preview_show_exif, 'yes'); ?>>
						<label for="preview_show_exif_yes"><?php esc_html_e('Yes', 'new-grid-gallery'); ?></label>
						<input type="radio" name="preview_show_exif" id="preview_show_exif_no" value="no" <?php checked($preview_show_exif, 'no'); ?>>
						<label for="preview_show_exif_no"><?php esc_html_e('No', 'new-grid-gallery'); ?></label>
					</div>
				</div>
			</div>


			<!-- Text Visibility Trigger -->
			<div class="awl-gg-setting-row" id="thumb_title_display_row">
				<div class="awl-gg-setting-label">
					<h4><?php esc_html_e('Text Overlay Visibility Trigger', 'new-grid-gallery'); ?></h4>
					<p><?php esc_html_e('Choose whether text overlays remain hidden until hovered, or are always visible (applies to both grid thumbnails and detail overlays).', 'new-grid-gallery'); ?></p>
				</div>
				<div class="awl-gg-setting-field">
					<?php if(isset($gg_settings['thumb_title_display'])) $thumb_title_display = $gg_settings['thumb_title_display']; else $thumb_title_display = "hover"; ?>
					<div class="gg-segmented-control">
						<input type="radio" name="thumb_title_display" id="thumb_title_display1" value="hover" <?php checked($thumb_title_display, "hover"); ?>>
						<label for="thumb_title_display1"><?php esc_html_e('On Hover', 'new-grid-gallery'); ?></label>
						<input type="radio" name="thumb_title_display" id="thumb_title_display2" value="always" <?php checked($thumb_title_display, "always"); ?>>
						<label for="thumb_title_display2"><?php esc_html_e('Always', 'new-grid-gallery'); ?></label>
					</div>
				</div>
			</div>

		</div>

		<!-- Card 2: Expanded Drawer Navigation -->
		<div class="awl-gg-card gg-card-compact">
			<h3><?php esc_html_e('Expanded Drawer Navigation', 'new-grid-gallery'); ?></h3>

			<!-- Auto-Scroll to Preview -->
			<div class="awl-gg-setting-row">
				<div class="awl-gg-setting-label">
					<h4><?php esc_html_e('Auto-Scroll to Preview', 'new-grid-gallery'); ?></h4>
					<p><?php esc_html_e('Automatically scroll the browser page to position the expanded preview panel in full view when clicked.', 'new-grid-gallery'); ?></p>
				</div>
				<div class="awl-gg-setting-field">
					<?php if(isset($gg_settings['scroll_loading'])) $scroll_loading = $gg_settings['scroll_loading']; else $scroll_loading = "true"; ?>
					<div class="gg-segmented-control">
						<input type="radio" name="scroll_loading" id="scroll_loading1_nav" value="true" <?php checked($scroll_loading, "true"); ?>>
						<label for="scroll_loading1_nav"><?php esc_html_e('Yes', 'new-grid-gallery'); ?></label>
						<input type="radio" name="scroll_loading" id="scroll_loading2_nav" value="false" <?php checked($scroll_loading, "false"); ?>>
						<label for="scroll_loading2_nav"><?php esc_html_e('No', 'new-grid-gallery'); ?></label>
					</div>
				</div>
			</div>

			<!-- Animation Speed -->
			<div class="awl-gg-setting-row">
				<div class="awl-gg-setting-label">
					<h4><?php esc_html_e('Animation Speed', 'new-grid-gallery'); ?></h4>
					<p><?php esc_html_e('Set open/close transition speed in milliseconds.', 'new-grid-gallery'); ?></p>
				</div>
				<div class="awl-gg-setting-field">
					<?php if(isset($gg_settings['animation_speed']) && $gg_settings['animation_speed'] !== '') $animation_speed = $gg_settings['animation_speed']; else $animation_speed = 400; ?>
					<div class="range-slider">
						<input id="animation_speed" name="animation_speed" class="range-slider__range" type="range" value="<?php echo esc_attr($animation_speed); ?>" min="0" max="2000" step="50">
						<span class="range-slider__value"><?php echo esc_html($animation_speed); ?></span>
					</div>
				</div>
			</div>

			<!-- Animation Easing Effect -->
			<div class="awl-gg-setting-row">
				<div class="awl-gg-setting-label">
					<h4><?php esc_html_e('Animation Easing Effect', 'new-grid-gallery'); ?></h4>
					<p><?php esc_html_e('Choose transition easing effect for image previews.', 'new-grid-gallery'); ?></p>
				</div>
				<div class="awl-gg-setting-field">
					<?php if(isset($gg_settings['easing_effect']) && $gg_settings['easing_effect'] !== '') $easing_effect = $gg_settings['easing_effect']; else $easing_effect = "easeInSine"; ?>
					<select id="easing_effect" name="easing_effect" class="gg-select" style="width: 250px;">
						<option value="easeInSine" <?php selected($easing_effect, "easeInSine"); ?>><?php esc_html_e('easeInSine', 'new-grid-gallery'); ?></option>
						<option value="easeOutSine" <?php selected($easing_effect, "easeOutSine"); ?>><?php esc_html_e('easeOutSine', 'new-grid-gallery'); ?></option>
						<option value="easeInOutSine" <?php selected($easing_effect, "easeInOutSine"); ?>><?php esc_html_e('easeInOutSine', 'new-grid-gallery'); ?></option>
						<option value="easeInQuad" <?php selected($easing_effect, "easeInQuad"); ?>><?php esc_html_e('easeInQuad', 'new-grid-gallery'); ?></option>
						<option value="easeOutQuad" <?php selected($easing_effect, "easeOutQuad"); ?>><?php esc_html_e('easeOutQuad', 'new-grid-gallery'); ?></option>
						<option value="easeInOutQuad" <?php selected($easing_effect, "easeInOutQuad"); ?>><?php esc_html_e('easeInOutQuad', 'new-grid-gallery'); ?></option>
						<option value="easeInCubic" <?php selected($easing_effect, "easeInCubic"); ?>><?php esc_html_e('easeInCubic', 'new-grid-gallery'); ?></option>
						<option value="easeOutCubic" <?php selected($easing_effect, "easeOutCubic"); ?>><?php esc_html_e('easeOutCubic', 'new-grid-gallery'); ?></option>
						<option value="easeInOutCubic" <?php selected($easing_effect, "easeInOutCubic"); ?>><?php esc_html_e('easeInOutCubic', 'new-grid-gallery'); ?></option>
						<option value="easeInQuart" <?php selected($easing_effect, "easeInQuart"); ?>><?php esc_html_e('easeInQuart', 'new-grid-gallery'); ?></option>
						<option value="easeOutQuart" <?php selected($easing_effect, "easeOutQuart"); ?>><?php esc_html_e('easeOutQuart', 'new-grid-gallery'); ?></option>
						<option value="easeInOutQuart" <?php selected($easing_effect, "easeInOutQuart"); ?>><?php esc_html_e('easeInOutQuart', 'new-grid-gallery'); ?></option>
						<option value="easeInQuint" <?php selected($easing_effect, "easeInQuint"); ?>><?php esc_html_e('easeInQuint', 'new-grid-gallery'); ?></option>
						<option value="easeOutQuint" <?php selected($easing_effect, "easeOutQuint"); ?>><?php esc_html_e('easeOutQuint', 'new-grid-gallery'); ?></option>
						<option value="easeInOutQuint" <?php selected($easing_effect, "easeInOutQuint"); ?>><?php esc_html_e('easeInOutQuint', 'new-grid-gallery'); ?></option>
						<option value="easeInExpo" <?php selected($easing_effect, "easeInExpo"); ?>><?php esc_html_e('easeInExpo', 'new-grid-gallery'); ?></option>
						<option value="easeOutExpo" <?php selected($easing_effect, "easeOutExpo"); ?>><?php esc_html_e('easeOutExpo', 'new-grid-gallery'); ?></option>
						<option value="easeInOutExpo" <?php selected($easing_effect, "easeInOutExpo"); ?>><?php esc_html_e('easeInOutExpo', 'new-grid-gallery'); ?></option>
						<option value="easeInCirc" <?php selected($easing_effect, "easeInCirc"); ?>><?php esc_html_e('easeInCirc', 'new-grid-gallery'); ?></option>
						<option value="easeOutCirc" <?php selected($easing_effect, "easeOutCirc"); ?>><?php esc_html_e('easeOutCirc', 'new-grid-gallery'); ?></option>
						<option value="easeInOutCirc" <?php selected($easing_effect, "easeInOutCirc"); ?>><?php esc_html_e('easeInOutCirc', 'new-grid-gallery'); ?></option>
						<option value="easeInBack" <?php selected($easing_effect, "easeInBack"); ?>><?php esc_html_e('easeInBack', 'new-grid-gallery'); ?></option>
						<option value="easeOutBack" <?php selected($easing_effect, "easeOutBack"); ?>><?php esc_html_e('easeOutBack', 'new-grid-gallery'); ?></option>
						<option value="easeInOutBack" <?php selected($easing_effect, "easeInOutBack"); ?>><?php esc_html_e('easeInOutBack', 'new-grid-gallery'); ?></option>
						<option value="easeInElastic" <?php selected($easing_effect, "easeInElastic"); ?>><?php esc_html_e('easeInElastic', 'new-grid-gallery'); ?></option>
					</select>
				</div>
			</div>

			<!-- Preview Navigation Button Position -->
			<div class="awl-gg-setting-row">
				<div class="awl-gg-setting-label">
					<h4><?php esc_html_e('Preview Navigation Button Position', 'new-grid-gallery'); ?></h4>
					<p><?php esc_html_e('Select the position of navigation and close buttons in the preview panel.', 'new-grid-gallery'); ?></p>
				</div>
				<div class="awl-gg-setting-field">
					<?php if(isset($gg_settings['nbp_setting2'])) $nbp_setting2 = $gg_settings['nbp_setting2']; else $nbp_setting2 = "left"; ?>
					<div class="gg-segmented-control">
						<input type="radio" name="nbp_setting2" id="nbp_setting2A_nav" value="left" <?php checked($nbp_setting2, "left"); ?>>
						<label for="nbp_setting2A_nav"><?php esc_html_e('Left', 'new-grid-gallery'); ?></label>
						<input type="radio" name="nbp_setting2" id="nbp_setting2C_nav" value="right" <?php checked($nbp_setting2, "right"); ?>>
						<label for="nbp_setting2C_nav"><?php esc_html_e('Right', 'new-grid-gallery'); ?></label>
					</div>
				</div>
			</div>

			<!-- Clickable Link Trigger Area -->
			<div class="awl-gg-setting-row">
				<div class="awl-gg-setting-label">
					<h4><?php esc_html_e('Clickable Link Trigger Area', 'new-grid-gallery'); ?></h4>
					<p><?php esc_html_e('Select which parts of the thumbnail elements are clickable to trigger the hyperlink.', 'new-grid-gallery'); ?></p>
				</div>
				<div class="awl-gg-setting-field gg-flex-wrap">
					<?php if(isset($gg_settings['images_link'])) $images_link = $gg_settings['images_link']; else $images_link = "text"; ?>
					<div class="gg-segmented-control" style="margin-bottom: 10px;">
						<input type="radio" name="images_link" id="image_link1" value="none" <?php checked($images_link, "none"); ?>>
						<label for="image_link1"><?php esc_html_e('None', 'new-grid-gallery'); ?></label>

						<input type="radio" name="images_link" id="image_link5" value="text" <?php checked($images_link, "text"); ?>>
						<label for="image_link5"><?php esc_html_e('Read More', 'new-grid-gallery'); ?></label>
					</div>

					<div class="ilu gg-inline-options" style="<?php echo ($images_link == 'none') ? 'display:none;' : ''; ?>">
						<span class="gg-option-label"><?php esc_html_e('LINK TARGET WINDOW:', 'new-grid-gallery'); ?></span>
						<?php if(isset($gg_settings['url_target'])) $url_target = $gg_settings['url_target']; else $url_target = "_new"; ?>
						<div class="gg-segmented-control">
							<input type="radio" name="url_target" id="url_target1" value="_new" <?php checked($url_target, "_new"); ?>>
							<label for="url_target1"><?php esc_html_e('New Tab', 'new-grid-gallery'); ?></label>
							<input type="radio" name="url_target" id="url_target2" value="_self" <?php checked($url_target, "_self"); ?>>
							<label for="url_target2"><?php esc_html_e('Same Tab', 'new-grid-gallery'); ?></label>
						</div>
					</div>
				</div>
			</div>

			<!-- Read More Button Customization (Only visible when Link Trigger is set to "Read More") -->
			<div class="gg-read-more-options-wrapper" style="<?php echo ($images_link == 'text') ? '' : 'display:none;'; ?>">
				<!-- Read More Link Text -->
				<div class="awl-gg-setting-row">
					<div class="awl-gg-setting-label">
						<h4><?php esc_html_e('Read More Link Text', 'new-grid-gallery'); ?></h4>
						<p><?php esc_html_e('Customize the text for the preview Read More link.', 'new-grid-gallery'); ?></p>
					</div>
					<div class="awl-gg-setting-field">
						<?php $link_text = isset($gg_settings['link_text']) ? $gg_settings['link_text'] : 'Read More'; ?>
						<input type="text" name="link_text" id="link_text" value="<?php echo esc_attr($link_text); ?>" style="width: 250px;">
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Tab 4: Upgrade to Pro -->
	<div class="awl-gg-tab-content" id="tab-upgrade-pro">
		<div class="awl-upgrade-pro-container">
			<!-- Hero Header -->
			<div class="awl-upgrade-pro-header">
				<h2><?php esc_html_e('Unlock the Full Power of Grid Gallery Premium', 'new-grid-gallery'); ?></h2>
				<p class="pro-description"><?php esc_html_e('Upgrade to the Premium version to get responsive grids with dedicated tablet/mobile columns, inline video embedding for YouTube/Vimeo/Local MP4, frosted glassmorphism overlays, 20+ transition animations, pagination, and much more.', 'new-grid-gallery'); ?></p>
				<div class="header-cta-wrapper" style="margin-top: 25px;">
					<a href="https://awplife.com/wordpress-plugins/grid-gallery-wordpress-plugin/" target="_blank" class="awl-btn-pro-upgrade header-upgrade-btn">
						<span class="dashicons dashicons-star-filled"></span>
						<?php esc_html_e('Upgrade to Grid Gallery Premium Now', 'new-grid-gallery'); ?>
					</a>
				</div>
			</div>

			<!-- Main Premium Features Showcase -->
			<div class="awl-pro-features-section" style="margin-top: 50px; margin-bottom: 50px; position: relative; z-index: 1;">
				<h3 class="awl-pro-grids-title"><?php esc_html_e('Main Premium Features Showcase', 'new-grid-gallery'); ?></h3>
				<p class="awl-pro-grids-subtitle"><?php esc_html_e('Explore the advanced features that make Grid Gallery Premium the ultimate choice for professional WordPress galleries.', 'new-grid-gallery'); ?></p>
				
				<div class="awl-grids-layout-container">
					<!-- Global Settings -->
					<div class="awl-grid-aspect-card">
						<div class="awl-aspect-preview-box" style="min-height: 100px; height: 100px; background: #f1f5f9;">
							<span class="dashicons dashicons-admin-generic awl-feature-icon"></span>
						</div>
						<div class="awl-aspect-info" style="text-align: center;">
							<h4><?php esc_html_e('Global Settings Dashboard', 'new-grid-gallery'); ?></h4>
							<p><?php esc_html_e('Configure lazy loading, shimmering skeleton screens, global custom CSS sandbox editing, and bulk import/export panel options globally.', 'new-grid-gallery'); ?></p>
						</div>
					</div>

					<!-- Video Embedding -->
					<div class="awl-grid-aspect-card">
						<div class="awl-aspect-preview-box" style="min-height: 100px; height: 100px; background: #f1f5f9;">
							<span class="dashicons dashicons-video-alt3 awl-feature-icon"></span>
						</div>
						<div class="awl-aspect-info" style="text-align: center;">
							<h4><?php esc_html_e('Inline Video Embedding', 'new-grid-gallery'); ?></h4>
							<p><?php esc_html_e('Embed YouTube, Vimeo, and local MP4 videos inside the preview panel with platform-branded hover play buttons.', 'new-grid-gallery'); ?></p>
						</div>
					</div>

					<!-- Device Columns -->
					<div class="awl-grid-aspect-card">
						<div class="awl-aspect-preview-box" style="min-height: 100px; height: 100px; background: #f1f5f9;">
							<span class="dashicons dashicons-welcome-widgets-menus awl-feature-icon"></span>
						</div>
						<div class="awl-aspect-info" style="text-align: center;">
							<h4><?php esc_html_e('Device Responsive Columns', 'new-grid-gallery'); ?></h4>
							<p><?php esc_html_e('Define separate grid column distributions for Desktop, Tablet, and Mobile viewports for perfect responsiveness.', 'new-grid-gallery'); ?></p>
						</div>
					</div>

					<!-- Custom CSS Sandbox -->
					<div class="awl-grid-aspect-card">
						<div class="awl-aspect-preview-box" style="min-height: 100px; height: 100px; background: #f1f5f9;">
							<span class="dashicons dashicons-editor-code awl-feature-icon"></span>
						</div>
						<div class="awl-aspect-info" style="text-align: center;">
							<h4><?php esc_html_e('Custom CSS Sandbox', 'new-grid-gallery'); ?></h4>
							<p><?php esc_html_e('Inject custom CSS codes directly in settings to overwrite layouts without losing edits on plugin updates.', 'new-grid-gallery'); ?></p>
						</div>
					</div>

					<!-- Shimmering Skeleton Loads -->
					<div class="awl-grid-aspect-card">
						<div class="awl-aspect-preview-box" style="min-height: 100px; height: 100px; background: #f1f5f9;">
							<span class="dashicons dashicons-update awl-feature-icon"></span>
						</div>
						<div class="awl-aspect-info" style="text-align: center;">
							<h4><?php esc_html_e('Skeleton Shimmer Loads', 'new-grid-gallery'); ?></h4>
							<p><?php esc_html_e('Display high-fidelity shimmering skeleton loader frames on thumbnail grid layout blocks during initialization.', 'new-grid-gallery'); ?></p>
						</div>
					</div>

					<!-- Load More Pagination -->
					<div class="awl-grid-aspect-card">
						<div class="awl-aspect-preview-box" style="min-height: 100px; height: 100px; background: #f1f5f9;">
							<span class="dashicons dashicons-arrow-down-alt2 awl-feature-icon"></span>
						</div>
						<div class="awl-aspect-info" style="text-align: center;">
							<h4><?php esc_html_e('Load More AJAX Pagination', 'new-grid-gallery'); ?></h4>
							<p><?php esc_html_e('Optimized for large galleries. Split image load lists into pages with a customizable, animated AJAX Load More button.', 'new-grid-gallery'); ?></p>
						</div>
					</div>

					<!-- JSON Import & Export -->
					<div class="awl-grid-aspect-card">
						<div class="awl-aspect-preview-box" style="min-height: 100px; height: 100px; background: #f1f5f9;">
							<span class="dashicons dashicons-migrate awl-feature-icon"></span>
						</div>
						<div class="awl-aspect-info" style="text-align: center;">
							<h4><?php esc_html_e('JSON Import & Export', 'new-grid-gallery'); ?></h4>
							<p><?php esc_html_e('Migrate layouts effortlessly. Export configurations as JSON files and import them to restore settings on any other site.', 'new-grid-gallery'); ?></p>
						</div>
					</div>

					<!-- Gallery Duplicator -->
					<div class="awl-grid-aspect-card">
						<div class="awl-aspect-preview-box" style="min-height: 100px; height: 100px; background: #f1f5f9;">
							<span class="dashicons dashicons-admin-page awl-feature-icon"></span>
						</div>
						<div class="awl-aspect-info" style="text-align: center;">
							<h4><?php esc_html_e('One-Click Gallery Duplicator', 'new-grid-gallery'); ?></h4>
							<p><?php esc_html_e('Instantly duplicate any gallery layout, configuration settings, and enqueued image lists from the dashboard.', 'new-grid-gallery'); ?></p>
						</div>
					</div>
				</div>
			</div>

			<!-- Free vs Pro Comparison Table -->
			<div class="awl-pro-comparison-section">
				<h3 class="awl-pro-grids-title"><?php esc_html_e('Free vs. Premium Comparison Table', 'new-grid-gallery'); ?></h3>
				<p class="awl-pro-grids-subtitle"><?php esc_html_e('Compare feature support between versions and see why thousands of users choose Grid Gallery Premium.', 'new-grid-gallery'); ?></p>
				
				<div class="awl-comparison-table-wrapper">
					<table class="awl-comparison-table">
						<thead>
							<tr>
								<th><?php esc_html_e('Feature', 'new-grid-gallery'); ?></th>
								<th class="free-col"><?php esc_html_e('Free Version', 'new-grid-gallery'); ?></th>
								<th class="pro-col"><?php esc_html_e('Premium Version', 'new-grid-gallery'); ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<span class="awl-feature-title"><?php esc_html_e('Responsive Layout Ratios', 'new-grid-gallery'); ?></span>
									<span class="awl-feature-desc"><?php esc_html_e('Choose different image crop aspect ratios.', 'new-grid-gallery'); ?></span>
								</td>
								<td class="free-col"><?php esc_html_e('2 Ratios (1:1, 4:3)', 'new-grid-gallery'); ?></td>
								<td class="pro-col">
									<?php esc_html_e('6 Ratios (1:1, 4:3, 16:9, 3:2, 2:3, 3:4)', 'new-grid-gallery'); ?>
									<br><span class="awl-badge-label"><?php esc_html_e('Ultimate Layouts', 'new-grid-gallery'); ?></span>
								</td>
							</tr>
							<tr>
								<td>
									<span class="awl-feature-title"><?php esc_html_e('Inline Video Integration', 'new-grid-gallery'); ?></span>
									<span class="awl-feature-desc"><?php esc_html_e('Embed YouTube, Vimeo, and Self-hosted MP4 videos.', 'new-grid-gallery'); ?></span>
								</td>
								<td class="free-col"><span class="dashicons dashicons-no-alt awl-icon-no"></span></td>
								<td class="pro-col">
									<span class="dashicons dashicons-yes awl-icon-yes"></span>
									<br><span class="awl-badge-label"><?php esc_html_e('With branded play badges', 'new-grid-gallery'); ?></span>
								</td>
							</tr>
							<tr>
								<td>
									<span class="awl-feature-title"><?php esc_html_e('Device Columns Customization', 'new-grid-gallery'); ?></span>
									<span class="awl-feature-desc"><?php esc_html_e('Configure columns separately for Desktop, Tablet, and Mobile.', 'new-grid-gallery'); ?></span>
								</td>
								<td class="free-col"><?php esc_html_e('Single column setting', 'new-grid-gallery'); ?></td>
								<td class="pro-col">
									<span class="dashicons dashicons-yes awl-icon-yes"></span>
									<br><span class="awl-badge-label"><?php esc_html_e('Perfect Responsive', 'new-grid-gallery'); ?></span>
								</td>
							</tr>
							<tr>
								<td>
									<span class="awl-feature-title"><?php esc_html_e('Detail Panel Layout Styles', 'new-grid-gallery'); ?></span>
									<span class="awl-feature-desc"><?php esc_html_e('Display expanded details as split screen panels or overlay modals.', 'new-grid-gallery'); ?></span>
								</td>
								<td class="free-col"><?php esc_html_e('Split Screen only', 'new-grid-gallery'); ?></td>
								<td class="pro-col"><?php esc_html_e('Split Screen & Overlay Styles', 'new-grid-gallery'); ?></td>
							</tr>
							<tr>
								<td>
									<span class="awl-feature-title"><?php esc_html_e('Load More', 'new-grid-gallery'); ?></span>
									<span class="awl-feature-desc"><?php esc_html_e('Enable pagination or Load More AJAX buttons for massive image grids.', 'new-grid-gallery'); ?></span>
								</td>
								<td class="free-col"><span class="dashicons dashicons-no-alt awl-icon-no"></span></td>
								<td class="pro-col"><span class="dashicons dashicons-yes awl-icon-yes"></span></td>
							</tr>
							<tr>
								<td>
									<span class="awl-feature-title"><?php esc_html_e('Hover Animation Effects', 'new-grid-gallery'); ?></span>
									<span class="awl-feature-desc"><?php esc_html_e('Visual CSS transition effects triggered on card hovers.', 'new-grid-gallery'); ?></span>
								</td>
								<td class="free-col"><?php esc_html_e('Basic 2D transitions', 'new-grid-gallery'); ?></td>
								<td class="pro-col"><?php esc_html_e('20+ Advanced 2D, shadow & glow effects', 'new-grid-gallery'); ?></td>
							</tr>
							<tr>
								<td>
									<span class="awl-feature-title"><?php esc_html_e('Frame & Borders Customizer', 'new-grid-gallery'); ?></span>
									<span class="awl-feature-desc"><?php esc_html_e('Customize padding, borders, colors, and corner radius on items.', 'new-grid-gallery'); ?></span>
								</td>
								<td class="free-col"><?php esc_html_e('Basic border/gap toggles', 'new-grid-gallery'); ?></td>
								<td class="pro-col">
									<?php esc_html_e('Custom padding sliders, border thickness, color picker, and Image Corner Radius', 'new-grid-gallery'); ?>
								</td>
							</tr>
							<tr>
								<td>
									<span class="awl-feature-title"><?php esc_html_e('Extended Typography Control', 'new-grid-gallery'); ?></span>
									<span class="awl-feature-desc"><?php esc_html_e('Edit title and description sizes/colors separately.', 'new-grid-gallery'); ?></span>
								</td>
								<td class="free-col"><?php esc_html_e('Title typography settings only', 'new-grid-gallery'); ?></td>
								<td class="pro-col"><?php esc_html_e('Complete Title & Description control', 'new-grid-gallery'); ?></td>
							</tr>
							<tr>
								<td>
									<span class="awl-feature-title"><?php esc_html_e('Glassmorphism & Style Control', 'new-grid-gallery'); ?></span>
									<span class="awl-feature-desc"><?php esc_html_e('Enable a frosted glass design on detail panels/overlays.', 'new-grid-gallery'); ?></span>
								</td>
								<td class="free-col"><span class="dashicons dashicons-no-alt awl-icon-no"></span></td>
								<td class="pro-col"><?php esc_html_e('Frosted Glassmorphism + Background Picker', 'new-grid-gallery'); ?></td>
							</tr>
							<tr>
								<td>
									<span class="awl-feature-title"><?php esc_html_e('One-Click Gallery Duplicator', 'new-grid-gallery'); ?></span>
									<span class="awl-feature-desc"><?php esc_html_e('Easily clone galleries without rebuilding them from scratch.', 'new-grid-gallery'); ?></span>
								</td>
								<td class="free-col"><span class="dashicons dashicons-no-alt awl-icon-no"></span></td>
								<td class="pro-col"><span class="dashicons dashicons-yes awl-icon-yes"></span></td>
							</tr>
							<tr>
								<td>
									<span class="awl-feature-title"><?php esc_html_e('Settings Import & Export', 'new-grid-gallery'); ?></span>
									<span class="awl-feature-desc"><?php esc_html_e('Export configurations as JSON to import on other sites.', 'new-grid-gallery'); ?></span>
								</td>
								<td class="free-col"><span class="dashicons dashicons-no-alt awl-icon-no"></span></td>
								<td class="pro-col"><span class="dashicons dashicons-yes awl-icon-yes"></span></td>
							</tr>
							<tr>
								<td>
									<span class="awl-feature-title"><?php esc_html_e('Custom CSS Sandbox', 'new-grid-gallery'); ?></span>
									<span class="awl-feature-desc"><?php esc_html_e('Inject custom styling rules safely to overwrite default gallery looks.', 'new-grid-gallery'); ?></span>
								</td>
								<td class="free-col"><span class="dashicons dashicons-no-alt awl-icon-no"></span></td>
								<td class="pro-col"><span class="dashicons dashicons-yes awl-icon-yes"></span></td>
							</tr>
							<tr>
								<td>
									<span class="awl-feature-title"><?php esc_html_e('Lightning Fast Performance', 'new-grid-gallery'); ?></span>
									<span class="awl-feature-desc"><?php esc_html_e('HTML layout is cached inside database transients to improve load times.', 'new-grid-gallery'); ?></span>
								</td>
								<td class="free-col"><span class="dashicons dashicons-no-alt awl-icon-no"></span></td>
								<td class="pro-col">
									<span class="dashicons dashicons-yes awl-icon-yes"></span>
									<br><span class="awl-badge-label"><?php esc_html_e('Transient Caching', 'new-grid-gallery'); ?></span>
								</td>
							</tr>
							<tr>
								<td>
									<span class="awl-feature-title"><?php esc_html_e('Global Settings Dashboard', 'new-grid-gallery'); ?></span>
									<span class="awl-feature-desc"><?php esc_html_e('Access global lazy loading, skeleton screen loader configurations, JSON import/export panel, and transient caching tools in one dashboard.', 'new-grid-gallery'); ?></span>
								</td>
								<td class="free-col"><span class="dashicons dashicons-no-alt awl-icon-no"></span></td>
								<td class="pro-col">
									<span class="dashicons dashicons-yes awl-icon-yes"></span>
									<br><span class="awl-badge-label"><?php esc_html_e('Global Admin', 'new-grid-gallery'); ?></span>
								</td>
							</tr>
							<tr>
								<td>
									<span class="awl-feature-title"><?php esc_html_e('Global Lazy Loading', 'new-grid-gallery'); ?></span>
									<span class="awl-feature-desc"><?php esc_html_e('Configure viewport-based image lazy loading globally for all galleries set to Inherit.', 'new-grid-gallery'); ?></span>
								</td>
								<td class="free-col"><span class="dashicons dashicons-no-alt awl-icon-no"></span></td>
								<td class="pro-col"><span class="dashicons dashicons-yes awl-icon-yes"></span></td>
							</tr>
							<tr>
								<td>
									<span class="awl-feature-title"><?php esc_html_e('Global Skeleton Loading', 'new-grid-gallery'); ?></span>
									<span class="awl-feature-desc"><?php esc_html_e('Configure shimmering card placeholders globally for all galleries set to Inherit.', 'new-grid-gallery'); ?></span>
								</td>
								<td class="free-col"><span class="dashicons dashicons-no-alt awl-icon-no"></span></td>
								<td class="pro-col"><span class="dashicons dashicons-yes awl-icon-yes"></span></td>
							</tr>
							<tr>
								<td>
									<span class="awl-feature-title"><?php esc_html_e('Global Pre-Loader Animations', 'new-grid-gallery'); ?></span>
									<span class="awl-feature-desc"><?php esc_html_e('Choose default spinner, pulse, or dots animations and select global color schemes.', 'new-grid-gallery'); ?></span>
								</td>
								<td class="free-col"><span class="dashicons dashicons-no-alt awl-icon-no"></span></td>
								<td class="pro-col"><span class="dashicons dashicons-yes awl-icon-yes"></span></td>
							</tr>
							<tr>
								<td>
									<span class="awl-feature-title"><?php esc_html_e('Priority Premium Support', 'new-grid-gallery'); ?></span>
									<span class="awl-feature-desc"><?php esc_html_e('Access direct customer service desk from development engineers.', 'new-grid-gallery'); ?></span>
								</td>
								<td class="free-col"><?php esc_html_e('Community Forum support only', 'new-grid-gallery'); ?></td>
								<td class="pro-col">
									<span class="dashicons dashicons-yes awl-icon-yes"></span>
									<br><span class="awl-badge-label"><?php esc_html_e('24/7 Support Desk', 'new-grid-gallery'); ?></span>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<!-- CTA Buttons Wrapper -->
			<div class="awl-pro-cta-wrap">
				<a href="https://awplife.com/wordpress-plugins/grid-gallery-wordpress-plugin/" target="_blank" class="awl-btn-pro-upgrade">
					<span class="dashicons dashicons-star-filled"></span>
					<?php esc_html_e('Upgrade to Grid Gallery Premium Now', 'new-grid-gallery'); ?>
				</a>
				<a href="https://awplife.com/demo/grid-gallery-premium/" target="_blank" class="awl-btn-pro-demo">
					<span class="dashicons dashicons-visibility"></span>
					<?php esc_html_e('Check Out the Live Premium Demo', 'new-grid-gallery'); ?>
				</a>
			</div>
		</div>
	</div>

</div> <!-- .awl-gg-tabs-content-wrapper -->
</div> <!-- .gg-settings-main-content -->
</div> <!-- .awl-gg-settings-wrapper -->

<?php 
	// syntax: wp_nonce_field( 'name_of_my_action', 'name_of_nonce_field' );
	wp_nonce_field( 'gg_save_settings', 'gg_save_nonce' );
?>
<!-- Return to Top -->
<a href="javascript:" id="return-to-top"><span class="dashicons dashicons-arrow-up-alt2"></span></a>
