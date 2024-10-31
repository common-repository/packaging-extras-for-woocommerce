<?php

// Hide all packaging products from the store frontend
function woo_packaging_materials_hide_packaging_products( $query ) {
    if ( ! is_admin() && $query->is_main_query() ) {
       $tax_query = array(
            array(
                'taxonomy' => 'product_type',
                'field'    => 'slug',
                'terms'    => 'packaging',
                'operator' => 'NOT IN'
            )
       );
       $query->set( 'tax_query', $tax_query );
    }
 }
 add_action( 'pre_get_posts', 'woo_packaging_materials_hide_packaging_products' );
 