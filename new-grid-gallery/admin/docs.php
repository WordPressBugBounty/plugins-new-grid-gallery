<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
/* Modern premium styling for docs page */
.awl-docs-container {
    background: #0f172a; /* Sleek dark theme */
    color: #e2e8f0;
    font-family: 'Outfit', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    padding: 50px 40px;
    border-radius: 16px;
    margin: 20px 20px 20px 0;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
    position: relative;
    overflow: hidden;
}

/* Glassmorphic background blur effects */
.awl-docs-container::before {
    content: '';
    position: absolute;
    top: -10%;
    left: -10%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(139, 92, 246, 0.15) 0%, transparent 70%);
    z-index: 0;
    pointer-events: none;
}
.awl-docs-container::after {
    content: '';
    position: absolute;
    bottom: -10%;
    right: -10%;
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(59, 130, 246, 0.15) 0%, transparent 70%);
    z-index: 0;
    pointer-events: none;
}

.awl-docs-header {
    text-align: center;
    margin-bottom: 50px;
    position: relative;
    z-index: 1;
}

.awl-docs-header h1 {
    font-size: 42px;
    font-weight: 800;
    background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 50%, #f472b6 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 12px;
    letter-spacing: -1px;
}

.awl-docs-header .about-description {
    font-size: 17px;
    color: #94a3b8;
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.5;
}

.awl-video-section {
    max-width: 800px;
    margin: 0 auto 60px auto;
    text-align: center;
    position: relative;
    z-index: 1;
}

.awl-video-section h3 {
    font-size: 22px;
    font-weight: 700;
    color: #f8fafc;
    margin-bottom: 25px;
    letter-spacing: -0.5px;
}

.awl-iframe-wrapper {
    position: relative;
    padding-bottom: 56.25%; /* 16:9 ratio */
    height: 0;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(139, 92, 246, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.08);
    transition: transform 0.4s ease, box-shadow 0.4s ease, border-color 0.4s ease;
}

.awl-iframe-wrapper:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 50px rgba(139, 92, 246, 0.4);
    border-color: rgba(255, 255, 255, 0.15);
}

.awl-iframe-wrapper iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: 0;
}

.awl-section-title {
    font-size: 28px;
    font-weight: 800;
    color: #f8fafc;
    margin: 60px 0 35px 0;
    text-align: center;
    position: relative;
    z-index: 1;
    letter-spacing: -0.5px;
}

