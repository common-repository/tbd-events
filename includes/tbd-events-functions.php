<?php

use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
require_once plugin_dir_path(__FILE__) . 'admin/tbd-events-options.php';
require_once plugin_dir_path(__FILE__) . 'tbd-events-products.php';
/*
 * Add TBD Menu
 */
add_action( 'admin_menu', 'tbd_plugin_menu' );

/** Add Menu items and register settings **/
function tbd_plugin_menu() {
	add_menu_page( 'TBD Events', 'TBD Events', 'manage_options', 'tbd', 'tbd_events_main_page', plugin_dir_url( __DIR__ ).'includes/img/16x16.png', 11 );
	add_submenu_page( 'tbd', 'TBD Events', 'Details', 'manage_options', 'tbd', 'tbd_events_main_page');
	add_submenu_page( 'tbd', 'TBD Events Options', 'Hosts', 'manage_options', 'tbd-options', 'tbd_events_options_page');
}
function tbd_events_options_page() {
	?>
		<div class="wrap">
			<h1>Event Options</h1>
			<form action='options.php' method='post'>
				<h2>Settings</h2>
				<?php
				settings_fields( 'tbd-events' );
				do_settings_sections( 'tbd-events' );
				submit_button();
				?>
			</form>
			<p>Created by Think By Design for <?php echo esc_html(get_bloginfo('name')); ?>.</p>
		</div>
	<?php
}

