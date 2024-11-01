<?php
  /*
  Plugin name: TBD Events
  Plugin URI: https://thinkbydesign.co.uk/blog/create-events-in-woocommerce
  Description: Create events as products in WooCommerce, with calendars and lists.
  Author: Daniel Lewis
  Author URI: https://thinkbydesign.co.uk
  Version: 1.0.0
  */
 /**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
     require_once plugin_dir_path(__FILE__) . 'includes/tbd-events-functions.php';
}

  
?>