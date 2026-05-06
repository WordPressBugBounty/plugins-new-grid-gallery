<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<style>
	.gg-docs-container {
		max-width: 1150px;
		margin: 30px auto;
		font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
		padding: 0 20px;
	}
	.gg-docs-header {
		background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
		color: #ffffff;
		padding: 45px;
		border-radius: 16px;
		margin-bottom: 35px;
		box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.1);
		position: relative;
		overflow: hidden;
	}
	.gg-docs-header::before {
		content: '';
		position: absolute;
		top: -50%;
		right: -30%;
		width: 80%;
		height: 200%;
		background: radial-gradient(circle, rgba(59,130,246,0.15) 0%, rgba(255,255,255,0) 70%);
		pointer-events: none;
	}
	.gg-docs-header h1 {
		color: #ffffff;
		font-size: 36px;
		font-weight: 800;
		margin: 0 0 12px 0;
		letter-spacing: -0.5px;
	}
	.gg-docs-header p {
		font-size: 18px;
		color: #94a3b8;
		margin: 0;
		line-height: 1.5;
	}
	.gg-section-title {
		font-size: 24px;
		font-weight: 800;
		color: #0f172a;
		margin-top: 40px;
		margin-bottom: 20px;
		padding-bottom: 10px;
		border-bottom: 2px solid #e2e8f0;
	}
	.gg-docs-grid {
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
		gap: 25px;
		margin-bottom: 35px;
	}
	.gg-docs-card {
		background: #ffffff;
		border: 1px solid #e2e8f0;
		border-radius: 16px;
		padding: 30px;
		box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03);
		transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
	}
	.gg-docs-card:hover {
		transform: translateY(-4px);
		box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
		border-color: #cbd5e1;
	}
	.gg-docs-card h3 {
		font-size: 20px;
		font-weight: 700;
		color: #0f172a;
		margin-top: 0;
		margin-bottom: 18px;
		display: flex;
		align-items: center;
		gap: 12px;
	}
	.gg-docs-card h3 span {
		background: #3b82f6;
		color: #ffffff;
		width: 32px;
		height: 32px;
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 14px;
		font-weight: 700;
		box-shadow: 0 2px 4px rgba(59,130,246,0.3);
	}
	.gg-docs-card p {
		color: #475569;
		line-height: 1.6;
		font-size: 14.5px;
		margin-bottom: 0;
	}
	.gg-docs-card pre {
		background: #f8fafc;
		color: #0f172a;
		padding: 12px 16px;
		border-radius: 8px;
		font-size: 13.5px;
		overflow-x: auto;
		border: 1px solid #e2e8f0;
		margin-top: 15px;
		font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
		font-weight: 600;
	}
	
	/* Detailed Tutorial Settings Styles */
	.gg-tutorial-list {
		display: flex;
		flex-direction: column;
		gap: 20px;
		margin-bottom: 45px;
	}
	.gg-tutorial-item {
		background: #ffffff;
		border: 1px solid #e2e8f0;
		border-radius: 12px;
		padding: 25px 30px;
		display: flex;
		gap: 25px;
		box-shadow: 0 2px 4px rgba(0,0,0,0.02);
		transition: border-color 0.2s ease, box-shadow 0.2s ease;
	}
	.gg-tutorial-item:hover {
		border-color: #3b82f6;
		box-shadow: 0 4px 12px rgba(59,130,246,0.05);
	}
	.gg-tutorial-badge {
		background: #eff6ff;
		color: #1d4ed8;
		font-weight: 700;
		font-size: 13px;
		padding: 8px 16px;
		border-radius: 8px;
		align-self: flex-start;
		min-width: 140px;
		text-align: center;
		text-transform: uppercase;
		letter-spacing: 0.5px;
		border: 1px solid #bfdbfe;
	}
	.gg-tutorial-content {
		flex: 1;
	}
	.gg-tutorial-content h4 {
		font-size: 18px;
		font-weight: 700;
		color: #0f172a;
		margin-top: 0;
		margin-bottom: 8px;
	}
	.gg-tutorial-content p {
		font-size: 14.5px;
		color: #475569;
		line-height: 1.6;
		margin: 0 0 10px 0;
	}
	.gg-tutorial-options {
		font-size: 13.5px;
		color: #64748b;
		background: #f8fafc;
		padding: 8px 15px;
		border-radius: 6px;
		display: inline-block;
		border: 1px solid #f1f5f9;
	}
	.gg-tutorial-options strong {
		color: #334155;
	}

	.gg-docs-promo {
		background: #ffffff;
		border: 1px solid #e2e8f0;
		border-radius: 16px;
		padding: 45px;
		text-align: center;
		box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
		position: relative;
		overflow: hidden;
	}
	.gg-docs-promo h2 {
		font-size: 26px;
		font-weight: 800;
		color: #0f172a;
		margin-top: 0;
		margin-bottom: 15px;
	}
	.gg-docs-promo p {
		color: #475569;
		max-width: 650px;
		margin: 0 auto 30px auto;
		line-height: 1.6;
		font-size: 15px;
	}
	.gg-docs-buttons {
		display: flex;
		justify-content: center;
		gap: 15px;
		flex-wrap: wrap;
	}
	.gg-btn {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		padding: 14px 28px;
		border-radius: 30px;
		font-weight: 700;
		text-decoration: none;
		transition: all 0.2s ease;
		font-size: 14.5px;
		box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
	}
	.gg-btn-primary {
		background: #2563eb;
		color: #ffffff !important;
	}
	.gg-btn-primary:hover {
		background: #1d4ed8;
		transform: translateY(-2px);
		box-shadow: 0 10px 15px -3px rgba(37,99,235,0.3);
	}
	.gg-btn-secondary {
		background: #f8fafc;
		color: #1e293b !important;
		border: 1px solid #e2e8f0;
	}
	.gg-btn-secondary:hover {
		background: #f1f5f9;
		transform: translateY(-2px);
		box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);
	}
