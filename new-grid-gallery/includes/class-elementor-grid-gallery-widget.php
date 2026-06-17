<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Elementor_Grid_Gallery_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'ggp_grid_gallery';
	}

	public function get_title() {
		return esc_html__( 'Grid Gallery', 'new-grid-gallery' );
	}

	public function get_icon() {
		return 'eicon-grid';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Gallery Settings', 'new-grid-gallery' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		// Get all galleries
		$galleries_query = new \WP_Query( array(
			'post_type'      => 'grid_gallery',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
		) );

		$options = [ '' => esc_html__( 'Select a Gallery...', 'new-grid-gallery' ) ];
		if ( $galleries_query->have_posts() ) {
			while ( $galleries_query->have_posts() ) {
				$galleries_query->the_post();
				$options[ get_the_ID() ] = get_the_title();
			}
			wp_reset_postdata();
		}

		$this->add_control(
			'gallery_id',
			[
				'label' => esc_html__( 'Choose Grid Gallery', 'new-grid-gallery' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => $options,
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		if ( empty( $settings['gallery_id'] ) ) {
			echo '<p style="padding:20px; text-align:center; border:1px dashed #ccc;">' . esc_html__( 'No Grid Gallery selected.', 'new-grid-gallery' ) . '</p>';
			return;
		}
		echo do_shortcode( '[GGAL id=' . intval( $settings['gallery_id'] ) . ']' );
	}
}
