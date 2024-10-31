<?php

// Add the top-level menu page
function woo_packaging_materials_menu_pages() {

	add_menu_page(
		__( 'Packaging & Extras', 'woocommerce' ),
		__( 'Packaging & Extras', 'woocommerce' ),
		'manage_options',
		'packaging-materials',
		'woo_packaging_materials_overview_page_content',
		'dashicons-products',
		57
	);

    add_submenu_page(
        'packaging-materials',
        __( 'Packaging & Extras', 'woocommerce' ),
        __( 'Overview', 'woocommerce' ),
        'manage_options',
        'packaging-materials',
        'woo_packaging_materials_overview_page_content'
    );

}
add_action( 'admin_menu', 'woo_packaging_materials_menu_pages' );

@include 'admin-menu/overview.php';