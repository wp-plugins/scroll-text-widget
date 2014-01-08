<?php
/*
* Plugin Name: Scroll Text Widget
* Plugin URI: http://vinmosmedia.com
 * Description: Widget to scroll text vertically.
 * Version: 1.0
 * Author: Brijesh Mishra
 * Author URI: http://vinmosmedia.com
 * License: A "Slug" license name e.g. GPL2
 * 
 */

class ScrollTextWidget extends WP_Widget{
	
	function __construct(){
		$params = array(
			'description'=>'Use this widget to show vertical scrolling text',
				'name'=>'Vertical Scrolling Text'
				
		);
		parent::__construct('ScrollingText','',$params);
		
	}
	
	public function form($instance){
		extract($instance);
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
			<input
				class="widefat"
				id="<?php echo $this->get_field_id('title'); ?>"
				name="<?php echo $this->get_field_name('title'); ?>"
				value="<?php if( isset($title) ) echo esc_attr($title); ?>"
			>	
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('description'); ?>">Description:</label>
				<textarea
					class="widefat"
					rows="10"
					id="<?php echo $this->get_field_id('description'); ?>"
					name="<?php echo $this->get_field_name('description'); ?>"
				><?php if( isset($description) ) echo esc_attr($description); ?></textarea>
		</p>
			
		<?php
		
	}
	
	public function widget($args,$instance){
		
		extract($args);
		extract($instance);
		
		echo $before_widget;
		echo $before_title . $title . $after_title;
		echo '<marquee behavior="scroll" scrollAmount="2" direction="up">'.$description.'</marquee>';
		echo $after_widget;
		
	}
	
}

add_action('widgets_init','st_register_scroll');
function st_register_scroll(){
	
	register_widget('ScrollTextWidget');
}

function admin_load_js(){
	
	wp_enqueue_script( 'custom_js', plugins_url( '/js/scrolltext_custom.js', __FILE__ ) );
}



add_action('wp_enqueue_scripts', 'admin_load_js');