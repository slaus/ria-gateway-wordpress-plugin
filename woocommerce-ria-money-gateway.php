<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
Plugin Name: WooCommerce Ria Money Gateway
Plugin URI: https://wordpress.org/plugins/woo-ria-money-gateway/
Description: Adds Ria Money Gateway to WooCommerce e-commerce plugin
Version: 1.1.1
Author: Vyacheslav Bantysh
Author URI: http://site404.in.ua
*/

// Include our Gateway Class and register Payment Gateway with WooCommerce
add_action( 'plugins_loaded', 'woo_ria_init', 0 );
function woo_ria_init() {
	// If the parent WC_Payment_Gateway class doesn't exist
	// it means WooCommerce is not installed on the site
	// so do nothing
	if ( ! class_exists( 'WC_Payment_Gateway' ) ) return;
	
	// If we made it this far, then include our Gateway Class
	include_once( 'ria-money.php' );

	// Now that we have successfully included our class,
	// Lets add it too WooCommerce
	add_filter( 'woocommerce_payment_gateways', 'woo_add_ria_gateway' );
	function woo_add_ria_gateway( $methods ) {
		$methods[] = 'WC_Gateway_Ria_Money';
		return $methods;
	}
}

// Add custom action links
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'slaus_gateway_ria_money_action_links' );
function slaus_gateway_ria_money_action_links( $links ) {
	$plugin_links = array(
		'<a href="' . admin_url( 'admin.php?page=wc-settings&tab=checkout&section=ria' ) . '">' . __( 'Settings', 'woocommerce' ) . '</a>',
	);

	// Merge our new link with the default ones
	return array_merge( $plugin_links, $links );	
}

?>