<?php

// Register the product type
function woo_packaging_materials_register_packaging_product_type () {
	class WC_Product_Packaging extends WC_Product {
		public function __construct( $product ) {
			$this->product_type = 'packaging';
			parent::__construct( $product );
		}
    }
}
add_action( 'init', 'woo_packaging_materials_register_packaging_product_type' );

// Add the packaging product type to the dropdown select
function woo_packaging_materials_add_packaging_product_type ( $type ) {
	$type[ 'packaging' ] = __( 'Packaging & extras' );
	return $type;
}
add_filter( 'product_type_selector', 'woo_packaging_materials_add_packaging_product_type' );

// Hide unneccessary product tabs for the packaging product type and show the "Inventory" tab
function woo_packaging_materials_hide_product_data_tabs( $tabs ) {

    $tabs['inventory']['class'][] = 'show_if_packaging';
    $tabs['shipping']['class'][] = 'hide_if_packaging';
    $tabs['linked_product']['class'][] = 'hide_if_packaging';
    $tabs['advanced']['class'][] = 'hide_if_packaging';

    return $tabs;
}
add_filter( 'woocommerce_product_data_tabs', 'woo_packaging_materials_hide_product_data_tabs', 10, 1 );
