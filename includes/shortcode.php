<?php

// Shortcode Functions
function stpr_theme_showcase_funct( $atts ){
	 $data = shortcode_atts( array(
        'exclude' => '',
        'include' => '',
		'newtab' => ''
    ), $atts );
	
	
	$themes = wp_get_themes();
	$form = '';
	$target = ' target="_blank"';
	if ( 1 < count($themes) ) {
		$theme_names = array_keys($themes);
		natcasesort($theme_names);
		
		// exclude or include
		if ($data['exclude'] != '') {
			$exclude = explode( ',' , $data['exclude'] );
			foreach ($exclude as $key => $value) {
				$exclude[$key] = sanitize_title( $value );
			}
			$theme_names = array_diff( $theme_names , $exclude );
			
		} else 
		if ($data['include'] != '') {
			$include = explode( ',' , $data['include'] );
			foreach ($include as $key => $value) {
				$include[$key] = sanitize_title( $value );
			}
			$theme_names = array_intersect( $theme_names , $include );
		}
		if ($data['newtab'] == 'no') {
			$target = '';
		}
		
		foreach ($theme_names as $theme_name) {
			$template = $themes[$theme_name]['Template'];
			$stylesheet = $themes[$theme_name]['Stylesheet'];
			$title = $themes[$theme_name]['Title'];
			$version = $themes[$theme_name]['Version'];
			$description = $themes[$theme_name]['Description'];
			$author = $themes[$theme_name]['Author'];
			$screenshot = $themes[$theme_name]['Screenshot'];
			$stylesheet_dir = $themes[$theme_name]['Stylesheet Dir'];
			$template_dir = $themes[$theme_name]['Template Dir'];
			$tags = $themes[$theme_name]['Tags'];

			$screenshot_url = $themes[$theme_name]['Theme Root URI'] .'/' .$template .'/' .$screenshot;
			$preview_url = get_bloginfo('url') . '/?theme_preview=' . $theme_name;
			$form .= '<div class="stpr-item">';
			$form .= '<h3><a href="' . esc_url( $preview_url ) . '"' . $target . '>' .  esc_html( $title ). '</a></h3>';
			$form .= '<a href="' . esc_url( $preview_url ) . '"' . $target . '><img src= "' . esc_url( $screenshot_url ) . '" alt="" /></a>';
			$form .= '<p>Description: '. esc_html( $description ) . '</p>';
			$form .= '</div>';
			
		}
		$form = '<div class="stpr-showcase">' . $form . '</div>';
	}
	return $form;
}
add_shortcode( 'theme_showcase', 'stpr_theme_showcase_funct' );

?>