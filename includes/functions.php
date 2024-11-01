<?php

// Set this to the name of the GET variable you want to use.

function stpr_preview_theme_stylesheet($stylesheet) {
    $preview_theme_query_arg = STPR_QUERY_ARG;

	If (isset($_GET[$preview_theme_query_arg])) {
	    $theme = $_GET[$preview_theme_query_arg];
	}
	
    if (empty($theme)) {
        return $stylesheet;
    }

    $theme = wp_get_theme($theme);

    if (empty($theme)) {
        return $stylesheet;
    }

    return $theme['Stylesheet'];
}
add_filter('stylesheet', 'stpr_preview_theme_stylesheet',100);

function stpr_preview_theme_template($template) {
    $preview_theme_query_arg = STPR_QUERY_ARG;


	If (isset($_GET[$preview_theme_query_arg])) {
	    $theme = $_GET[$preview_theme_query_arg];
	}

    if (empty($theme)) {
        return $template;
    }

    $theme = wp_get_theme($theme);

    if (empty($theme)) {	
        return $template;
    }

    return $theme['Template'];
}
add_filter('template', 'stpr_preview_theme_template',100);

// Add Javascript 
function stpr_theme_enqueue_scripts() {
    wp_enqueue_script('stpr_theme_preview', STPR_PLUGIN_URL . 'script.js');
}
add_action('wp_enqueue_scripts','stpr_theme_enqueue_scripts','','',true);

?>