<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/*
@package New Grid Gallery
 * Plugin Name: New Grid Gallery
 * Plugin URI: https://awplife.com/
 * Description: Grid gallery plugin with preview for WordPress.
 * Version: 2.0.1
 * Author: A WP Life
 * Author URI: https://awplife.com/
 * Text Domain: new-grid-gallery
 * Domain Path: /languages
 * License: GPLv2 or later
 */

if ( ! class_exists( 'Awl_Grid_Gallery' ) ) {

	class Awl_Grid_Gallery {
		
		public function __construct() {
			$this->_constants();
			$this->_hooks();
		}	
		
		protected function _constants() {
			//Plugin Version
			define( 'GG_PLUGIN_VER', '2.0.1' );
			
			//Plugin Text Domain
			define("GGP_TXTDM","new-grid-gallery" );
 
			//Plugin Name
			define( 'GG_PLUGIN_NAME', 'New Grid Gallery' );

			//Plugin Slug
			define( 'GG_PLUGIN_SLUG', 'grid_gallery' );

			//Plugin Directory Path
			define( 'GG_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

			//Plugin Directory URL
			define( 'GG_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

			/**
			 * Create a key for the .htaccess secure download link.
			 * @uses    NONCE_KEY     Defined in the WP root config.php
			 */
			define( 'GG_SECURE_KEY', md5( NONCE_KEY ) );
			
		} // end of constructor function
		
		
		/**
		 * Setup the default filters and actions
		 */
		protected function _hooks() {
			
			//Load text domain
			add_action( 'plugins_loaded', array( $this, '_load_textdomain' ) );
			
			//add gallery menu item, change menu filter for multisite
			add_action( 'admin_menu', array( $this, '_Grid_Menu' ), 65 );
			
			//Create grid Gallery Custom Post
			add_action( 'init', array( $this, '_Grid_Gallery' ));
			
			//Add meta box to custom post
			add_action( 'add_meta_boxes', array( $this, '_admin_add_meta_box' ) );
			
			add_action('wp_ajax_grid_gallery_js', array( $this, '_ajax_grid_gallery'));
		
			add_action('save_post', array( $this, '_gg_save_settings'));

			add_action('wp_enqueue_scripts', array( $this, 'awplife_ggp_scripts'));
			
			// add ggp copy shortcode column - manage_{$post_type}_posts_columns
			add_filter( 'manage_grid_gallery_posts_columns', array( $this, 'set_ggp_shortcode_column_name') );
			
			// add ggp copy shortcode column data - manage_{$post_type}_posts_custom_column
			add_action( 'manage_grid_gallery_posts_custom_column' , array( $this, 'custom_ggp_shodrcode_data'), 10, 2 );
			
			// remove view action from ggp cpt
			add_filter( 'post_row_actions',  array( $this, 'ggp_remove_row_actions'), 10, 2 );
			
			//add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts_in_header') );

			add_action( 'admin_footer', array( $this, 'ggp_admin_footer_scripts' ) );

			// Register Gutenberg Block selector
			add_action( 'init', array( $this, 'ggp_register_gutenberg_block' ) );

			// Register Elementor Widget selector
			add_action( 'init', array( $this, 'ggp_elementor_init' ) );


			// Remove "View post" link from update messages
			add_filter( 'post_updated_messages', array( $this, 'ggp_updated_messages' ) );
			
		}// end of hook function

		
		// grid gallery copy shortcode column before date columns
		public function set_ggp_shortcode_column_name($defaults) {
			$new_column = array();
			unset($defaults['tags']);   // remove it from the columns list

			foreach($defaults as $key=>$value) {
				if($key=='date') {  // when we find the date column
				   $new_column['ggp_shortcode'] = __( 'Shortcode', 'new-grid-gallery' );  // put the tags column before it
				}    
				$new_column[$key] = $value;
			}
			return $new_column;  
		}
		
		// grid gallery copy shortcode column data
		public function custom_ggp_shodrcode_data( $column, $post_id ) {
			switch ( $column ) {
				case 'ggp_shortcode' :
					echo "<input type='text' class='button button-primary' id='ggp-shortcode-" . esc_attr( $post_id ) . "' value='[GGAL id=" . esc_attr( $post_id ) . "]' style='font-weight:bold; background-color:#32373C; color:#FFFFFF; text-align:center;' />";
					echo "<input type='button' class='button button-primary' onclick='return GGPCopyShortcode(" . esc_attr( $post_id ) . ");' readonly value='Copy' style='margin-left:4px;' />";
					echo "<span id='copy-msg-" . esc_attr( $post_id ) . "' class='button button-primary' style='display:none; background-color:#32CD32; color:#FFFFFF; margin-left:4px; border-radius: 4px;'>copied</span>";
				break;
			}
		}

		public function ggp_admin_footer_scripts() {
			$screen = get_current_screen();
			if ( isset( $screen->post_type ) && 'grid_gallery' === $screen->post_type ) {
				?>
				<script>
				function GGPCopyShortcode(post_id) {
					var copyText = document.getElementById('ggp-shortcode-' + post_id);
					if (copyText) {
						copyText.select();
						document.execCommand('copy');
						jQuery('#copy-msg-' + post_id).fadeIn('1000', 'linear');
						jQuery('#copy-msg-' + post_id).fadeOut(2500, 'swing');
					}
					return false;
				}
				</script>
				<?php
			}
		}
		
		// remove view action from fg cpt add new gallery page
		function ggp_remove_row_actions( $actions, $post ) {
			if ( 'grid_gallery' == $post->post_type ) {
				unset( $actions[ 'view' ] );
			}
			return $actions;
		}

		// Remove "View post" link from gallery update notices
		public function ggp_updated_messages( $messages ) {
			$messages['grid_gallery'] = array(
				0  => '',
				1  => __( 'Gallery updated.', 'new-grid-gallery' ),
				2  => __( 'Custom field updated.', 'new-grid-gallery' ),
				3  => __( 'Custom field deleted.', 'new-grid-gallery' ),
				4  => __( 'Gallery updated.', 'new-grid-gallery' ),
				5  => __( 'Gallery restored.', 'new-grid-gallery' ),
				6  => __( 'Gallery published.', 'new-grid-gallery' ),
				7  => __( 'Gallery saved.', 'new-grid-gallery' ),
				8  => __( 'Gallery submitted.', 'new-grid-gallery' ),
				9  => __( 'Gallery scheduled.', 'new-grid-gallery' ),
				10 => __( 'Gallery draft updated.', 'new-grid-gallery' ),
			);
			return $messages;
		}

		// frontend jquery support
		public function awplife_ggp_scripts() {
			wp_enqueue_script( 'jquery' );
		}
		
		public function _load_textdomain() {
			load_plugin_textdomain( 'new-grid-gallery', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}
		
		public function _Grid_Menu() {
			add_submenu_page( 'edit.php?post_type='.GG_PLUGIN_SLUG, __( 'Docs', 'new-grid-gallery' ), __( 'Docs', 'new-grid-gallery' ), 'administrator', 'sr-doc-page', array( $this, '_gg_doc_page') );
			add_submenu_page( 'edit.php?post_type='.GG_PLUGIN_SLUG, __( 'Our Plugins', 'new-grid-gallery' ), __( 'Our Plugins', 'new-grid-gallery' ), 'administrator', 'gg-our-plugins', array( $this, '_gg_our_plugins_page') );
			add_submenu_page( 'edit.php?post_type='.GG_PLUGIN_SLUG, __( 'Our Themes', 'new-grid-gallery' ), __( 'Our Themes', 'new-grid-gallery' ), 'administrator', 'gg-our-themes', array( $this, '_gg_our_themes_page') );
		}
		
		/**
		 * Grid Gallery Custom Post
		 * Create gallery post type in admin dashboard.
		*/
		public function _Grid_Gallery() {
			$labels = array(
				'name'                => _x( 'Grid Gallery', 'new-grid-gallery' ),
				'singular_name'       => _x( 'Grid Gallery', 'new-grid-gallery' ),
				'menu_name'           => __( 'Grid Gallery', 'new-grid-gallery' ),
				'name_admin_bar'      => __( 'Grid Gallery', 'new-grid-gallery' ),
				'parent_item_colon'   => __( 'Parent Item:', 'new-grid-gallery' ),
				'all_items'           => __( 'All Grid Gallery', 'new-grid-gallery' ),
				'add_new_item'        => __( 'Add Grid Gallery', 'new-grid-gallery' ),
				'add_new'             => __( 'Add Grid Gallery', 'new-grid-gallery' ),
				'new_item'            => __( 'Grid Gallery', 'new-grid-gallery' ),
				'edit_item'           => __( 'Edit Grid Gallery', 'new-grid-gallery' ),
				'update_item'         => __( 'Update Grid Gallery', 'new-grid-gallery' ),
				'search_items'        => __( 'Search Grid Gallery', 'new-grid-gallery' ),
				'not_found'           => __( 'Grid Gallery Not found', 'new-grid-gallery' ),
				'not_found_in_trash'  => __( 'Grid Gallery Not found in Trash', 'new-grid-gallery' ),
			);
			$args = array(
				'label'               => __( 'Grid Gallery', 'new-grid-gallery' ),
				'description'         => __( 'Custom Post Type For Grid Gallery', 'new-grid-gallery' ),
				'labels'              => $labels,
				'supports'            => array( 'title'),
				'taxonomies'          => array(),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 65,
				'menu_icon'           => 'dashicons-grid-view',
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => true,
				'can_export'          => true,
				'has_archive'         => true,		
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'page',
			);
			register_post_type( 'grid_gallery', $args );
			
		} // end of post type function
		
		/**
		 * Adds Meta Boxes
		*/
		public function _admin_add_meta_box() {
			// Syntax: add_meta_box( $id, $title, $callback, $screen, $context, $priority, $callback_args );
			add_meta_box( 'gg_shortcode_box', __('Copy Grid Gallery Shortcode', 'new-grid-gallery'), array( $this, '_gg_shortcode_left_metabox'), 'grid_gallery', 'side', 'high' );
			add_meta_box( 'gg_upload_box', __('Add Image', 'new-grid-gallery'), array( $this, 'gg_upload_multiple_images'), 'grid_gallery', 'normal', 'high' );
		}

		// grid gallery copy shortcode meta box under publish button
		public function _gg_shortcode_left_metabox($post)
		{ ?>
			<p class="input-text-wrap" style="position: relative; display: inline-block; width: 100%; margin: 0;">
				<input type="text" name="GGCopyShortcode" id="GGCopyShortcode"
					value="[GGAL id=<?php echo esc_attr($post->ID); ?>]" readonly
					style="height: 60px; text-align: center; width:100%; font-size: 16px; border: 2px dashed #4f46e5; border-radius: 8px; background: #f8fafc; color: #4f46e5; padding: 0 55px 0 15px; box-sizing: border-box; font-family: monospace;">
				<span class="ggm-copy dashicons dashicons-clipboard" data-target="#GGCopyShortcode" title="<?php esc_attr_e('Copy Shortcode', 'new-grid-gallery'); ?>" style="position: absolute; right: 15px; top: 18px; cursor: pointer; font-size: 20px; width: 20px; height: 20px;"></span>
			</p>
			
			<p id="ggm-copy-code" style="margin-top: 5px; color: #10b981; font-weight: 500; font-size: 13px; text-align: center; display: none;">
				<span class="dashicons dashicons-yes-alt" style="font-size: 18px; margin-top: -2px;"></span> <?php esc_html_e('Shortcode copied!', 'new-grid-gallery'); ?>
			</p>
			
			<p style="margin-top: 10px; font-size: 12px; color: #64748b; line-height: 1.4;">
				<?php esc_html_e('Copy & Embed shortcode into any Page/Post/Text Widget to display gallery.', 'new-grid-gallery'); ?>
			</p>
		<?php
		}
		
		public function gg_upload_multiple_images($post) { 
			wp_enqueue_script('media-upload');
			wp_enqueue_script('awl-gg-uploader.js', GG_PLUGIN_URL . 'assets/js/awl-gg-uploader.js', array('jquery'));
			wp_enqueue_style('ig-google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap', array(), null);
			wp_enqueue_style('awl-gg-admin-style-css', GG_PLUGIN_URL . 'assets/css/gg-admin-style.css', array('dashicons'), GG_PLUGIN_VER);
			wp_enqueue_style('gg-upgrade-pro-style', GG_PLUGIN_URL . 'assets/css/upgrade-pro-style.css', array(), GG_PLUGIN_VER);
			wp_enqueue_media();
			
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'awl-gg-color-picker-js', plugins_url('assets/js/gg-color-picker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
			wp_enqueue_script( 'awl-gg-admin-settings-js', GG_PLUGIN_URL . 'assets/js/gg-admin-settings.js', array( 'jquery', 'wp-color-picker' ), GG_PLUGIN_VER, true );
		
			?>
			<div class="awl-gg-settings-wrapper">
				<!-- Settings Page Loader -->
				<div class="gg-settings-loader">
					<div class="gg-settings-loader-spinner"></div>
				</div>

				<div class="gg-settings-main-content" style="display: none;">
					<!-- Navigation Tabs -->
				<div class="awl-gg-tabs-nav">
					<a href="#" class="nav-item active" data-target="tab-add-images">
						<span class="dashicons dashicons-format-image"></span> <?php esc_html_e('Add Images', 'new-grid-gallery'); ?>
					</a>
					<a href="#" class="nav-item" data-target="tab-layout-style">
						<span class="dashicons dashicons-layout"></span> <?php esc_html_e('Layout & Style', 'new-grid-gallery'); ?>
					</a>
					<a href="#" class="nav-item" data-target="tab-typography-nav">
						<span class="dashicons dashicons-editor-quote"></span> <?php esc_html_e('Typography & Navigation', 'new-grid-gallery'); ?>
					</a>
					<a href="#" class="nav-item" data-target="tab-upgrade-pro" style="color: #ffad00; font-weight: 600;">
						<span class="dashicons dashicons-star-filled" style="color: #ffad00; margin-right: 4px;"></span> <?php esc_html_e('Upgrade to Pro', 'new-grid-gallery'); ?>
					</a>
				</div>

				<!-- Content Area -->
				<div class="awl-gg-tabs-content-wrapper">
					
					<!-- Tab 1: Add Images -->
					<div class="awl-gg-tab-content active" id="tab-add-images">
						<div class="file-upload">
							<div class="image-upload-wrap">
								<input class="add-new-slider file-upload-input" id="add-new-slider" name="add-new-slider" value="Upload Image" />
								<div class="drag-text">
									<span class="dashicons dashicons-cloud-upload" style="font-size: 40px; width: 40px; height: 40px; color: var(--gg-primary); margin-bottom: 15px; display: block; margin-left: auto; margin-right: auto;"></span>
									<h3><?php esc_html_e('ADD IMAGES', 'new-grid-gallery'); ?></h3>
									<?php wp_nonce_field('ggp_add_images', 'ggp_add_images_nonce'); ?>
								</div>
							</div>
						</div>
						
						<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
							<div class="gg-button-group">
								<button type="button" class="gg-btn gg-btn-secondary" onclick="return SortSlides('ASC');">
									<span class="dashicons dashicons-sort"></span> <?php esc_html_e('Ascending', 'new-grid-gallery'); ?>
								</button>
								<button type="button" class="gg-btn gg-btn-secondary" onclick="return SortSlides('DESC');">
									<span class="dashicons dashicons-sort"></span> <?php esc_html_e('Descending', 'new-grid-gallery'); ?>
								</button>
							</div>
							<button type="button" id="remove-all-slides" class="gg-btn gg-btn-danger">
								<span class="dashicons dashicons-trash"></span> <?php esc_html_e('Delete All Images', 'new-grid-gallery'); ?>
							</button>
						</div>

						<ul id="remove-slides" class="sbox ggp-listitems">
							<?php
							$post_id = esc_attr($post->ID);
							$gg_settings = get_post_meta( $post->ID, 'awl_gg_settings_' . $post->ID, true );
							if(isset($gg_settings['slide-ids'])) {
								$count = 0;
								foreach($gg_settings['slide-ids'] as $id) {
									$thumbnail = wp_get_attachment_image_src($id, 'medium', true);
									$attachment = get_post( $id );
									$image_link = isset($gg_settings['slide-link'][$count]) ? $gg_settings['slide-link'][$count] : "";
									
									$thumbnail_url = $thumbnail[0];
									?>
									<li class="gg-image-slide" id="<?php echo esc_attr($id); ?>" data-position="<?php echo esc_attr($id); ?>">
										<div class="gg-image-preview">
											<div class="gg-image-controls">
												<div class="gg-move-handle" title="<?php esc_attr_e('Drag to reorder', 'new-grid-gallery'); ?>"><span class="dashicons dashicons-move"></span></div>
												<a class="pw-trash-icon remove-slide" name="remove-slide" href="#" id="remove-slide" title="<?php esc_attr_e('Delete image', 'new-grid-gallery'); ?>"><span class="dashicons dashicons-trash"></span></a>
											</div>
											<img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_html(get_the_title($id)); ?>" data-original-src="<?php echo esc_url($thumbnail[0]); ?>">
										</div>
										<div class="gg-image-info">
											<input type="hidden" name="slide-ids[]" value="<?php echo esc_attr($id); ?>" />
											<input type="hidden" name="slide-link-type[]" value="image" />
											
											<input type="text" name="slide-title[]" placeholder="Image Title" value="<?php echo esc_html(get_the_title($id)); ?>">
											
											<input type="text" name="slide-link[]" placeholder="Link URL" class="slide-link-input" value="<?php echo esc_url($image_link); ?>">
										</div>
									</li>
									<?php $count++; 
								}
							}
							?>
						</ul>
					</div>
			<?php
			
			require_once( GG_PLUGIN_DIR . 'admin/grid-gallery-settings.php' );
		
		} // end of upload multiple image
	
		public function _gg_ajax_callback_function($id) {
			//thumb, thumbnail, medium, large, post-thumbnail
			$thumbnail = wp_get_attachment_image_src($id, 'medium', true);
			$attachment = get_post( $id ); // $id = attachment id
			?>
			<li class="gg-image-slide" id="<?php echo esc_attr($id); ?>" data-position="<?php echo esc_attr($id); ?>">
				<div class="gg-image-preview">
					<div class="gg-image-controls">
						<div class="gg-move-handle" title="<?php esc_attr_e('Drag to reorder', 'new-grid-gallery'); ?>"><span class="dashicons dashicons-move"></span></div>
						<a class="pw-trash-icon remove-slide" name="remove-slide" href="#" id="remove-slide" title="<?php esc_attr_e('Delete image', 'new-grid-gallery'); ?>"><span class="dashicons dashicons-trash"></span></a>
					</div>
					<img src="<?php echo esc_url($thumbnail[0]); ?>" alt="<?php echo esc_attr( get_the_title($id) ); ?>" data-original-src="<?php echo esc_url($thumbnail[0]); ?>">
				</div>
				<div class="gg-image-info">
					<input type="hidden" name="slide-ids[]" value="<?php echo esc_attr($id); ?>" />
					<input type="hidden" name="slide-link-type[]" value="image" />
					
					<input type="text" name="slide-title[]" placeholder="Image Title" value="<?php echo esc_attr( get_the_title($id) ); ?>">
					
					<input type="text" name="slide-link[]" placeholder="Link URL" class="slide-link-input">
				</div>
			</li>
			<?php
		}
		
		public function _ajax_grid_gallery() {
			if (current_user_can('manage_options')) {
				if (isset($_POST['ggp_add_images_nonce']) && wp_verify_nonce($_POST['ggp_add_images_nonce'], 'ggp_add_images')) {
					$slide_id = isset($_POST['slideId']) ? intval($_POST['slideId']) : 0;
					$this->_gg_ajax_callback_function($slide_id);
				} else {
					print 'Sorry, your nonce did not verify.';
				}
			}
			wp_die();
		}
		
		public function _gg_save_settings($post_id) {
			if ( get_post_type($post_id) !== 'grid_gallery' ) {
				return;
			}
			if (current_user_can('manage_options')) {
				if(isset($_POST['gg_save_nonce'])) {
					if ( isset( $_POST['gg_save_nonce'] ) && wp_verify_nonce( $_POST['gg_save_nonce'], 'gg_save_settings' ) ) {
						
						$gal_thumb_size         			= sanitize_text_field( $_POST['gal_thumb_size'] );
						$col_large_desktops					= sanitize_text_field( $_POST['col_large_desktops'] );

						$grid_ratio							= isset( $_POST['grid_ratio'] ) ? sanitize_text_field( $_POST['grid_ratio'] ) : '4_3';

						$thumbnail_order 					= sanitize_text_field( $_POST['thumbnail_order'] );
						$easing_effect						= isset( $_POST['easing_effect'] ) ? sanitize_text_field( $_POST['easing_effect'] ) : 'easeInSine';

						$title_size  						= sanitize_text_field( $_POST['title_size'] );

						$images_link						= sanitize_text_field( $_POST['images_link'] );
						$url_target							= sanitize_text_field( $_POST['url_target'] );
						$animation_speed        			= isset( $_POST['animation_speed'] ) ? sanitize_text_field( $_POST['animation_speed'] ) : '400';

						$image_hover_effect_four 			= sanitize_text_field( $_POST['image_hover_effect_four'] );
						$scroll_loading          			= sanitize_text_field( $_POST['scroll_loading'] );
						$nbp_setting2            			= sanitize_text_field( $_POST['nbp_setting2'] );
						$thumb_title             			= sanitize_text_field( $_POST['thumb_title'] );
						$title_setting           			= sanitize_text_field( $_POST['title_setting'] );
						$title_color            			= sanitize_text_field( $_POST['title_color'] );
						$thumbnail_border        			= sanitize_text_field( $_POST['thumbnail_border'] );
						$no_spacing             			= sanitize_text_field( $_POST['no_spacing'] );
						$thumb_title_display     			= isset($_POST['thumb_title_display']) ? sanitize_text_field( $_POST['thumb_title_display'] ) : 'hover';
						$preview_show_exif					= isset( $_POST['preview_show_exif'] ) ? sanitize_text_field( $_POST['preview_show_exif'] ) : 'no';
						$link_text							= isset( $_POST['link_text'] ) ? sanitize_text_field( $_POST['link_text'] ) : 'Read More';
						$gallery_loader						= isset( $_POST['gallery_loader'] ) ? sanitize_text_field( $_POST['gallery_loader'] ) : 'spinner';
						$gallery_loader_color				= isset( $_POST['gallery_loader_color'] ) ? sanitize_text_field( $_POST['gallery_loader_color'] ) : '#4f46e5';

						$i = 0;
						$image_ids = array();
						$image_titles = array();
						$image_link = array();
						$image_link_type = array();
						$image_ids_val           = isset( $_POST['slide-ids'] ) ? (array) $_POST['slide-ids'] : array();
						$image_ids_val           = array_map( 'sanitize_text_field', $image_ids_val );
						
						foreach ( $image_ids_val as $image_id ) {
							$image_ids[]        	= sanitize_text_field( $_POST['slide-ids'][ $i ] );
							$image_titles[]      	= sanitize_text_field( $_POST['slide-title'][ $i ] );
							$image_link[] 			= sanitize_text_field($_POST['slide-link'][$i]);
							$image_link_type[]      = isset($_POST['slide-link-type'][$i]) ? sanitize_text_field($_POST['slide-link-type'][$i]) : 'image';
							
							$single_image_update = array(
								'ID'         		=> $image_id,
								'post_title' 		=> $image_titles[ $i ],
							);
							wp_update_post( $single_image_update );
							$i++;
						}
						
						$gg_settings = array(
						'slide-ids'              		=> $image_ids,
						'slide-title'            		=> $image_titles,
						'slide-link'             		=> $image_link,
						'slide-link-type'        		=> $image_link_type,
						'col_large_desktops'			=> $col_large_desktops,

						'grid_ratio'					=> $grid_ratio,

						'thumb_title_display'			=> $thumb_title_display,
						'thumbnail_order' 				=> $thumbnail_order,
						'easing_effect'					=> $easing_effect,

						'title_size'  					=> $title_size,

						'images_link'					 => $images_link,
						'url_target'					 => $url_target,
						'gal_thumb_size'          		 => $gal_thumb_size,
						'animation_speed'         		 => $animation_speed,

						'image_hover_effect_four' 		 => $image_hover_effect_four,
						'scroll_loading'          		 => $scroll_loading,
						'nbp_setting2'            		 => $nbp_setting2,
						'thumb_title'             		 => $thumb_title,
						'title_setting'          		 => $title_setting,
						'title_color'            		 => $title_color,
						'thumbnail_border'       		 => $thumbnail_border,
						'no_spacing'             		 => $no_spacing,
						'preview_show_exif'              => $preview_show_exif,
						'link_text'                      => $link_text,
						'gallery_loader'                 => $gallery_loader,
						'gallery_loader_color'           => $gallery_loader_color,
						);
						$awl_grid_gallery_shortcode_setting = "awl_gg_settings_".$post_id;
						update_post_meta($post_id, $awl_grid_gallery_shortcode_setting, $gg_settings);

						// Invalidate cache by incrementing the cache version meta
						$cache_version = get_post_meta($post_id, '_gg_cache_version', true);
						$new_version = $cache_version ? intval($cache_version) + 1 : 1;
						update_post_meta($post_id, '_gg_cache_version', $new_version);
					}	
				}
			}
		}// end save setting
		

		/**
		 * Grid Gallery Docs Page
		 * Create doc page to help user to setup plugin
		 */
		public function _gg_doc_page() {
			require_once( GG_PLUGIN_DIR . 'admin/docs.php' );
		}

		/**
		 * Grid Gallery Our Plugins Page
		 */
		public function _gg_our_plugins_page() {
			wp_enqueue_style( 'gg-our-plugins-style', GG_PLUGIN_URL . 'assets/css/our-plugins-style.css', array(), GG_PLUGIN_VER );
			require_once( GG_PLUGIN_DIR . 'admin/our-plugins.php' );
		}

		/**
		 * Grid Gallery Our Themes Page
		 */
		public function _gg_our_themes_page() {
			wp_enqueue_style( 'gg-our-plugins-style', GG_PLUGIN_URL . 'assets/css/our-plugins-style.css', array(), GG_PLUGIN_VER );
			require_once( GG_PLUGIN_DIR . 'admin/our-themes.php' );
		}

		/**
		 * Register Gutenberg block for Grid Gallery Selection
		 */
		public function ggp_register_gutenberg_block() {
			if ( ! function_exists( 'register_block_type' ) ) {
				return;
			}

			wp_register_script(
				'ggp-gutenberg-block-js',
				GG_PLUGIN_URL . 'assets/js/gg-gutenberg-block.js',
				array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-server-side-render', 'jquery' ),
				GG_PLUGIN_VER
			);

			$galleries_query = new WP_Query( array(
				'post_type'      => 'grid_gallery',
				'posts_per_page' => -1,
				'post_status'    => 'publish',
			) );

			$galleries = array();
			if ( $galleries_query->have_posts() ) {
				while ( $galleries_query->have_posts() ) {
					$galleries_query->the_post();
					$galleries[] = array(
						'id'    => get_the_ID(),
						'title' => get_the_title(),
					);
				}
				wp_reset_postdata();
			}

			wp_localize_script( 'ggp-gutenberg-block-js', 'ggGutenbergGalleries', $galleries );

			register_block_type( 'new-grid-gallery/gallery-select', array(
				'editor_script'   => 'ggp-gutenberg-block-js',
				'render_callback' => array( $this, 'ggp_render_gutenberg_block' ),
				'attributes'      => array(
					'galleryId' => array(
						'type'    => 'string',
						'default' => '',
					),
				),
			) );
		}

		/**
		 * Render Gutenberg block
		 */
		public function ggp_render_gutenberg_block( $attributes ) {
			if ( empty( $attributes['galleryId'] ) ) {
				return '<p style="padding:20px; text-align:center; border:1px dashed #ccc;">' . esc_html__( 'No Grid Gallery selected.', 'new-grid-gallery' ) . '</p>';
			}
			return do_shortcode( '[GGAL id=' . intval( $attributes['galleryId'] ) . ']' );
		}

		/**
		 * Register Elementor Widget Integration
		 */
		public function ggp_elementor_init() {
			if ( ! did_action( 'elementor/loaded' ) ) {
				return;
			}
			add_action( 'elementor/widgets/register', array( $this, 'ggp_register_elementor_widget' ) );
		}

		public function ggp_register_elementor_widget( $widgets_manager ) {
			require_once( GG_PLUGIN_DIR . 'includes/class-elementor-grid-gallery-widget.php' );
			$widgets_manager->register( new \Elementor_Grid_Gallery_Widget() );
		}




	
	} // end of class
	
	// register sf scripts
		function awplife_ggp_register_scripts(){
			// css & JS
			wp_enqueue_script('jquery');
			wp_enqueue_script('jquery-effects-core');
			wp_enqueue_script('awl-gridder-js', plugin_dir_url( __FILE__ ) . 'assets/js/jquery.gridder.min.js', array('jquery', 'jquery-effects-core'), GG_PLUGIN_VER, true);
			wp_enqueue_style( 'gg-gridder-css', plugin_dir_url(__FILE__). 'assets/css/jquery.gridder.min.css', array(), GG_PLUGIN_VER); 
			wp_enqueue_style( 'gg-frontend-css', plugin_dir_url(__FILE__). 'assets/css/grid-gallery-frontend.css', array(), GG_PLUGIN_VER); 
			// css & JS
			
		}	
		add_action( 'wp_enqueue_scripts', 'awplife_ggp_register_scripts' );

	/**
	 * Instantiates the Class
	 */
	$gg_gallery_object = new Awl_Grid_Gallery();
		require_once( GG_PLUGIN_DIR . 'includes/grid-gallery-shortcode.php' );
} // end of class exists
?>