add_action( 'admin_init', 'tbd_events_settings_init' );
function tbd_events_settings_init( ) { 

    register_setting( 'tbd-events', 'tbd_host_array' );
	
	add_settings_section(
        'tbd_host_array_section', 
        __( 'Event Hosts', 'tbd' ), 
        'tbd_host_array_section_callback', 
        'tbd-events'
    );

    add_settings_field( 
        'tbd_host_array', 
        __( 'Hosts:', 'tbd' ), 
        'tbd_host_array_render', 
        'tbd-events', 
        'tbd_host_array_section',
		array('label_for' => 'tbd_host_array')
    );
}
function tbd_host_array_render( ) { 
    $options = get_option( 'tbd_host_array', array() );
	$counter = 0;
	
	if (is_array($options)) {
	
		foreach ($options as $option) {
		?>
		<div class="tbd_host_array_group" id="tbd_host_array_<?php echo esc_attr($counter);?>_container">
			<h3 style="display:none;"><?php echo esc_html((isset($option['name']) && $option['name'] != '') ? $option['name'] : 'No name!');?></h3>
			<label for="tbd_host_array_<?php echo esc_attr($counter);?>_name">Name:</label><input id="tbd_host_array_<?php echo esc_attr($counter);?>_name" name="tbd_host_array[<?php echo esc_attr($counter);?>][name]" type='text' value="<?php echo esc_html(isset($option['name']) ? $option['name'] : ''); ?>" placeholder="Host name"/>
			<label for="tbd_host_array_<?php echo esc_attr($counter);?>_site">Website:</label><input id="tbd_host_array_<?php echo esc_attr($counter);?>_site" name="tbd_host_array[<?php echo esc_attr($counter);?>][site]" type='text' value="<?php echo esc_html(isset($option['site']) ? $option['site'] : ''); ?>" placeholder="Website address"/>
			<label for="tbd_host_array_<?php echo esc_attr($counter);?>_email">Email:</label><input id="tbd_host_array_<?php echo esc_attr($counter);?>_email" name="tbd_host_array[<?php echo esc_attr($counter);?>][email]" type='email' value="<?php echo esc_html(isset($option['email']) ? $option['email'] : ''); ?>" placeholder="Email address"/>
			<label for="tbd_host_array_<?php echo esc_attr($counter);?>_phone">Phone:</label><input id="tbd_host_array_<?php echo esc_attr($counter);?>_phone" name="tbd_host_array[<?php echo esc_attr($counter);?>][phone]" type='tel' value="<?php echo esc_html(isset($option['phone']) ? $option['phone'] : ''); ?>" placeholder="Phone number"/>
			<label for="tbd_host_array_<?php echo esc_attr($counter);?>_desc">Short bio:</label>
			<?php
			$settings = array(
				'textarea_rows' => 6,
				'tabindex' => 1,
				'media_buttons' => false,
				'textarea_name' => 'tbd_host_array['.$counter.'][desc]'
			);
				wp_editor( isset($option['desc']) ? wp_kses_post($option['desc']) : '', 'tbd_host_array_'.$counter.'_desc', $settings );
			?>
			<button class="trainer-remove">Remove</button>
			<div class="tbd-host-image-container">
				<img class="tbd-host-img-<?php echo esc_attr($counter);?>" src="<?php echo esc_url((isset($option['pic']) && $option['pic'] != null) ? $option['pic'] : plugin_dir_url( __DIR__ ).'includes/img/bg.png'); ?>" height="120" width="120"/>
                <input type="text" id="tbd_host_array_<?php echo esc_attr($counter);?>_pic" name="tbd_host_array[<?php echo esc_attr($counter);?>][pic]" size="60" placeholder="URL to the image." value="<?php echo esc_url(isset($option['pic']) ? $option['pic'] : ''); ?>"/>
                <a href="#" class="tbd-host-pic-upload" data-num="<?php echo esc_attr($counter);?>">Upload</a>
			</div>
			<span class="tbd_hide_show dashicons dashicons-arrow-up-alt2"></span>
		</div>
		
		
		<?php
		$counter++;
		}
	} else {
		?>
		<div class="tbd_host_array_group" id="tbd_host_array_0_container">
			
			<label for="tbd_host_array_0_name">Name:</label><input id="tbd_host_array_0_name" name="tbd_host_array[0][name]" type='text' placeholder="Host name" />
			<label for="tbd_host_array_0_email">Email:</label><input id="tbd_host_array_0_email" name="tbd_host_array[0][email]" type='email' placeholder="Email address" />			
			<label for="tbd_host_array_0_site">Website:</label><input id="tbd_host_array_0_site" name="tbd_host_array[0][site]" type='text' placeholder="Website address" />
			<label for="tbd_host_array_0_phone">Phone:</label><input id="tbd_host_array_0_phone" name="tbd_host_array[0][phone]" type='tel' placeholder="Phone number" />
			<label for="tbd_host_array_0_desc">Short bio:</label><textarea id="tbd_host_array_0_desc" name="tbd_host_array[0][desc]" placeholder="Information about this host."></textarea>
			<button type="button" class="trainer-remove">Remove</button>
			<div class="tbd-host-image-container">
				<img class="tbd-host-img-0" src="<?php echo esc_url((isset($option['pic']) && $option['pic'] != null) ? $option['pic'] : plugin_dir_url( __DIR__ ).'includes/img/bg.png'); ?>" height="100" width="100"/>
                <input type="text" id="tbd_host_array_0_pic" name="tbd_host_array[0][pic]" size="60" placeholder="URL to the image." />
                <a href="#" class="tbd-host-pic-upload" data-num="0">Upload</a>
			</div>
		</div>
		
		<?php
	}
	$bg = plugin_dir_url( __DIR__ ).'includes/img/bg.png';
		?>
	<script type='text/javascript'>
        jQuery(document).ready(function ($) {
			$(document).on('click','.tbd-host-pic-upload', function(e) {
					e.preventDefault();
					var num = $(this).data("num");
					var custom_uploader = wp.media({
						title: 'Custom Image',
						button: {
							text: 'Upload Image'
						},
						multiple: false  // Set this to true to allow multiple files to be selected
					})
					.on('select', function() {
						var attachment = custom_uploader.state().get('selection').first().toJSON();
						$('.tbd-host-img-'+num).attr('src', attachment.url);
						$('#tbd_host_array_'+num+'_pic').val(attachment.url);

					})
					.open();
				});
            var count=jQuery('.tbd_host_array_group').length;
            jQuery(document).on('click', '.trainer-remove' , function() {
				count--;
				jQuery(this).parent().remove();
			});
			jQuery('.tbd_hide_show').on('click', function() {
				jQuery(this).toggleClass('dashicons-arrow-up-alt2 dashicons-arrow-down-alt2');
				jQuery(this).parent().children().not(this).toggle();
			});
			jQuery('#trainer-add').on('click', function() {
				
				jQuery('#trainer-add').before('<div class="tbd_host_array_group" id="tbd_host_array_'+count+'_container"><label for="tbd_host_array_'+count+'_name">Name:</label><input id="tbd_host_array_'+count+'_name" name="tbd_host_array['+count+'][name]" type="text" placeholder="Name" /><label for="tbd_host_array_'+count+'_site">Website:</label><input id="tbd_host_array_'+count+'_site" name="tbd_host_array['+count+'][site]" type="text" placeholder="Website address" /><label for="tbd_host_array_0_email">Email:</label><input id="tbd_host_array_'+count+'_email" name="tbd_host_array['+count+'][email]" type="email" placeholder="Email address" /><label for="tbd_host_array_'+count+'_phone">Phone:</label><input id="tbd_host_array_'+count+'_phone" name="tbd_host_array['+count+'][phone]" type="tel" placeholder="Phone number" /><label for="tbd_host_array_0_phone">Description:</label><textarea id="tbd_host_array_'+count+'_desc" name="tbd_host_array['+count+'][desc]" placeholder="Short bio for the host."></textarea><button type="button" class="trainer-remove">Remove</button><div class="tbd-host-image-container">	<img class="tbd-host-img-'+count+'" src="<?php echo esc_url($bg); ?>" height="100" width="100"/><input type="text" id="tbd_host_array_'+count+'_pic" name="tbd_host_array['+count+'][pic]" size="60" placeholder="URL to the image."> <a href="#" class="tbd-host-pic-upload" data-num="'+count+'">Upload</a></div></div>');
				count++;
			});
        });
    </script>
	<style>
		.tbd_host_array_group {
			display:grid;
			grid-template-areas:"label input image";
			grid-template-columns: 10ch 3fr 25%;
			grid-gap:.2em 2em;
			border:2px solid #ccc;
			margin:.2em 0;
			background:#f6f6f6;
			border-radius: 10px;
			padding: 1em;
			position:relative;
		}
		label {
			grid-area: label;
			grid-row: auto;
		}
		input, textarea, div.wp-editor-wrap {
			grid-area: input;
			grid-row:auto;
		}
		textarea {
			white-space: pre-wrap;
		}
		.tbd-host-image-container {
			grid-area: image;
			grid-row-start: 1;
			grid-row-end: 6;
		}
		.tbd-host-image-container input {
			display:block;
			clear:both;
			width:100%;
		}
		.trainer-remove {
			height: 2em;
			align-self: end;
		}
		.tbd_hide_show {
			position:absolute;
			right:1em;
			top:1em;
		}
		.tbd_host_array_group h3 {margin:0;grid-column-end: 1;}
	</style>
	<button type="button" id="trainer-add">Add</button>
	<?php
	
	if(function_exists( 'wp_enqueue_media' )){
    wp_enqueue_media();
}else{
    wp_enqueue_style('thickbox');
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
}
	
}
function tbd_host_array_section_callback(  ) { 
    echo __( 'Enter the host\'s details. These can be shown, hidden, or styled as desired.', 'tbd-events' );
}


