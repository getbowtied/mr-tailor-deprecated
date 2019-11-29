<?php

/**
 * Plugin Name:       		Mr. Tailor Deprecated Features
 * Plugin URI:        		https://mrtailor.wp-theme.design/
 * Description:       		Old features of Mr. Tailor theme that are no longer used.
 * Version:           		1.1
 * Author:            		GetBowtied
 * Author URI:				https://getbowtied.com
 * Text Domain:				mr-tailor-deprecated
 * Domain Path:				/languages/
 * Requires at least: 		5.0
 * Tested up to: 			5.3
 *
 * @package  Mr. Tailor Deprecated
 * @author   GetBowtied
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! function_exists( 'is_plugin_active' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

// Plugin Updater
require 'core/updater/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://raw.githubusercontent.com/getbowtied/mr-tailor-deprecated/master/core/updater/assets/plugin.json',
	__FILE__,
	'mr-tailor-deprecated'
);

global $theme;
$theme = wp_get_theme();

if ( $theme->template == 'mrtailor') {

	//Include metaboxes
	//define('_TEMPLATEURL', WP_CONTENT_URL . '/themes/' . basename(TEMPLATEPATH));

	include_once( dirname(__FILE__) . '/includes/wpalchemy/MetaBox-mod.php' );
	include_once( dirname(__FILE__) . '/includes/wpalchemy/MediaAccess-mod.php' );

	$wpalchemy_media_access = new WPAlchemy_MediaAccess();

	include_once( dirname(__FILE__) . '/includes/metaboxes/slider-spec.php' );
	include_once( dirname(__FILE__) . '/includes/metaboxes/map-spec.php' );

	add_action( 'admin_enqueue_scripts', 'mr_tailor_deprecated_admin_styles' );
	function mr_tailor_deprecated_admin_styles() {
	    if ( is_admin() ) {
	    	wp_enqueue_style(
	    		'wpalchemy-metabox',
	    		plugins_url( 'includes/metaboxes/assets/css/wp-admin-metabox.css', __FILE__ ),
	    		array()
	    	);
	    }
	}

	add_action( 'wp_enqueue_scripts', 'mr_tailor_deprecated_styles' );
	function mr_tailor_deprecated_styles() {
    	wp_enqueue_style(
    		'mr-tailor-deprecated',
    		plugins_url( 'includes/assets/css/style.css', __FILE__ ),
    		array()
    	);
	}

	include_once( dirname(__FILE__) . '/includes/templates/index.php');

	add_action( 'wp_enqueue_scripts', 'mr_tailor_deprecated_custom_styles', 101 );
	function mr_tailor_deprecated_custom_styles() {

		global $slider_metabox;
		$slider_metabox->the_meta();

		ob_start();

		$slide_counter = 0;

		while( $slider_metabox->have_fields('items') ) { ?>

			<?php $slide_counter++; ?>

			.main-slider .slide_<?php echo esc_html($slide_counter); ?> {
				background-image:url(<?php echo ($slider_metabox->get_the_value('imgurl')); ?>);
			}

			.main-slider .slide_<?php echo esc_html($slide_counter); ?> .main-slider-elements.animated {
				-webkit-animation-name: <?php echo ($slider_metabox->get_the_value('slide_animation')); ?>;
				-moz-animation-name: <?php echo ($slider_metabox->get_the_value('slide_animation')); ?>;
				-o-animation-name: <?php echo ($slider_metabox->get_the_value('slide_animation')); ?>;
				animation-name: <?php echo ($slider_metabox->get_the_value('slide_animation')); ?>;
			}

			<?php if ($slider_metabox->get_the_value('slider_mood') == 'light') : ?>

				.main-slider .slide_<?php echo esc_html($slide_counter); ?> h1 {
					color:#000;
				}

				.main-slider .slide_<?php echo esc_html($slide_counter); ?> h1:after {
					background:#000;
				}

				.main-slider .slide_<?php echo esc_html($slide_counter); ?> h2 {
					color:#000;
				}

				.main-slider .slide_<?php echo esc_html($slide_counter); ?> a.slider_button {
					color:#fff;
					background:#000;
				}

				.main-slider .slide_<?php echo esc_html($slide_counter); ?> a.slider_button:hover {
					color:#000 !important;
					background:#fff !important;
				}

				.main-slider .slide_<?php echo esc_html($slide_counter); ?> .arrow-left,
				.main-slider .slide_<?php echo esc_html($slide_counter); ?> .arrow-right
				{
					color:#000;
				}

			<?php endif; ?>

		<?php
		}

		$content = ob_get_clean();
		wp_add_inline_style( 'mr-tailor-deprecated', $content );
	}
}
