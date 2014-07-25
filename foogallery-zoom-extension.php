<?php
/**
 * FooGallery ZOOM! Extension
 *
 * A simple gallery with one awesome effect: ZOOM!
 *
 * @package   ZOOM_Template_FooGallery_Extension
 * @author     Matt Cromwell
 * @license   GPL-2.0+
 * @link      http://mattcromwell.com
 * @copyright 2014  Matt Cromwell
 *
 * @wordpress-plugin
 * Plugin Name: FooGallery - ZOOM!
 * Description: A simple gallery with one awesome effect: ZOOM!
 * Version:     1.0.0
 * Author:       Matt Cromwell
 * Author URI:  http://mattcromwell.com
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

if ( !class_exists( 'ZOOM_Template_FooGallery_Extension' ) ) {

	define('ZOOM_FG_URL', plugin_dir_url( __FILE__ ));
	define('ZOOM_TEMPLATE_FOOGALLERY_EXTENSION_VERSION', '1.0.0');

	require_once( 'foogallery-zoom-init.php' );
	
	// Enqueue Minicolors Color picker to FooGallery CPT
	add_action( 'admin_print_scripts-post.php', 'admin_minicolors', 11 );

	function admin_minicolors() {
		global $post_type;
		if( 'foogallery' == $post_type )
		wp_enqueue_script( 'minicolors', ZOOM_FG_URL . 'js/minicolors.js' );
	}
	
	
	class ZOOM_Template_FooGallery_Extension {
		/**
		 * Wire up everything we need to run the extension
		 */
		function __construct() {
			add_filter( 'foogallery_gallery_templates', array( $this, 'add_template' ) );
			add_filter( 'foogallery_gallery_templates_files', array( $this, 'register_myself' ) );
			add_filter( 'foogallery_located_template-zoom', array( $this, 'enqueue_dependencies' ) );
		}

		/**
		 * Register myself so that all associated JS and CSS files can be found and automatically included
		 * @param $extensions
		 *
		 * @return array
		 */
		function register_myself( $extensions ) {
			$extensions[] = __FILE__;
			return $extensions;
		}

		/**
		 * Enqueue any script or stylesheet file dependencies that your gallery template relies on
		 */
		function enqueue_dependencies() {
			$js = ZOOM_FG_URL . 'js/jquery.zoom.js';
			wp_enqueue_script( 'zoom', $js, array('jquery'), ZOOM_TEMPLATE_FOOGALLERY_EXTENSION_VERSION );

			$css = ZOOM_FG_URL . 'css/gallery-zoom.css';
			wp_enqueue_style( 'zoom', $css, array(), ZOOM_TEMPLATE_FOOGALLERY_EXTENSION_VERSION );
		}
				
		/**
		 * Add our gallery template to the list of templates available for every gallery
		 * @param $gallery_templates
		 *
		 * @return array
		 */
		function add_template( $gallery_templates ) {

			$gallery_templates[] = array(
				'slug'        => 'zoom',
				'name'        => __( 'ZOOM!', 'foogallery-zoom'),
				'preview_css' => ZOOM_FG_URL . 'css/gallery-zoom.css',
				'admin_js'	  => ZOOM_FG_URL . 'js/admin-gallery-zoom.js',
				'fields'	  => array(
					array(
						'id'	  => 'help',
						'title'	  => __('Tip', 'foogallery'),
						'section' => __('Thumbnail Settings', 'foogallery-zoom'),
						'type'	  => 'html',
						'help'	  => true,
						'desc'	  => __('Magnifcation is done by hiding the full size image, and just showing the smaller size. But when you hover over the smaller size, the larger size appears inside the zoom circle. So by adjusting the "Magnified Image Size" against the "Visible Width", you can alter how much magnification happens. For example, if your "Visible Width" is 200px wide, and your "Magnified Image Size" is 600px wide, then you have a magnification of 3.', 'foogallery')
					),
					array(
						'id'      => 'thumbnail_size',
						'title'   => __('Magnified Image Size', 'foogallery-zoom'),
						'section' => __('Thumbnail Settings', 'foogallery-zoom'),
						'desc'    => __('This sets how large the image will be inside the magnifying glass.', 'foogallery-zoom'),
						'type'    => 'thumb_size',
						'default' => array(
							'width' => get_option( 'thumbnail_size_w' ),
							'height' => get_option( 'thumbnail_size_h' ),
							'crop' => true
						)
					),
					array(
						'id'      => 'viswidth',
						'title'   => __('Visible width', 'foogallery-zoom'),
						'section' => __('Thumbnail Settings', 'foogallery-zoom'),
						'default' => '200' ,
						'type'    => 'number',
						'desc'	  => __('This sets the width of the images before magnification.', 'foogallery-zoom'),
						'class'   => 'small-text',
						'step'    => 1,
						'min'     => 100
					),
					array(
						'id'      => 'spacing',
						'title'   => __('Spacing', 'foogallery'),
						'section' => __('Thumbnail Settings', 'foogallery'),
						'desc'    => __('The spacing or gap between thumbnails in the gallery.', 'foogallery'),
						'type'    => 'select',
						'default' => 'spacing-width-10',
						'choices' => array(
							'spacing-width-0' => __( '0 pixels', 'foogallery' ),
							'spacing-width-5' => __( '5 pixels', 'foogallery' ),
							'spacing-width-10' => __( '10 pixels', 'foogallery' ),
							'spacing-width-15' => __( '15 pixels', 'foogallery' ),
							'spacing-width-20' => __( '20 pixels', 'foogallery' ),
							'spacing-width-25' => __( '25 pixels', 'foogallery' )
						)
					),
					array(
						'id'      => 'lenssize',
						'title'   => __('Lens Size', 'foogallery-zoom'),
						'section' => __('Lens Style', 'foogallery-zoom'),
						'desc'    => __('The size of the magnifying circle', 'foogallery-zoom'),
						'default' => '100',
						'type'    => 'number',
						'class'   => 'small-text',
						'step'    => 10,
						'min'     => 50
					),
					array(
						'id'      => 'bordersize',
						'title'   => __('Lens Border Size', 'foogallery-zoom'),
						'section' => __('Lens Style', 'foogallery-zoom'),
						'desc'    => __('The size of the border around the magnifying circle', 'foogallery-zoom'),
						'default' => '5',
						'type'    => 'number',
						'class'   => 'small-text',
						'step'    => 1,
						'min'     => 0
					),
					array(
						'id'      => 'bordercolor',
						'title'   => __('Lens Border Color', 'foogallery-zoom'),
						'section' => __('Lens Style', 'foogallery-zoom'),
						'desc'    => __('The color of the border around the magnifying circle', 'foogallery-zoom'),
						'default' => '#333',
						'type'    => 'text',
						'class'   => 'minicolors',
					),
				)
			);

			return $gallery_templates;
		} // End add_template
	} // End Class
} // End if !class_exists