/* For displaying the main page */
function tbd_events_main_page() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	include plugin_dir_path( __FILE__ ).'/admin/tbd-events.php';
}

//Elementor Category
function tbd_elementor_widget_categories( $elements_manager ) {

	$elements_manager->add_category(
		'tbd-events',
		[
			'title' => __( 'Think By Design Events', 'tbd-events' ),
			'icon' => plugin_dir_url( __DIR__ ).'includes/img/16x16.png',
		]
	);
}
add_action( 'elementor/elements/categories_registered', 'tbd_elementor_widget_categories' );

//Elementor blocks

add_action( 'elementor/widgets/widgets_registered', function() {
	require_once('admin/elementor/calendar.php');
	require_once('admin/elementor/list.php');
	
	$list_widget = new TBD_List_Widget();
	$calendar_widget = new TBD_Calendar_Widget();

	// Let Elementor know about the widget
	Plugin::instance()->widgets_manager->register_widget_type( $list_widget );
	Plugin::instance()->widgets_manager->register_widget_type( $calendar_widget );
});

//Register scripts, enqueued by Elementor widget

function tbd_register_scripts() {
	wp_register_script('tbd_events_cal_main_js', plugin_dir_url( __FILE__ ) . 'assets/calendar/main.min.js', array( 'jquery' ), null, true);
	wp_register_script('tbd_events_cal_js', plugin_dir_url( __FILE__ ) . 'assets/calendar/calendar.js', array( 'jquery' ), null, true);
	wp_register_style('tbd_cal_main_css', plugin_dir_url( __FILE__ ) . 'assets/calendar/main.min.css');
	wp_register_style( 'fontawesome', 'https://pro.fontawesome.com/releases/v5.10.0/css/all.css', false, '5.10.0' );
	wp_register_style( 'tbd-events-list-css', plugin_dir_url( __FILE__ ) . 'assets//list/list.css' , false, '1.0.0' );
}
add_action('wp_enqueue_scripts', 'tbd_register_scripts');

/*
* Shortcodes
*/

