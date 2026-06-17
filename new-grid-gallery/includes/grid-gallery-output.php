<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Grid Gallery Output
 */
$all_grid_images = array(  'p' => $grid_gallery_id, 'post_type' => 'grid_gallery', 'orderby' => 'ASC');
$loop = new WP_Query( $all_grid_images );
while ( $loop->have_posts() ) : $loop->the_post();


		$post_id = esc_attr(get_the_ID());
		$gg_settings = get_post_meta( $post_id, 'awl_gg_settings_' . $post_id, true );
		$original_slide_ids = isset($gg_settings['slide-ids']) ? $gg_settings['slide-ids'] : array();
		if ( isset( $_POST['gg_ordered_ids'] ) && ! empty( $_POST['gg_ordered_ids'] ) ) {
			$gg_settings['slide-ids'] = array_map( 'intval', explode( ',', $_POST['gg_ordered_ids'] ) );
		}
		$gg_redirect_icon_inline = '<svg class="gg-redirect-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle; margin-left: 6px;"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>';
		
		$gg_total_images = count($gg_settings['slide-ids']);
		// start the image gallery contents

	?>
	<div class="gg-gallery-outer-wrap preview-<?php echo esc_attr($preview_layout_mode); ?>" id="gg_gallery_wrap_<?php echo esc_attr($grid_gallery_id); ?>">
		<?php
		if ( ! isset( $gallery_loader ) ) {
			$gallery_loader = isset($gg_settings['gallery_loader']) ? $gg_settings['gallery_loader'] : "spinner";
		}
		if ( $gallery_loader !== 'none' ) : ?>
		<div class="gg-gallery-loader" id="gg_loader_<?php echo esc_attr($grid_gallery_id); ?>" aria-label="<?php esc_attr_e('Loading gallery...', 'new-grid-gallery'); ?>">
			<?php if ( $gallery_loader === 'pulse' ) : ?>
				<div class="gg-loader-pulse-icon"></div>
			<?php elseif ( $gallery_loader === 'dots' ) : ?>
				<div class="gg-loader-dots-icon">
					<span></span>
					<span></span>
					<span></span>
				</div>
			<?php else : ?>
				<div class="gg-loader-spinner-icon"></div>
			<?php endif; ?>
		</div>
		<?php endif; ?>
		<ul class="gridder gg-<?php echo esc_attr($grid_gallery_id); ?>">
			<?php
			if(isset($gg_settings['slide-ids']) && count($gg_settings['slide-ids']) > 0) {
				$count = 0;
				if ( ! isset( $_POST['gg_ordered_ids'] ) ) {
					if($thumbnail_order == "DESC") {
						$gg_settings['slide-ids'] = array_reverse($gg_settings['slide-ids']);
					}
					if($thumbnail_order == "RANDOM") {
						shuffle($gg_settings['slide-ids']);
					}
				}
				
				foreach($gg_settings['slide-ids'] as $attachment_id) {
					
					$thumb = wp_get_attachment_image_src($attachment_id, 'thumb', true);
					$thumbnail = wp_get_attachment_image_src($attachment_id, 'thumbnail', true);
					$medium = wp_get_attachment_image_src($attachment_id, 'medium', true);
					$large = wp_get_attachment_image_src($attachment_id, 'large', true);
					$full = wp_get_attachment_image_src($attachment_id, 'full', true);
					$postthumbnail = wp_get_attachment_image_src($attachment_id, 'post-thumbnail', true);
					$attachment_details = get_post( $attachment_id );
					$href = get_permalink( $attachment_details->ID );
					$src = $attachment_details->guid;
					$title = $attachment_details->post_title;
					$description = $attachment_details->post_content;
					$original_index = array_search($attachment_id, $original_slide_ids);
					if ($original_index !== false && !empty($gg_settings['slide-link'][$original_index])) {
							$image_link_url = $gg_settings['slide-link'][$original_index];
						} else {
							$image_link_url = "";
						}	
					//set thumbnail size
					if($gal_thumb_size == "thumbnail") { $thumbnail_url = $thumbnail[0]; }
					if($gal_thumb_size == "medium") { $thumbnail_url = $medium[0]; }
					if($gal_thumb_size == "large") { $thumbnail_url = $large[0]; }
					if($gal_thumb_size == "full") { $thumbnail_url = $full[0]; }
?><li data-griddercontent="#gridder-content-<?php echo esc_attr($grid_gallery_id); ?>-<?php echo esc_attr($count); ?>" class="gridder-list gg-gridder-list-<?php echo esc_attr($grid_gallery_id); ?> <?php echo esc_attr($thumb_bor." ".$image_hover_effect); ?>" >
<div style="background-image: url('<?php echo esc_url($thumbnail_url); ?>')" class="image">
	<div class="overlay">
		<?php if($thumb_title == "show") { ?>
		<p class="title"><?php echo esc_html($title); ?></p>
		<?php } ?>
	</div>
</div>
</li><?php
					$count++;
				}// end of attachment foreach
			} else {
				esc_html_e('Sorry! No grid gallery found ', 'new-grid-gallery');
				echo ":[GGAL id=" . esc_attr( $post_id ) . "]";
			} // end of if esle of slides avaialble check into slider
			?>
		</ul>
		
			<?php
			if(isset($gg_settings['slide-ids']) && count($gg_settings['slide-ids']) > 0) {
				$count = 0;
				
				foreach($gg_settings['slide-ids'] as $attachment_id) {					
					$thumb = wp_get_attachment_image_src($attachment_id, 'thumb', true);
					$thumbnail = wp_get_attachment_image_src($attachment_id, 'thumbnail', true);
					$medium = wp_get_attachment_image_src($attachment_id, 'medium', true);
					$large = wp_get_attachment_image_src($attachment_id, 'large', true);
					$full = wp_get_attachment_image_src($attachment_id, 'full', true);
					$postthumbnail = wp_get_attachment_image_src($attachment_id, 'post-thumbnail', true);
					$attachment_details = get_post( $attachment_id );
					$href = get_permalink( $attachment_details->ID );
					$src = $attachment_details->guid;
					$title = $attachment_details->post_title;
					$description = $attachment_details->post_content;
					$image_alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true);
					$original_index = array_search($attachment_id, $original_slide_ids);
					if ($original_index !== false && !empty($gg_settings['slide-link'][$original_index])) {
							$image_link_url = $gg_settings['slide-link'][$original_index];
						} else {
							$image_link_url = "";
						}			
					?>
						<div class="gridder-content" id="gridder-content-<?php echo esc_attr($grid_gallery_id); ?>-<?php echo esc_attr($count); ?>">
							<div class="gg-preview-image-wrapper">
								<img src="<?php echo esc_url($full[0]); ?>" alt="<?php echo esc_html($image_alt); ?>" class="imgbor-<?php echo esc_attr($grid_gallery_id); ?>">
								<div class="description gg-description-<?php echo esc_attr($grid_gallery_id); ?>">
									<?php if($title_setting == "show") { ?>
									<p class="gg-title gg-title-<?php echo esc_attr($grid_gallery_id); ?>"><?php echo esc_html($title); ?></p>
									<?php } ?>

									<?php
									if (isset($preview_show_exif) && $preview_show_exif === 'yes' && !empty($attachment_id)) {
										$exif_meta = wp_get_attachment_metadata($attachment_id);
										if (isset($exif_meta['image_meta'])) {
											$emeta = $exif_meta['image_meta'];
											$e_camera = !empty($emeta['camera']) ? $emeta['camera'] : '';
											$e_lens = !empty($emeta['lens']) ? $emeta['lens'] : '';
											$e_aperture = !empty($emeta['aperture']) ? 'f/' . $emeta['aperture'] : '';
											$e_shutter = !empty($emeta['shutter_speed']) ? $emeta['shutter_speed'] . 's' : '';
											$e_iso = !empty($emeta['iso']) ? 'ISO ' . $emeta['iso'] : '';
											$e_focal = !empty($emeta['focal_length']) ? $emeta['focal_length'] . 'mm' : '';
											
											if ($e_camera || $e_lens || $e_aperture || $e_shutter || $e_iso || $e_focal) {
												?>
												<div class="gg-exif-metadata">
													<?php if ($e_camera) { ?>
														<span class="gg-exif-item gg-exif-camera" title="<?php esc_attr_e('Camera Model', 'new-grid-gallery'); ?>">
															<span class="dashicons dashicons-camera"></span> <?php echo esc_html($e_camera); ?>
														</span>
													<?php } ?>
													<?php if ($e_lens) { ?>
														<span class="gg-exif-item gg-exif-lens" title="<?php esc_attr_e('Lens', 'new-grid-gallery'); ?>">
															<span class="dashicons dashicons-admin-customizer"></span> <?php echo esc_html($e_lens); ?>
														</span>
													<?php } ?>
													<div class="gg-exif-specs">
														<?php if ($e_aperture) { ?>
															<span class="gg-exif-spec" title="<?php esc_attr_e('Aperture', 'new-grid-gallery'); ?>"><?php echo esc_html($e_aperture); ?></span>
														<?php } ?>
														<?php if ($e_shutter) { ?>
															<span class="gg-exif-spec" title="<?php esc_attr_e('Shutter Speed', 'new-grid-gallery'); ?>"><?php echo esc_html($e_shutter); ?></span>
														<?php } ?>
														<?php if ($e_iso) { ?>
															<span class="gg-exif-spec" title="<?php esc_attr_e('ISO Speed', 'new-grid-gallery'); ?>"><?php echo esc_html($e_iso); ?></span>
														<?php } ?>
														<?php if ($e_focal) { ?>
															<span class="gg-exif-spec" title="<?php esc_attr_e('Focal Length', 'new-grid-gallery'); ?>"><?php echo esc_html($e_focal); ?></span>
														<?php } ?>
													</div>
												</div>
												<?php
											}
										}
									}
									?>
									<?php if($images_link == "text" && $image_link_url != "") { ?>
									<p><a class="gg-read-more-link link gg-link gg-link-<?php echo esc_attr($grid_gallery_id); ?>" href="<?php echo esc_url($image_link_url); ?>" target="<?php echo esc_attr($url_target); ?>"><?php echo esc_html($link_text); ?>
									<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									echo $gg_redirect_icon_inline; ?></a></p>
									<?php } ?>
								</div>
							</div>
						</div>
						<?php
					$count++;
				}// end of attachment foreach
			} else {
				esc_html_e('Sorry! No image gallery found ', 'new-grid-gallery');
				echo ": [GGAL id=" . esc_attr( $post_id ) . "]";
			} // end of if esle of slides avaialble check into slider
			?>
	</div>
<?php
endwhile;
wp_reset_query();
?>