</style>

<div class="gg-docs-container">
	<div class="gg-docs-header">
		<h1><?php esc_html_e( 'Grid Gallery Documentation', 'new-grid-gallery' ); ?></h1>
		<p><?php esc_html_e( 'Follow these simple steps to easily create and publish stunning grid galleries on your WordPress site.', 'new-grid-gallery' ); ?></p>
	</div>

	<div class="gg-section-title"><?php esc_html_e( 'Quick Start Guide', 'new-grid-gallery' ); ?></div>
	<div class="gg-docs-grid">
		<div class="gg-docs-card">
			<h3><span>1</span><?php esc_html_e( 'Install & Activate', 'new-grid-gallery' ); ?></h3>
			<p><?php esc_html_e( 'Simply upload the plugin zip file through your WordPress admin dashboard, click Install, and activate the plugin.', 'new-grid-gallery' ); ?></p>
		</div>

		<div class="gg-docs-card">
			<h3><span>2</span><?php esc_html_e( 'Create a Gallery', 'new-grid-gallery' ); ?></h3>
			<p><?php esc_html_e( 'Navigate to the "New Grid Gallery" menu and click "Add Grid Gallery". Use the upload buttons to add your images, customize your settings (Hover effects, animations, column counts), and click "Publish" to save.', 'new-grid-gallery' ); ?></p>
		</div>

		<div class="gg-docs-card">
			<h3><span>3</span><?php esc_html_e( 'Display on Your Site', 'new-grid-gallery' ); ?></h3>
			<p><?php esc_html_e( 'Once saved, copy the shortcode provided at the top of the settings page and paste it into any WordPress Post, Page, or Widget.', 'new-grid-gallery' ); ?></p>
			<pre><?php esc_html_e( '[GGAL id=X]', 'new-grid-gallery' ); ?></pre>
		</div>
	</div>

	<div class="gg-section-title"><?php esc_html_e( 'Detailed Settings Tutorial', 'new-grid-gallery' ); ?></div>
	<div class="gg-tutorial-list">
		<div class="gg-tutorial-item">
			<div class="gg-tutorial-badge"><?php esc_html_e( 'Thumbnails', 'new-grid-gallery' ); ?></div>
			<div class="gg-tutorial-content">
				<h4><?php esc_html_e( 'Gallery Thumbnail Size', 'new-grid-gallery' ); ?></h4>
				<p><?php esc_html_e( 'Controls the resolution of the images displayed inside the grid. Choosing a smaller resolution helps optimize loading speeds, while larger resolutions offer crystal clear previews.', 'new-grid-gallery' ); ?></p>
				<div class="gg-tutorial-options"><strong><?php esc_html_e( 'Options:', 'new-grid-gallery' ); ?></strong> Thumbnail (150x150), Medium (300x300), Large (1024x1024), Full Size</div>
			</div>
		</div>

		<div class="gg-tutorial-item">
			<div class="gg-tutorial-badge"><?php esc_html_e( 'Layout', 'new-grid-gallery' ); ?></div>
			<div class="gg-tutorial-content">
				<h4><?php esc_html_e( 'Columns In Grid Gallery', 'new-grid-gallery' ); ?></h4>
				<p><?php esc_html_e( 'Defines how many columns of images will be shown on large desktop views. The grid automatically adjusts to smaller screens (mobile, tablets) to remain fully responsive.', 'new-grid-gallery' ); ?></p>
				<div class="gg-tutorial-options"><strong><?php esc_html_e( 'Options:', 'new-grid-gallery' ); ?></strong> 1 Column, 2 Columns, 3 Columns, 4 Columns, 5 Columns, 6 Columns</div>
			</div>
		</div>

		<div class="gg-tutorial-item">
			<div class="gg-tutorial-badge"><?php esc_html_e( 'Animations', 'new-grid-gallery' ); ?></div>
			<div class="gg-tutorial-content">
				<h4><?php esc_html_e( 'Animation Speed', 'new-grid-gallery' ); ?></h4>
				<p><?php esc_html_e( 'Uses a smooth slider to control the duration of the entry and hover animations in milliseconds. A lower value makes animations snappy, while higher values create elegant slow-motion sweeps.', 'new-grid-gallery' ); ?></p>
				<div class="gg-tutorial-options"><strong><?php esc_html_e( 'Range:', 'new-grid-gallery' ); ?></strong> 100ms - 2000ms</div>
			</div>
		</div>

		<div class="gg-tutorial-item">
			<div class="gg-tutorial-badge"><?php esc_html_e( 'Hover Effects', 'new-grid-gallery' ); ?></div>
			<div class="gg-tutorial-content">
				<h4><?php esc_html_e( 'Image Hover Effects', 'new-grid-gallery' ); ?></h4>
				<p><?php esc_html_e( 'Choose from multiple modern micro-interactions that trigger when a user hovers their mouse over any image in your grid.', 'new-grid-gallery' ); ?></p>
				<div class="gg-tutorial-options"><strong><?php esc_html_e( 'Options:', 'new-grid-gallery' ); ?></strong> Float Shadow, Shadow Radial, Box Shadow Outset, or No Hover</div>
			</div>
		</div>

		<div class="gg-tutorial-item">
			<div class="gg-tutorial-badge"><?php esc_html_e( 'Auto Scroll', 'new-grid-gallery' ); ?></div>
			<div class="gg-tutorial-content">
				<h4><?php esc_html_e( 'Image Preview Auto Scroll', 'new-grid-gallery' ); ?></h4>
				<p><?php esc_html_e( 'When activated, the page smoothly auto-scrolls down to focus directly on the large preview slider whenever a user clicks on any gallery thumbnail.', 'new-grid-gallery' ); ?></p>
				<div class="gg-tutorial-options"><strong><?php esc_html_e( 'Options:', 'new-grid-gallery' ); ?></strong> True (Enabled), False (Disabled)</div>
			</div>
		</div>

		<div class="gg-tutorial-item">
			<div class="gg-tutorial-badge"><?php esc_html_e( 'Navigation', 'new-grid-gallery' ); ?></div>
			<div class="gg-tutorial-content">
				<h4><?php esc_html_e( 'Button Position & Alignment', 'new-grid-gallery' ); ?></h4>
				<p><?php esc_html_e( 'Controls the structural alignment of the navigation controls (Next/Previous arrows) on the overlay slides.', 'new-grid-gallery' ); ?></p>
				<div class="gg-tutorial-options"><strong><?php esc_html_e( 'Options:', 'new-grid-gallery' ); ?></strong> Left Alignment, Right Alignment</div>
			</div>
		</div>

		<div class="gg-tutorial-item">
			<div class="gg-tutorial-badge"><?php esc_html_e( 'Typography', 'new-grid-gallery' ); ?></div>
			<div class="gg-tutorial-content">
				<h4><?php esc_html_e( 'Thumbnail Title & Preview overlay', 'new-grid-gallery' ); ?></h4>
				<p><?php esc_html_e( 'Control whether image titles appear directly under the thumbnails, inside the preview overlay, or both.', 'new-grid-gallery' ); ?></p>
				<div class="gg-tutorial-options"><strong><?php esc_html_e( 'Options:', 'new-grid-gallery' ); ?></strong> Hide, Show</div>
			</div>
		</div>

		<div class="gg-tutorial-item">
			<div class="gg-tutorial-badge"><?php esc_html_e( 'Styling', 'new-grid-gallery' ); ?></div>
			<div class="gg-tutorial-content">
				<h4><?php esc_html_e( 'Title Font Color', 'new-grid-gallery' ); ?></h4>
				<p><?php esc_html_e( 'Quickly select the aesthetic text color for the image titles inside the grid overlay preview to ensure proper readability and contrast.', 'new-grid-gallery' ); ?></p>
				<div class="gg-tutorial-options"><strong><?php esc_html_e( 'Options:', 'new-grid-gallery' ); ?></strong> White, Black, Red, Blue</div>
			</div>
		</div>

		<div class="gg-tutorial-item">
			<div class="gg-tutorial-badge"><?php esc_html_e( 'Design', 'new-grid-gallery' ); ?></div>
			<div class="gg-tutorial-content">
				<h4><?php esc_html_e( 'Thumbnail Borders & Spacing', 'new-grid-gallery' ); ?></h4>
				<p><?php esc_html_e( 'Toggle borders around image thumbnails and decide whether to add spacing gaps between the gallery images or make them align seamlessly edge-to-edge.', 'new-grid-gallery' ); ?></p>
				<div class="gg-tutorial-options"><strong><?php esc_html_e( 'Options:', 'new-grid-gallery' ); ?></strong> Borders: Hide/Show | Spacing: Yes (Include gaps) / No (Seamless)</div>
			</div>
		</div>

		<div class="gg-tutorial-item">
			<div class="gg-tutorial-badge"><?php esc_html_e( 'Advanced', 'new-grid-gallery' ); ?></div>
			<div class="gg-tutorial-content">
				<h4><?php esc_html_e( 'Custom CSS', 'new-grid-gallery' ); ?></h4>
				<p><?php esc_html_e( 'An advanced input field to write your own custom styles or override plugin default styles. Completely secured and safely parsed.', 'new-grid-gallery' ); ?></p>
				<div class="gg-tutorial-options"><strong><?php esc_html_e( 'Input:', 'new-grid-gallery' ); ?></strong> Safely parsed raw Custom CSS</div>
			</div>
		</div>
	</div>

	<div class="gg-docs-promo">
		<h2><?php esc_html_e( 'Unlock the Full Power of Grid Gallery', 'new-grid-gallery' ); ?></h2>
		<p><?php esc_html_e( 'Upgrade to the Premium Version to access stunning hover effects, 6 column layouts, custom animation transitions, linkable images, infinite scroll, priority developer support, and much more.', 'new-grid-gallery' ); ?></p>
		<div class="gg-docs-buttons">
			<a href="https://awplife.com/wodpress-plugins/grid-gallery-premium/" target="_blank" class="gg-btn gg-btn-primary"><?php esc_html_e( 'Premium Version Details', 'new-grid-gallery' ); ?></a>
			<a href="https://awplife.com/demo/grid-gallery-premium/" target="_blank" class="gg-btn gg-btn-secondary"><?php esc_html_e( 'Check Live Demo', 'new-grid-gallery' ); ?></a>
			<a href="https://awplife.com/demo/grid-gallery-premium-admin-demo/" target="_blank" class="gg-btn gg-btn-secondary"><?php esc_html_e( 'Try Admin Demo', 'new-grid-gallery' ); ?></a>
		</div>
	</div>
</div>
