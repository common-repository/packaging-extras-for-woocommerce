<?php

/*
 * Plugin Name:       Packaging & Extras for WooCommerce
 * Plugin URI:        https://plugins.fraxinus.studio/plugin/woocommerce-packaging-extras/
 * Description:       Manage stock of packaging materials and extra items like flyers, stickers, free gifts, etc, which you might include in your order shipments. <a href="https://plugins.fraxinus.studio/plugin/woocommerce-packaging-extras/" target="_blank">Go pro for more features & functionality</a>.
 * Version:           1.1.2
 * Requires at least: 5.2
 * Requires PHP:      7.0
 * Author:            Fraxinus Studio
 * Author URI:        https://fraxinus.studio/
 * Text Domain:       woo-packaging-extras
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

@include 'functions/product-type.php';
@include 'functions/simple-products.php';
@include 'functions/variable-products.php';
@include 'functions/enqueues.php';
@include 'functions/reduce-packaging-stock.php';
@include 'functions/hide-packaging.php';
@include 'functions/admin-menu.php';

// Add links to plugin screen
function woo_pmm_plugin_meta_links( $links, $file ) {    
    if ( strpos( $file, basename(__FILE__) ) ) {
		$links[] = '<a href="https://fraxinus-studio.lemonsqueezy.com/checkout/buy/b75dd237-43c4-465f-aebe-9ef2459cd04b?embed=1&media=0" class="lemonsqueezy-button">' . __('Upgrade','woocommerce') . '</a>';
	}
 
	return $links;
}
add_filter( 'plugin_row_meta', 'woo_pmm_plugin_meta_links', 10, 2 );

add_action('admin_enqueue_scripts', function(){
	wp_enqueue_script('lemonsqueezy', 'https://assets.lemonsqueezy.com/lemon.js');
});