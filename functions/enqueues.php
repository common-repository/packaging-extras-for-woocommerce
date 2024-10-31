<?php

// Enqueue scripts and styles
function woo_packaging_materials_admin_enqueues(){
	if (get_current_screen()->id == 'product') {
        wp_enqueue_script( 'woo_packaging_materials_shipping', plugin_dir_url(__FILE__) . '../js/shipping-panels.js' );
		wp_enqueue_style( 'woo_packaging_materials_product_admin', plugin_dir_url(__FILE__) . '../css/product-admin.css' );
	} else if (get_current_screen()->id == 'toplevel_page_packaging-materials') {
		wp_enqueue_style( 'woo_packaging_materials_overview', plugin_dir_url(__FILE__) . '../css/overview.css' );
	}
}
add_action( 'admin_enqueue_scripts', 'woo_packaging_materials_admin_enqueues' );