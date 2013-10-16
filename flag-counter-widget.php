<?php

/*
Plugin Name: Flag Counter Widget
Plugin URI: http://www.flags.es
Description: Javascript based Flag Counter Widget
Version: 1
Author: Holger Deschakovski
Author URI: http://www.flags.es
License: GPL2
*/

/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'loadFcw' );

/**
 * Register our widget.
 * 'Example_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function loadFcw() {
	register_widget( 'Flag_Counter_Widget' );
}

/**
 * Flag Counter Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 * @since 0.1
 */
class Flag_Counter_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function Flag_Counter_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'flagcounter', 'description' => 'Display an Javascript based Flag Counter.' );

		/* Widget control settings. */
		$control_ops = array( 'width' => 600 );

		/* Create the widget. */
		$this->WP_Widget( 'flag-counter-widget', 'Flag Counter Widget', $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$textarea = $instance['textarea'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		/* Display name from widget settings if one was input. */
		if ( $textarea )
			echo $textarea;

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['textarea'] = $new_instance['textarea'];

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */

                $amidallaCode = '<!--Flags.es Flag Counter Start-->
<script type="text/javascript">
 <!--//
 ami_v = 13; // no. of visitors to display, max. no.: 200.
 ami_l = "000000"; // link colour, any hexadezimal colour code.
 ami_t = "000000"; // text colour, any hexadezimal colour code.
 ami_c = "FFFFFF"; // background colour, any hexadezimal colour code.
 ami_b = "000000"; // border colour, any hexadezimal colour code.
 ami_s = 11; // font size in pixels.
 ami_w = 200; // counter width in pixels.
 ami_h = 260; // counter height in pixels.
 ami_sc = 1; // show the total visitors count, on = 1 - off = 2.
 ami_to = 30; // time in seconds, for how long an allready existing ip wont be logged again. set to 1 for an hit count.
 ami_sm = "v"; // show last Visitors or best Countries, v = visitors - c = countries.
 ami_d = "1"; // format the display in columns, no. of columns.
 //-->
</script>
<script type="text/javascript" src="http://www.flags.es/geoip/amiip.js"></script>
<!--Flags.es Flag Counter End-->';


		$defaults = array( 'title' => __('www.flags.es - Flag Counter', 'flagcounter'), 'textarea' => __($amidallaCode, 'flagcounter1') );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>


		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title for the Widget:', 'flagcounter'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
		</p>

		<!-- Flag Counter Code: Textarea Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'textarea' ); ?>"><?php _e('Flag Counter Code ( please edit to fit your Layout (:', 'flagcounter1'); ?></label>
			<textarea style="width:600px; height: 600px" class="widefat" id="<?php echo $this->get_field_id('textarea'); ?>" name="<?php echo $this->get_field_name('textarea'); ?>"><?php echo $instance['textarea']; ?></textarea>
		</p>

	<?php
	}
}

?>