<?php
/*
Plugin Name: Showcase Theme Preview Reloaded
Plugin URI: http://wpamanuke.com/showcase-theme-preview-reloaded
Description: Display themes located in wp-content/themes in a showcase gallery with theme screenshots and preview links.  Use shortcode [theme_showcase] in a post or page . You can also add Theme Preview Widget in your sidebar / footer . For Shortcode you can exclude or include a theme based on slug . For example exclude : [theme_showcase exclude="twentythirteen,nysu-magazine"] or include to show theme which you want only [theme_showcase include="nyeuseu-magazine,nysu-magazine"]
Version: 1.0.2
Author: WPAmaNuke
Author URI: http://wpamanuke.com/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

/*

Based on WordPress Theme Showcase Plugin 
Original Author: Brad Williams
Original Author URI: https://wordpress.org/plugins/wordpress-theme-showcase-plugin/
Because WordPress Theme Showcase Plugin not updated for long time , so i just make small modification and add javascript to add parameter so the preview can be seen in single , page , category etc not only on index.php when user click link in website and add widget functions. 

*/

define( 'STPR_QUERY_ARG' , 'theme_preview' );
define( 'STPR_PLUGIN_URL' , plugin_dir_url(__FILE__) );

require_once ( dirname( __FILE__ ) . '/includes/functions.php' );
require_once ( dirname( __FILE__ ) . '/includes/shortcode.php' );
// Widget Functions
require_once ( dirname( __FILE__ ) . '/includes/class-theme-preview-widget.php' );

/**
 * Register custom widget
 */
function stpr_register_widgets() {
	register_widget( 'STPR_Theme_Preview' );
}
add_action( 'widgets_init', 'stpr_register_widgets' );


?>