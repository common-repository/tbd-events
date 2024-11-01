<?php
//Custom event product type
add_filter( 'product_type_selector', 'tbd_event_product_type' );
 
function tbd_event_product_type( $types ){
    $types[ 'event' ] = 'Event';
    return $types;
}
 
// --------------------------
// #2 Add New Product Type Class
 
add_action( 'init', 'tbd_event_create_product_type' );
 
function tbd_event_create_product_type(){
    class WC_Product_TBD_Event extends WC_Product {
      public function get_type() {
         return 'event';
      }
    }
}
 
// --------------------------
// #3 Load New Product Type Class
 
add_filter( 'woocommerce_product_class', 'tbd_event_woocommerce_product_class', 10, 2 );
 
function tbd_event_woocommerce_product_class( $classname, $product_type ) {
    if ( $product_type == 'event' ) {
        $classname = 'WC_Product_TBD_Event';
    }
    return $classname;
}
/**
 * Add a custom product tab.
 */
function tbd_event_details_tab( $tabs) {

	$tabs['tbd_event'] = array(
		'label'		=> __( 'Event Details', 'woocommerce' ),
		'target'	=> 'event_options',
		'class'		=> array( 'show_if_event' ),
		'priority'	=> 15
	);

	return $tabs;

}
add_filter( 'woocommerce_product_data_tabs', 'tbd_event_details_tab' );

//single or recurring?
function tbd_add_event_product_option( $product_type_options ) {

	$product_type_options['tbd_recurring_event'] = array(
		'id'            => '_tbd_recurring_event',
		'wrapper_class' => 'show_if_event',
		'label'         => __( 'Recurring', 'woocommerce' ),
		'description'   => __( 'Recurring event happening regularly.', 'woocommerce' ),
		'default'       => 'no'
	);

	return $product_type_options;

}
add_filter( 'product_type_options', 'tbd_add_event_product_option' );

//Calendar Icon
function tbd_event_tab_icon_style() {

	?><style>
		#woocommerce-product-data ul.wc-tabs li.tbd_event_options a:before { font-family: Dashicons; content: '\f508' !important; }
	</style><?php

}
add_action( 'admin_head', 'tbd_event_tab_icon_style' );

/**
 * Contents of the event options product tab.
 */
function tbd_event_options_product_tab_content() {

	global $post;
	wp_enqueue_script('jquery-ui-datepicker');
	wp_register_style('jquery-ui-style-css', plugin_dir_path(__FILE__) . 'js/jquery-ui.css');
	wp_enqueue_style('jquery-ui-style-css');
	
	?><div id='event_options' class='panel woocommerce_options_panel'><?php
		$tbd_dates = get_post_meta( get_the_ID(), 'tbd_date', true );
		//Host of event
		$hosts = get_option('tbd_host_array');
		if (is_array($hosts) && count($hosts) > 0) {
			$host_names = array('' => 'Choose a host');
			foreach ($hosts as $host) {$host_names += [$host['name'] => $host['name']];}
			if (count($hosts) > 0) {
				
				echo '<div class="options_group event_hosts">';
					woocommerce_wp_select( array( // Text Field type
					'id'          => 'tbd_event_host',
					'label'       => __( 'Event Host', 'tbd' ),
					'description' => __( 'Optional. Who is hosting the event?', 'tbd' ),
					'desc_tip'    => true,
					'options'     => $host_names,
				) );
				echo '</div>';
				
			}
		} else {
			echo '<div class="options_group event_hosts"><p>No hosts found. Please enter host information on the <a href="' . admin_url("admin.php?page=tbd-options") . '">Hosts page</a>.</p></div>';
		}
		//Date of events
		echo '<div class="options_group first_date">';
		woocommerce_wp_text_input( array(
			'id'                => 'tbd_date[0]',
			'class'				=> 'custom-date',
			'type'				=> 'date',
			'value'             => is_array($tbd_dates) ? $tbd_dates[0] : $tbd_dates,
			'label'             => 'Date of event',
			'description'       => __('Enter the date of the event.', 'tbd'),
			'desc_tip' => true,
		));
		echo '</div>';
		$display = 'none';
		get_post_meta(get_the_ID(), '_tbd_recurring_event', true) == 'yes' ? $display = "block" : $display = "none";
		echo '<div class="options_group recurring_events dates" style="display: ' . esc_attr($display) . '">';
		$counter = 1;
		if (is_array($tbd_dates) && count($tbd_dates) > 1) {
			foreach (array_slice($tbd_dates,1) as $date) {
				woocommerce_wp_text_input( array(
							'id'                => 'tbd_date['.$counter.']',
							'class'				=> 'custom-date',
							'type'				=> 'date',
							'value'             => $date,
							'label'             => 'Date of event',
							'description'       => __('Enter the date of the event.', 'tbd'),
							'desc_tip' => true,
						) );
						$counter++;
			}
		}
		echo '<button type="button" id="date-add">Add New Date</button></div>';
		echo '</div>';
		?>
		

	</div><?php
	

}

add_filter( 'woocommerce_product_data_panels', 'tbd_event_options_product_tab_content' ); // WC 2.6 and up

//Show pricing tab
function tbd_event_product_js() {

    if ('product' != get_post_type()) :
        return;
    endif;

    ?>
    <script type='text/javascript'>
        jQuery(document).ready(function () {
            jQuery('.product_data_tabs .general_tab').addClass('show_if_event show_if_simple show_if_variable').show();
            jQuery('#general_product_data .pricing').addClass('show_if_event show_if_simple show_if_variable').show();
			jQuery('#_tbd_recurring_event').on('click' , function(){
				if (jQuery('#_tbd_recurring_event').prop('checked')) {
					jQuery('.recurring_events').show();
				} else {
					jQuery('.recurring_events').hide();
				}
			});
			var counter = jQuery('.custom-date').length - 1;
			console.log(counter);
			jQuery('.dates .form-field').each(function() {
				jQuery(this).append('<button type="button" class="date-remove">Remove</button>');
			});
			jQuery(document).on('click', '.date-remove' , function() {
				jQuery(this).parent().remove();
				counter = 0;
				jQuery('.dates .form-field input, .first_date .form-field input').each(function() {
					jQuery(this).attr('id', "tbd_date["+counter+"]");
					jQuery(this).attr('name', "tbd_date["+counter+"]");
					counter++;
				});
				counter--;
			});
			jQuery('#date-add').on('click', function() {
				counter++;
				jQuery(this).before('<p class="form-field tbd_date['+counter+']_field "><label for="tbd_date['+counter+']">Date of event</label><span class="woocommerce-help-tip"></span><input type="date" class="custom-date" style="" name="tbd_date['+counter+']" id="tbd_date['+counter+']" value="" placeholder=""><button type="button" class="date-remove">Remove</button></p>');
			});
        });
    </script>
    <?php

}
add_action('admin_footer', 'tbd_event_product_js');


add_action( 'woocommerce_process_product_meta', 'tbd_save_product_data', 10, 2 );
function tbd_save_product_data( $id, $post ){
 
	if( !empty( $_POST['tbd_date'] ) ) {
		update_post_meta( $id, 'tbd_date', wc_clean($_POST['tbd_date'] ));
	}
	$is_recurring = isset($_POST['_tbd_recurring_event']) ? 'yes' : 'no';
	update_post_meta( $id, '_tbd_recurring_event', $is_recurring );
	
	if( !empty( $_POST['tbd_event_host'] ) ) {
		update_post_meta( $id, 'tbd_event_host', wc_clean($_POST['tbd_event_host'] ));
	}
}