.awl-section-title span {
    background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Tutorial Stepper styling */
.awl-tutorial-steps {
    max-width: 900px;
    margin: 0 auto 50px auto;
    position: relative;
    z-index: 1;
}

.awl-tutorial-item {
    background: rgba(30, 41, 59, 0.4);
    border: 1px solid rgba(255, 255, 255, 0.06);
    border-radius: 14px;
    padding: 30px;
    margin-bottom: 25px;
    display: flex;
    gap: 20px;
    transition: all 0.3s ease;
}

.awl-tutorial-item:hover {
    background: rgba(30, 41, 59, 0.6);
    border-color: rgba(139, 92, 246, 0.2);
    transform: translateX(4px);
}

.awl-tutorial-badge {
    background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
    color: #fff;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 18px;
    flex-shrink: 0;
}

.awl-tutorial-content {
    flex-grow: 1;
}

.awl-tutorial-content h3 {
    font-size: 20px;
    font-weight: 700;
    color: #f8fafc;
    margin: 0 0 10px 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.awl-tutorial-content p {
    font-size: 15px;
    line-height: 1.6;
    color: #cbd5e1;
    margin: 0 0 15px 0;
}

.awl-tutorial-content p strong {
    color: #f8fafc;
}

/* Builder tabs inside step 3 */
.awl-builder-tabs {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 15px;
    margin-top: 15px;
}

.awl-builder-box {
    background: rgba(15, 23, 42, 0.6);
    border: 1px solid rgba(255, 255, 255, 0.04);
    border-radius: 10px;
    padding: 20px;
    transition: all 0.3s ease;
}

.awl-builder-box:hover {
    border-color: rgba(96, 165, 250, 0.3);
    background: rgba(15, 23, 42, 0.9);
}

.awl-builder-box h4 {
    margin: 0 0 8px 0;
    font-size: 16px;
    font-weight: 700;
    color: #f8fafc;
    display: flex;
    align-items: center;
    gap: 8px;
}

.awl-builder-box h4 i.fa-gutenberg {
    color: #007cba;
}
.awl-builder-box h4 i.fa-elementor {
    color: #92003B;
}
.awl-builder-box h4 i.fa-code {
    color: #10b981;
}

.awl-builder-box p {
    font-size: 13.5px;
    color: #94a3b8;
    margin: 0 0 10px 0;
    line-height: 1.5;
}

.awl-code-block {
    background: #090d16;
    border: 1px solid rgba(139, 92, 246, 0.2);
    border-radius: 6px;
    padding: 8px 12px;
    font-family: 'Courier New', Courier, monospace;
    font-size: 14px;
    color: #34d399;
    text-shadow: 0 0 10px rgba(52, 211, 153, 0.2);
    font-weight: bold;
    display: inline-block;
}

/* Settings Tutorial Grid */
.awl-settings-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
    gap: 30px;
    position: relative;
    z-index: 1;
    margin-bottom: 60px;
}

.awl-setting-card {
    background: rgba(30, 41, 59, 0.35);
    border: 1px solid rgba(255, 255, 255, 0.04);
    border-radius: 16px;
    padding: 30px;
    transition: all 0.4s ease;
}

.awl-setting-card:hover {
    background: rgba(30, 41, 59, 0.6);
    border-color: rgba(96, 165, 250, 0.25);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
    transform: translateY(-4px);
}

.awl-setting-card-header {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    padding-bottom: 15px;
}

.awl-setting-icon {
    font-size: 24px;
    color: #38bdf8;
    background: rgba(56, 189, 248, 0.1);
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.awl-setting-card-header h4 {
    font-size: 19px;
    font-weight: 700;
    color: #f8fafc;
    margin: 0;
}

.awl-setting-card-body p {
    font-size: 14px;
    line-height: 1.6;
    color: #94a3b8;
    margin: 0 0 20px 0;
}

.awl-setting-sub-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.awl-setting-sub-item {
    display: flex;
    gap: 12px;
    margin-bottom: 15px;
    align-items: flex-start;
}

.awl-setting-sub-item i {
    font-size: 14px;
    color: #a78bfa;
    margin-top: 3px;
}

.awl-sub-detail h5 {
    font-size: 14.5px;
    font-weight: 600;
    color: #cbd5e1;
    margin: 0 0 4px 0;
}

.awl-sub-detail p {
    font-size: 13px;
    color: #94a3b8;
    margin: 0;
    line-height: 1.5;
}

.awl-cta-section {
    text-align: center;
    margin-top: 50px;
    position: relative;
    z-index: 1;
}

.awl-btn-premium {
    background: linear-gradient(135deg, #8b5cf6 0%, #3b82f6 100%);
    color: #ffffff !important;
    font-size: 16px;
    font-weight: 700;
    padding: 16px 40px;
    border-radius: 50px;
    text-decoration: none !important;
    display: inline-block;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    box-shadow: 0 10px 25px rgba(139, 92, 246, 0.4);
}

.awl-btn-premium:hover {
    transform: translateY(-3px) scale(1.03);
    box-shadow: 0 15px 35px rgba(139, 92, 246, 0.6);
}

.awl-btn-premium:active {
    transform: translateY(-1px);
}
</style>

<div class="wrap">
    <div class="awl-docs-container">
        
        <!-- Header -->
        <div class="awl-docs-header">
            <h1>Welcome to New Grid Gallery Tutorial</h1>
            <p class="about-description">Master layout grids, loading spinner styles, page-builder options, and styling settings to deliver gorgeous galleries on your website.</p>
        </div>

        <!-- Video Showcase Section -->
        <div class="awl-video-section">
            <h3>Watch the video tutorial to master New Grid Gallery</h3>
            <div class="awl-iframe-wrapper">
                <iframe src="https://www.youtube.com/embed/KMfMPYI9Aig" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>

        <!-- Step Title -->
        <div class="awl-section-title">
            <span>Tutorial: Create & Embed a Gallery</span>
        </div>

        <!-- Tutorial Steps Section -->
        <div class="awl-tutorial-steps">
            
            <!-- Step 1 -->
            <div class="awl-tutorial-item">
                <div class="awl-tutorial-badge">1</div>
                <div class="awl-tutorial-content">
                    <h3>Create & Upload Images</h3>
                    <p>Go to <strong>Grid Gallery</strong> -> <strong>Add Grid Gallery</strong>. Enter a title for your gallery and click the <strong>Add Image</strong> button to open the WordPress media library. Choose your pictures, select titles, and optionally add redirection link URLs for each individual thumbnail.</p>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="awl-tutorial-item">
                <div class="awl-tutorial-badge">2</div>
                <div class="awl-tutorial-content">
                    <h3>Configure Settings</h3>
                    <p>Scroll down to the settings panel. Here you can configure the number of grid columns, choose crop shapes (aspect ratio), select hover animation styles, set the sort order, choose custom easing curves, change title font size/color, and enable camera EXIF technical metadata. Click <strong>Publish</strong> to save your gallery.</p>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="awl-tutorial-item">
                <div class="awl-tutorial-badge">3</div>
                <div class="awl-tutorial-content">
                    <h3>Embed on Your Page</h3>
                    <p>New Grid Gallery provides three seamless ways to display your galleries based on your favorite page builder:</p>
                    
                    <div class="awl-builder-tabs">
                        <!-- Gutenberg block -->
                        <div class="awl-builder-box">
                            <h4><i class="fa-solid fa-cube" style="color: #007cba;"></i> Gutenberg Block</h4>
                            <p>Open the Block Editor. Search for the <strong>New Grid Gallery</strong> block, insert it, and select your gallery from the side setting panel. Fully compatible with FSE/Block themes (like Twenty Twenty-Five).</p>
                        </div>
                        
                        <!-- Elementor widget -->
                        <div class="awl-builder-box">
                            <h4><i class="fa-brands fa-elementor" style="color: #92003b;"></i> Elementor Widget</h4>
                            <p>Open Elementor editor. Search for the **New Grid Gallery** widget in the elements panel, drag it into your page structure, and pick your gallery from the dropdown settings.</p>
                        </div>

                        <!-- Shortcode option -->
                        <div class="awl-builder-box">
                            <h4><i class="fa-solid fa-code" style="color: #10b981;"></i> Shortcode Option</h4>
                            <p>Copy the generated shortcode from the top header or the gallery listing page, then paste it inside any shortcode block, classic page editor, or sidebar widget.</p>
                            <div class="awl-code-block">[GGAL id=XXX]</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Settings Tutorial Title -->
        <div class="awl-section-title">
            <span>Core Settings Tutorial</span>
        </div>

        <!-- Settings Tutorial Grid -->
        <div class="awl-settings-grid">

            <!-- Card 1: Grid & Layout -->
            <div class="awl-setting-card">
                <div class="awl-setting-card-header">
                    <div class="awl-setting-icon"><i class="fa-solid fa-table-cells"></i></div>
                    <h4>1. Grid & Layout Settings</h4>
                </div>
                <div class="awl-setting-card-body">
                    <p>Manage grid columns, aspect ratio crop shapes, and spacing borders.</p>
                    <ul class="awl-setting-sub-list">
                        <li class="awl-setting-sub-item">
                            <i class="fa-solid fa-circle-dot"></i>
                            <div class="awl-sub-detail">
                                <h5>Grid Column Distributions</h5>
                                <p>Set up to 6 columns for desktop monitors. Responsiveness is built-in: layouts automatically adjust to tablets and mobile sizes.</p>
                            </div>
                        </li>
                        <li class="awl-setting-sub-item">
                            <i class="fa-solid fa-circle-dot"></i>
                            <div class="awl-sub-detail">
                                <h5>Grid Crop Shape (Aspect Ratio)</h5>
                                <p>Choose the geometric shape/ratio for the grid thumbnails (e.g. Original (Auto), 1:1 Square, 4:3 Classic) to align all thumbnail items.</p>
                            </div>
                        </li>
                        <li class="awl-setting-sub-item">
                            <i class="fa-solid fa-circle-dot"></i>
                            <div class="awl-sub-detail">
                                <h5>Show Spacing (Gaps)</h5>
                                <p>Toggle grid spacing to enable or disable margins and padding between thumbnails, creating either bordered grids or gapless mosaics.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Card 2: Interactive Effects -->
            <div class="awl-setting-card">
                <div class="awl-setting-card-header">
                    <div class="awl-setting-icon"><i class="fa-solid fa-wand-magic-sparkles"></i></div>
                    <h4>2. Animation & Hovers</h4>
                </div>
                <div class="awl-setting-card-body">
                    <p>Fine-tune CSS3-accelerated thumbnail hovers and expanded detail panels.</p>
                    <ul class="awl-setting-sub-list">
                        <li class="awl-setting-sub-item">
                            <i class="fa-solid fa-circle-dot"></i>
                            <div class="awl-sub-detail">
                                <h5>Hover Animation Style</h5>
                                <p>Choose clean hover transition animations (Grow, Shrink, Float Shadow, Shadow Radial, Box Shadow Outset, or None) that trigger on thumbnails.</p>
                            </div>
                        </li>
                        <li class="awl-setting-sub-item">
                            <i class="fa-solid fa-circle-dot"></i>
                            <div class="awl-sub-detail">
                                <h5>Expander Easing Curves</h5>
                                <p>Over 20+ advanced easing curves (Sine, Quad, Cubic, Elastic, Back) for opening the expansion detail panel.</p>
                            </div>
                        </li>
                        <li class="awl-setting-sub-item">
                            <i class="fa-solid fa-circle-dot"></i>
                            <div class="awl-sub-detail">
                                <h5>Detail Panel Speeds</h5>
                                <p>Customize the expansion speed from 0ms to 1000ms using the speed settings slider.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Card 3: Gallery Loader Settings -->
            <div class="awl-setting-card">
                <div class="awl-setting-card-header">
                    <div class="awl-setting-icon"><i class="fa-solid fa-bolt"></i></div>
                    <h4>3. Gallery Loader Settings</h4>
                </div>
                <div class="awl-setting-card-body">
                    <p>Manage loading animation styles and custom loader color accents.</p>
                    <ul class="awl-setting-sub-list">
                        <li class="awl-setting-sub-item">
                            <i class="fa-solid fa-circle-dot"></i>
                            <div class="awl-sub-detail">
                                <h5>Gallery Loading Icon Style</h5>
                                <p>Select a modern loading pre-loader (Spinner, Pulse, Dots, or Disabled) to display while the gallery initializes.</p>
                            </div>
                        </li>
                        <li class="awl-setting-sub-item">
                            <i class="fa-solid fa-circle-dot"></i>
                            <div class="awl-sub-detail">
                                <h5>Loading Icon Color</h5>
                                <p>Select custom hexadecimal color schemes to match the pre-loader animation to your website's branding template.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Card 4: Texts, Fonts & Metadata -->
            <div class="awl-setting-card">
                <div class="awl-setting-card-header">
                    <div class="awl-setting-icon"><i class="fa-solid fa-font"></i></div>
                    <h4>4. Fonts & EXIF Meta</h4>
                </div>
                <div class="awl-setting-card-body">
                    <p>Customize typography layers and display camera technical metadata.</p>
                    <ul class="awl-setting-sub-list">
                        <li class="awl-setting-sub-item">
                            <i class="fa-solid fa-circle-dot"></i>
                            <div class="awl-sub-detail">
                                <h5>Custom Typography</h5>
                                <p>Control font sizes (18px to 50px) and pick hexadecimal colors for titles inside the detail panel.</p>
                            </div>
                        </li>
                        <li class="awl-setting-sub-item">
                            <i class="fa-solid fa-circle-dot"></i>
                            <div class="awl-sub-detail">
                                <h5>Navigation Buttons Position</h5>
                                <p>Position the detail panel close and next/previous arrows horizontally (Left or Right) within the preview drawer layout.</p>
                            </div>
                        </li>
                        <li class="awl-setting-sub-item">
                            <i class="fa-solid fa-circle-dot"></i>
                            <div class="awl-sub-detail">
                                <h5>EXIF Technical Metadata</h5>
                                <p>Display advanced photographic values (Aperture, ISO, Camera, Lens, Focal Length) inside the detailed preview panel.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Card 5: Redirection & Link Settings -->
            <div class="awl-setting-card">
                <div class="awl-setting-card-header">
                    <div class="awl-setting-icon"><i class="fa-solid fa-link"></i></div>
                    <h4>5. Redirection & Link Settings</h4>
                </div>
                <div class="awl-setting-card-body">
                    <p>Configure thumbnail redirection link behaviors and targets.</p>
                    <ul class="awl-setting-sub-list">
                        <li class="awl-setting-sub-item">
                            <i class="fa-solid fa-circle-dot"></i>
                            <div class="awl-sub-detail">
                                <h5>Clickable Link Trigger Area</h5>
                                <p>Configure which trigger actions launch redirection links (None or a dedicated Read More link overlay).</p>
                            </div>
                        </li>
                        <li class="awl-setting-sub-item">
                            <i class="fa-solid fa-circle-dot"></i>
                            <div class="awl-sub-detail">
                                <h5>Link Target Window</h5>
                                <p>Choose whether external links open in a New Tab (`_blank`) or the Same Tab (`_self`).</p>
                            </div>
                        </li>
                        <li class="awl-setting-sub-item">
                            <i class="fa-solid fa-circle-dot"></i>
                            <div class="awl-sub-detail">
                                <h5>Read More Link Text</h5>
                                <p>Easily customize the anchor text (e.g. "Read More", "View Case Study", "Visit Site") for the redirection link.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Card 6: Integrations & Premium Features -->
            <div class="awl-setting-card">
                <div class="awl-setting-card-header">
                    <div class="awl-setting-icon"><i class="fa-solid fa-gears"></i></div>
                    <h4>6. Integrations & Premium</h4>
                </div>
                <div class="awl-setting-card-body">
                    <p>Inject custom style code rules and explore advanced options.</p>
                    <ul class="awl-setting-sub-list">
                        <li class="awl-setting-sub-item">
                            <i class="fa-solid fa-circle-dot"></i>
                            <div class="awl-sub-detail">
                                <h5>Custom CSS Styles</h5>
                                <p>Inject custom style code rules safely to customize classes or elements globally on all galleries.</p>
                            </div>
                        </li>
                        <li class="awl-setting-sub-item">
                            <i class="fa-solid fa-circle-dot"></i>
                            <div class="awl-sub-detail">
                                <h5>Premium Version Upgrade</h5>
                                <p>Upgrade to the Premium version to unlock video support (Vimeo, YouTube, local mp4), image corner radius sliders, lazy loading optimizations, skeleton loaders, and full database JSON backups.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

        </div>

        <!-- CTA Live Demo Section -->
        <div class="awl-cta-section">
            <a href="https://awplife.com/demo/grid-gallery-premium/" target="_blank" class="awl-btn-premium">Check Grid Gallery Premium Live Demo</a>
        </div>

    </div>
</div>