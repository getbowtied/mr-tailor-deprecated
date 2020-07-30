<?php

class TR_Deprecated_Templates {

	/**
     * A Unique Identifier
     */
	 protected $plugin_slug;

    /**
     * A reference to an instance of this class.
     */
    private static $instance;

    /**
     * The array of templates that this plugin tracks.
     */
    protected $templates;

    /**
	 * Returns an instance of this class.
	 */
    public static function get_instance() {

		if( null == self::$instance ) {
			self::$instance = new TR_Deprecated_Templates();
		}

		return self::$instance;

	}

	/**
	 * Initializes the plugin by setting filters and administration functions.
	 */
	private function __construct() {

		$this->templates = array();

		// Add a filter to the attributes metabox to inject template into the cache.
		if ( version_compare( floatval( get_bloginfo( 'version' ) ), '4.7', '<' ) ) {

			// 4.6 and older
			add_filter(
				'page_attributes_dropdown_pages_args',
				array( $this, 'register_project_templates' )
			);

		} else {

			// Add a filter to the wp 4.7 version attributes metabox
			add_filter(
				'theme_page_templates', array( $this, 'add_new_template' )
			);

		}

		// Add a deprecated template notification to admin
		add_action( 'admin_notices', array( $this, 'add_template_deprecated_notification' ) );

		// Add a filter to the save post to inject out template into the page cache
		add_filter(
			'wp_insert_post_data',
			array( $this, 'register_project_templates' )
		);

		// Add a filter to the template include to determine if the page has our
		// template assigned and return it's path
		add_filter(
			'template_include',
			array( $this, 'view_project_template')
		);

		// Add your templates to this array.
		$this->templates = array(
			'page-contact.php' => 'Contact Page',
			'page-with-slider-full-width.php' => 'Page With Slider Full Width',
			'page-with-slider.php' => 'Page With Slider',
		);
	}

	/**
	 * Adds an admin notification about deprecated templates
	 */
	public function add_template_deprecated_notification() {
		global $post;

		$deprecated_template_in_use = false;

		if ( isset( $post ) && get_post_type($post->ID) == 'page' ) {
			$pagetemplate = get_post_meta( $post->ID, '_wp_page_template', true );
			if ( !empty( $pagetemplate ) ) {
				switch ( $pagetemplate ) {
					case 'page-contact.php':
						$deprecated_template_in_use = true;
						break;
					case 'page-with-slider-full-width.php':
						$deprecated_template_in_use = true;
						break;
					case 'page-with-slider.php':
						$deprecated_template_in_use = true;
						break;
					default:
						break;
				}
			}
		}

		if( $deprecated_template_in_use ) {
			?>
			<div class="notice-warning settings-error notice">
				<p>
					<strong>
						<span>This page template is deprecated, you can still use it with the Mr. Tailor Deprecated Features plugin enabled, but it’s recommended to switch to a different page template.</span>
					</strong>
				</p>
			</div>
			<?php
		}

		return;
	}

	/**
	 * Adds our template to the page dropdown for v4.7+
	 */
	public function add_new_template( $posts_templates ) {
		$posts_templates = array_merge( $posts_templates, $this->templates );
		return $posts_templates;
	}

	public function register_project_templates( $atts ) {

		// Create the key used for the themes cache
		$cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );

		// Retrieve the cache list.
		// If it doesn't exist, or it's empty prepare an array
		$templates = wp_get_theme()->get_page_templates();
		if ( empty( $templates ) ) {
			$templates = array();
		}

		// New cache, therefore remove the old one
		wp_cache_delete( $cache_key , 'themes');

		// Now add our template to the list of templates by merging our templates
		// with the existing templates array from the cache.
		$templates = array_merge( $templates, $this->templates );

		// Add the modified cache to allow WordPress to pick it up for listing
		// available templates
		wp_cache_add( $cache_key, $templates, 'themes', 1800 );

		return $atts;
	}

	/**
	 * Checks if the template is assigned to the page
	 */
	public function view_project_template( $template ) {

		// Get global post
		global $post;

		// Return template if post is empty
		if ( ! $post ) {
			return $template;
		}

		// Return default template if we don't have a custom one defined
		if ( !isset( $this->templates[get_post_meta(
			$post->ID, '_wp_page_template', true
		)] ) ) {
			return $template;
		}

		$file = plugin_dir_path(__FILE__). get_post_meta(
			$post->ID, '_wp_page_template', true
		);

		// Just to be safe, we check if the file exist first
		if ( file_exists( $file ) ) {
			return $file;
		} else {
			echo $file;
		}

		// Return template
		return $template;

	}
}

add_action( 'plugins_loaded', array( 'TR_Deprecated_Templates', 'get_instance' ) );
