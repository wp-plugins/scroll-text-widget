<?php
/*
* Plugin Name: Scroll Text Widget
* Plugin URI: http://vinmosmedia.com
 * Description: Widget to scroll text vertically.
 * Version: 1.1
 * Author: Brijesh Mishra
 * Author URI: http://vinmosmedia.com
 * License: A "Slug" license name e.g. GPL2
 * Network: false
 * License: A short license name. Example: GPL2
 */

/*  Copyright 2014  Brijesh Mishra  (email : brijeshmkt@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


function add_menu_icons_styles(){
?>
<style type="text/css">
#adminmenu #toplevel_page_stw_setting_page_slug div.wp-menu-image:before { content: "\f111"; }</style>
<?php
}

add_action( 'admin_head', 'add_menu_icons_styles' );

add_action( 'admin_menu', 'stw_menu_page' );
add_action( 'admin_init', 'stw_setting_options' );

function stw_setting_options() {
	//register our settings
	register_setting( 'baw-settings-group', 'stw_direction' );
	register_setting( 'baw-settings-group', 'stw_speed' );
	
}

function stw_menu_page(){
    add_menu_page( 'Scrolling Text', 'Scrolling Text', 
    	'manage_options',
    	'stw_setting_page_slug', 
    	'stw_setting_page', 
    	plugins_url( 'ScrollTextWidget/icon.png' ), 6 ); 
}

function stw_setting_page(){
?>

<div class="wrap">
<h2>Scrolling text widget settings</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'baw-settings-group' ); ?>
    <?php do_settings_sections( 'baw-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Scrolling Direction</th>
        <td><input type="text" name="stw_direction" value="<?php echo esc_attr( get_option('stw_direction') ); ?>" />
			Two options only "up" or "down". If kept blank default option is up
        </td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Speed</th>
        <td><input type="text" name="stw_speed" value="<?php echo esc_attr( get_option('stw_speed') ); ?>" />
			Enter digit's only e.g. "2" or "3". If kept blank default option is 2.
        </td>
        </tr>
        
       
    </table>
    
    <?php submit_button(); ?>

</form>
</div>

<ul>
	<li>Hello, Wordpress users, hope this plugin is useful in beautifiy your website.</li>
	<li>Request you to provide review on this <a href="https://wordpress.org/plugins/scroll-text-widget/">plugin</a></li>
	<li>You can also email me at brijeshmkt@gmail.com</li>
	<li>You can also contact me for tasks like Wordpress customization, bespoke plugin development, customize existing plugin, woo commerce related task, creating shopping website in wordpress, Website speed related issue etc.</li>
	
</ul>
    
<?php    




}




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
		
		if(get_option( 'stw_direction') == "down"){
			$direction = 'down';
		}else{
			$direction = 'up';
		}

		if(get_option('stw_speed') == ""){
			$speed = 2;
		}else{
			$speed = get_option('stw_speed');
		}
		
		extract($args);
		extract($instance);
		
		echo $before_widget;
		echo $before_title . $title . $after_title;
		echo '<marquee behavior="scroll" scrollAmount="'.$speed.'" direction="'.$direction.'">'.$description.'</marquee>';
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