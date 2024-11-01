<?php

/* Product page and cart/checkout functionality */


//Add add to cart button
add_action( "woocommerce_event_add_to_cart", function() {
    do_action( 'woocommerce_simple_add_to_cart' );
});


//Add information to product page
add_filter( 'woocommerce_product_tabs', 'tbd_new_product_tab' );
function tbd_new_product_tab( $tabs ) {
	global $product;
	$attributes = get_post_meta($product->get_id());
	$date = $product->get_meta('tbd_date');
	$recurring = $product->get_meta('_tbd_recurring_event');
	if (!empty($date)) {
		
		$title = (count($date) > 1 && $recurring == 'yes') ? 'Dates' : 'Date';
		// Adds the new tab
		$tabs['date_tab'] = array(
			'title' 	=> __( $title, 'tbd' ),
			'priority' 	=> 50,
			'callback' 	=> 'tbd_event_tab_content'
		);
	}
	$host_name = $product->get_meta('tbd_event_host');
	$host_array = get_option('tbd_host_array');
	if (is_array($host_array) && count($host_array) > 0) {
		$key = array_search($host_name, array_column($host_array, 'name'));
		$host = $host_array[$key];
	} else { $host = $host_array; }
	if (!empty($host) && $host_name != 'tbd-none') {		
		$title = 'Host Details';
		// Adds the new tab
		$tabs['host_tab'] = array(
			'title' 	=> __( $title, 'tbd' ),
			'priority' 	=> 50,
			'callback' 	=> 'tbd_host_tab_content'
		);
	}
	return $tabs;
}
function tbd_event_tab_content() {

	global $product;
	$date = $product->get_meta('tbd_date');
	$recurring = $product->get_meta('_tbd_recurring_event');
	if ($recurring == 'yes' && count($date) > 1){
		echo '<h2>Event Dates</h2>';
		foreach ($date as $event) {
			echo '<div class="tbd_date_listing">' . wp_kses_post($event) . '</div>';
		}
	} else {
		echo '<h2>Date of Event</h2>';
		echo '<div class="tbd_date_listing">' . wp_kses_post($date[0]) . '</div>';
	}
}
function tbd_host_tab_content() {
	wp_enqueue_style( 'fontawesome' );
	global $product;
	$host_name = $product->get_meta('tbd_event_host');
	$host_array = get_option('tbd_host_array');
	if (is_array($host_array) && count($host_array) > 0) {
		$key = array_search($host_name, array_column($host_array, 'name'));
		$host = $host_array[$key];
	} else { $host = $host_array; }
	echo '<h2>Host Information</h2>';
	echo '<div class="tbd-host-info">';
		if (isset($host['pic'])) {echo '<img class="tbd-host-pic" src="' . wp_kses_post($host['pic']) . '" width=300 />';}
		if (isset($host['name'])) {echo '<h3 class="tbd-host-name">' . wp_kses_post($host['name']) . '</h3>';}
		if (isset($host['desc'])) {echo '<div class="tbd-host-desc">' . wpautop($host['desc']) . '</div>';}
		echo '<div class="tbd-host-details">';
			if (isset($host['phone']) && $host['phone'] != '') {echo '<a href="tel:' . esc_html($host['phone']) . '"><i class="fas fa-phone-alt"></i> ' . wp_kses_post($host['phone']) . '</a><br />';}
			if (isset($host['email']) && $host['email'] != '') {echo '<a href="mailto:' . esc_html($host['email']) . '"><i class="fas fa-at"></i> ' . wp_kses_post($host['email']) . '</a><br />';}
			if (isset($host['site']) && $host['site'] != '') {echo '<a href="' . esc_url($host['site']) . '"><i class="fas fa-globe-europe"></i> ' . wp_kses_post($host['site']) . '</a><br />';}
		echo '</div>';
	echo '</div>';
}
// Adding Choose Date feature
add_action( 'woocommerce_before_add_to_cart_button', 'tbd_event_date_hidden_field' );
function tbd_event_date_hidden_field() {
	global $product;
	$dates = $product->get_meta('tbd_date');
    $recurring = $product->get_meta('_tbd_recurring_event');
    echo '<input type="hidden" name="tbd_chosen_date" id="tbd_chosen_date" value="'. esc_attr($dates[0]) .'">';
	if ($recurring == 'yes' && count($dates) > 1) {
		echo '<label for="tbd_date_select">Choose a date: </label><select id="tbd_date_select" style="height: 2.5em;padding: .3em;display: block;">';
			foreach ($dates as $date) {
				echo '<option value="' . esc_html($date) .'">' . esc_html($date) . '</option>';
			}
		echo '</select>';
	} else {
		echo '<p>Date: ' . wp_kses_post($dates[0]) . '</p>';
	}
	?>
	<script>
	jQuery(document).ready(function($){
		$('#tbd_date_select').on('change', function() {
			
			var newVal = $(this).val();
			$('#tbd_chosen_date').val(newVal);
			console.log(newVal);			
		});		
	});
	</script>
	<?php

}
add_filter('woocommerce_add_cart_item_data', 'tbd_add_custom_field_data', 10, 3 );
function tbd_add_custom_field_data( $cart_item_data, $product_id, $variation_id ) {
    if ( isset($_POST['tbd_chosen_date']) && ! empty($_POST['tbd_chosen_date']) ) {
        $cart_item_data['date'] = wc_clean($_POST['tbd_chosen_date']);
    }
    return  $cart_item_data;
}
add_action( 'woocommerce_checkout_create_order_line_item', 'tbd_save_custom_order_item_meta_data' , 10, 4 );
function tbd_save_custom_order_item_meta_data( $item, $cart_item_key, $values, $order ) {
    if ( isset($values['date']) ) {
        $item->add_meta_data( __("Date"), $values['date'] );
    }
}
// Display on cart & checkout pages
function tbd_date_in_cart_display( $cart_data, $cart_item ) {
    if ( isset($cart_item['date']) ) {
        $cart_data[] = array( "name" => __("Date"), "value" => $cart_item['date'] );
    }
    return $cart_data;
}
add_filter( 'woocommerce_get_item_data', 'tbd_date_in_cart_display', 10, 2 );

// Display item data everywhere on orders and email notifications 
function tbd_date_in_order_display( $item, $cart_item_key, $values, $order ) {
    if ( isset($values['date']) ) {
        $item->add_meta_data( __("Date"), $values['date'] );
    }
}
add_action( 'woocommerce_checkout_create_order_line_item', 'tbd_date_in_order_display', 10, 4 );