<?php
/**
* Plugin Name: WP Font Mfizz
* Description: Wordpress Plugin to add vectors icons of technology and software.
* Version: 1.0.0
* Text Domain: wp-font-mfizz
* Author: Moisés Icaza
* Author URI: http://moisesicaza.com.ve
* License: GPLv3.0
*/

/**
 * Global enqueue scripts and styles.
 */
add_action( 'wp_enqueue_scripts', function() {
	// font mfizz styles
	wp_enqueue_style(
		'wpfm-font-mfizz-icons',
		plugins_url( 'css/font-mfizz/font-mfizz.css', __FILE__ )
	);
});

	
/**
 * Admin enqueue scripts and styles.
 * 
 * @param string $hook Current page in the admin panel
 */
function wpfm_admin_enqueue_scripts( $hook ) {
	if ( ( $hook == 'post.php' || $hook == 'post-new.php' ) ) { // only post and pages
		// font mfizz styles
        wp_enqueue_style(
			'wpfm-font-mfizz-icons',
			plugins_url( 'css/font-mfizz/font-mfizz.css', __FILE__ )
		);
		
		// fontawesome iconpicker styles
        wp_enqueue_style(
			'wpfm-fontawesome-iconpicker',
			plugins_url( 'js/fontawesome-iconpicker/css/fontawesome-iconpicker.min.css', __FILE__ )
		);
		
		// custom styles
        wp_enqueue_style(
			'wpfm-main',
			plugins_url( 'css/wpfm.css', __FILE__ )
		);
		
		// fontawesome iconpicker scripts
		wp_enqueue_script(
			'wpfm-fontawesome-iconpicker',
			plugins_url( 'js/fontawesome-iconpicker/js/fontawesome-iconpicker.min.js', __FILE__ ),
			array( 'jquery' )
		);
		
		// custom scripts
		wp_enqueue_script(
			'wpfm-main',
			plugins_url( 'js/wpfm.js', __FILE__ ),
			array( 'jquery' )
		);
		
		// contains incon list
		wp_localize_script( 'wpfm-main', 'wpfm_vars', array( 
			'fa_prefix' => 'icon', 
			'fa_icons'  => wpfm_icon_list() 
		));
    }
}
add_action( 'admin_enqueue_scripts', 'wpfm_admin_enqueue_scripts' );

/**
 * Gets the list of icons from the file font-mfizz.css
 * 
 * @return Array
 */
function wpfm_icon_list() {

	$icons = array();
	$hex_codes = array();
	
	$file = file_get_contents( plugins_url( 'css/font-mfizz/font-mfizz.css', __FILE__ ) ); 
	
	preg_match_all( '/\.(icon)([^,}]*)\s*:before\s*{\s*(content:)\s*"(\\\\[^"]+)"/s', $file, $matches );
	
	$icons = $matches[2];
	$hex_codes = $matches[4];

	$icons = array_combine( $hex_codes, $icons );

	asort( $icons );

	return $icons;
}

/**
 * Wordpress shortcode
 * 
 * @param Array $atts Argument list
 */
function wpfm_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'name' => '',
		'size' => '',
		'color' => '',
	), $atts ));
	
	$html = "
	<span style='font-size:{$size}px; color:{$color};'>
		<i class='{$name}'></i>
	</span>
	";
	
	return $html;
}
add_shortcode( 'wpfm_icon', 'wpfm_shortcode' );


/**
 * Insert media button in the text editor
 */
function wpfm_media_button() {
	ob_start();
	?>
	<span class="wpfm-iconpicker fontawesome-iconpicker" data-selected="icon-wordpress">
		<a href="#" class="button button-secondary iconpicker-component">
			<span class="icon-wordpress"></span>&nbsp;
			<?php esc_html_e( 'Font Mfizz Icons', 'wp-font-mfizz' ); ?>
		</a>
	</span>
	<?php
	
	echo ob_get_clean();
}
add_action( 'media_buttons', 'wpfm_media_button', 99 );