//List
if( !function_exists('tbd_list_event_products') ) {

    function tbd_list_event_products( $atts ) {
		wp_enqueue_style('tbd-events-list-css');

        // Shortcode Attributes
        $atts = shortcode_atts(
            array(
                'cat'       => 'events', // default category
                'limit'     => '8', // default items per list
				'button'	=> 'Book Now', // default button text
            ),
            $atts, 'events_list'
        );
		$cat_array = explode(',',$atts['cat']);
        
		// The query
        $today = date('Y-m-d');
        $args = array(
			'type' => 'event',
			'category' => $cat_array,
			'order' => 'ASC',
			'orderby' => 'meta_value',
			'meta_key' => 'tbd_date',
			'tbd_date' => $today,
		);
		$products = wc_get_products( $args );
		$entries_array = array();
		if (sizeof($products) > 0) {
			foreach ($products as $product) {
				$class = 'other';
				$terms = get_the_terms( $product->get_id(), 'product_cat' );
				$class =  end($terms)->slug;
				
				$dates = get_post_meta($product->get_id(), 'tbd_date', true);

				foreach ($dates as $date_string) {
					if (new DateTime() <= new DateTime($date_string)) {
						$entries_array[] = array(
							'date'	 =>  	$date_string,
							'html'	 =>	'<a href="' . $product->get_permalink() . '"><div class="tbd-event-list-row tbd-event-' . $class . '"><div class="tbd-event-list-title">' . $product->get_title() . '</div><div class="tbd-event-list-date">' . $date_string . '</div><div class="tbd-event-list-cta">' . $atts['button'] . '</div></div></a>'
							);
					}
				}
			}
			$html = '<div class="tbd-event-list-container">';
			   
			usort($entries_array, 'tbd_date_compare');
			$num_events = 0;
			foreach ($entries_array as $entry) {
				if ($num_events < $atts['limit']) {
				$html .= $entry['html'];
				}
				$num_events++;
			}
			$html .= '</div>';
			return $html;
		} else {
			return '<p>No upcoming events. <a href="/contact-us/">Get in touch here</a> to be notified when the next courses are available to book.</p>';
		}
    }
    add_shortcode( 'events_list', 'tbd_list_event_products' );
}
function tbd_date_compare($a, $b) {
	$t1 = strtotime($a['date']);
	$t2 = strtotime($b['date']);
	return $t1 - $t2;
}

//Calendar
if( !function_exists('tbd_calendar_event_products') ) {

    function tbd_calendar_event_products( $atts ) {
		
		wp_enqueue_script('tbd_events_cal_main_js');
		wp_enqueue_script('tbd_events_cal_js');
		wp_enqueue_style('tbd_cal_main_css');

        // Shortcode Attributes
        $atts = shortcode_atts(
            array(
                'cat'       => 'events', //default category
				'days_ago'	=> '7'
            ),
            $atts, 'events_list'
        );
		$cat_array = explode(',',$atts['cat']);
        
		// The query
		$time = strtotime(date('Y-m-d') . '-' . $atts['days_ago'] . ' days');
		$after = date('Y-m-d', $time);
        $args = array(
			'type' => 'event',
			'category' => $cat_array,
			'order' => 'ASC',
			'orderby' => 'meta_value',
			'meta_key' => 'tbd_date',
			'tbd_date' => $after
		);
		$products = wc_get_products( $args );
		$entries_array = array();
		if (sizeof($products) > 0) {
			foreach ($products as $product) {
				$class = 'other';
				$terms = get_the_terms( $product->get_id(), 'product_cat' );
				$class =  end($terms)->slug;
				
				$dates = get_post_meta($product->get_id(), 'tbd_date', true);
				foreach ($dates as $date_string) {
					if (new DateTime($after) <= new DateTime($date_string)) {
						$entries_array[] = array(
							'title' => $product->get_title(),
							'start' => $date_string,
							'allDay' => true,
							'link' => $product->get_permalink()
							);
					}
				}
			}
			$cal_events = json_encode($entries_array);
			$html = '<div class="tbd-calendar"></div>';
			$script = 'jQuery(document).ready(function(){

				var events_array = '.$cal_events.';
			
				events_array.forEach(addEvents);
				function addEvents(event) {
					calendar.addEvent({
						title: event.title,
						start: event.start,
						allDay: true,
						url: event.link
					});
				}
					
			});';
			wp_add_inline_script('tbd_events_cal_js', $script );

			return $html;
			
		} else {
			return '<p class="tbd-no-events">No upcoming events.</p>';
		}
    }
    add_shortcode( 'events_calendar', 'tbd_calendar_event_products' );
}
