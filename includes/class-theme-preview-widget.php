<?php

class STPR_Theme_Preview extends WP_Widget {
	
	/**
	 * Sets up a new Theme Preview widget instance.
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'stpr_widget_theme_preview',
			'description' => esc_html__( 'Show all themes for Preview' , 'stpr-theme-preview' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'stpr-theme-preview', esc_html__( 'Theme Preview' , 'stpr-theme-preview' ), $widget_ops );
	}
	
	
	/**
	 * Outputs the content for the current Theme Preview widget instance.
	 */
	 public function widget( $args, $instance ) {
		 if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		
		$cb_opentab = ! empty( $instance['cb_opentab'] ) ? $instance['cb_opentab'] : false;
		$select_choice = ( ! empty( $instance['select_choice'] ) ) ? $instance['select_choice'] : '';
		$textarea_choice = ( ! empty( $instance['textarea_choice'] ) ) ? $instance['textarea_choice'] : '';
		
		echo $args['before_widget'];
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		
		$themes = wp_get_themes();
		$target = '';
		if ($cb_opentab) {
			$target = "_blank";
		}
		if ( 1 < count($themes) ) {
			echo '<ul>';
			$theme_names = array_keys($themes);
			natcasesort($theme_names);
			
			//exclude / include
			if ($select_choice == 'exclude') {
				$exclude = explode( ',' , $textarea_choice );
				foreach ($exclude as $key => $value) {
					$exclude[$key] = sanitize_title( $value );
				}
				$theme_names = array_diff( $theme_names , $exclude );
			} else
			if ($select_choice == 'include') {
				$include = explode( ',' , $textarea_choice );
				foreach ($include as $key => $value) {
					$include[$key] = sanitize_title( $value );
				}
				$theme_names = array_intersect( $theme_names , $include );
			}
			
			foreach ($theme_names as $theme_name) {
				$title = $themes[$theme_name]['Title'];
				$preview_url = get_bloginfo('url') . '/?theme_preview=' . $theme_name;
				echo '<li><a href="'. esc_url( $preview_url ) .'" target="'. $target .'" title="">'. esc_html( $title ) .'</a></li>';
			}
			echo '</ul>';
			
		}
		echo $args['after_widget'];
		
	 }
	 
	 /**
	 * Handles updating the settings for the current Theme Preview widget instance.
	 */
	 public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['cb_opentab'] = isset( $new_instance['cb_opentab'] ) ? 1 : false;
		$instance['select_choice'] = sanitize_text_field( $new_instance['select_choice'] );
		$instance['textarea_choice'] = sanitize_text_field( $new_instance['textarea_choice'] );
		return $instance;
	 }
	 
	 /**
	 * Outputs the settings form for the Theme Preview widget.
	 */
	 public function form( $instance ) {
		 $defaults = array(
			'title'    => '',
			'cb_opentab' => '1',
			'select_choice' => '',
			'textarea_choice' => ''
		);
		extract( wp_parse_args( ( array ) $instance, $defaults ) ); ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Widget Title', 'stpr-theme-preview' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		
		<p>
			<input id="<?php echo esc_attr( $this->get_field_id( 'cb_opentab' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cb_opentab' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $cb_opentab ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'cb_opentab' ) ); ?>"><?php _e( 'Open Link in New Window', 'stpr-theme-preview' ); ?></label>
		</p>
		
		<p>
		  <label for="<?php echo $this->get_field_id('select_choice'); ?>">Type: 
			<select class='widefat' id="<?php echo $this->get_field_id('select_choice'); ?>"
					name="<?php echo $this->get_field_name('select_choice'); ?>" type="text">
			  <option value=''<?php echo ($select_choice=='')?'selected':''; ?>>
				All
			  </option>
			  <option value='exclude'<?php echo ($select_choice=='exclude')?'selected':''; ?>>
				Exclude
			  </option> 
			  <option value='include'<?php echo ($select_choice=='include')?'selected':''; ?>>
				Include
			  </option> 
			</select>                
		  </label>
		 </p>
		 
		 <p>Exclude/Include Theme with comma delimited : <textarea class="widefat" 
		  name="<?php echo $this->get_field_name('textarea_choice') ?>"
		  ><?php echo esc_attr( $textarea_choice ); ?></textarea>
		</p>
		 <?php
	 }
	 
}


?>