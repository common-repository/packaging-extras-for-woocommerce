<?php

// Reduce packaging stock levels when an order is placed
function woo_packaging_materials_reduce_packaging_stock( $order_id, $old_status, $new_status, $order ){

    $packaging_stock_reduced = get_post_meta($order_id,'woo_packaging_materials_packaging_stock_reduced',true);

    if ( $packaging_stock_reduced !== 'true' ) {
        if ( $new_status == 'processing' || $new_status == 'completed' ) {
            update_post_meta($order_id,'woo_packaging_materials_packaging_stock_reduced','true');

            // Reduce on a per-product basis
            foreach ( $order->get_items() as $item_id => $item ) {
                if ($item['variation_id'] !== 0) {
                    $packaging_used = get_post_meta($item['variation_id'],'woo_packaging_materials_packaging',true);
                    $amount = get_post_meta($item['variation_id'],'woo_packaging_materials_packaging_used',true);
                    if ( $packaging_used == null || $packaging_used == 0 ) {
                        $packaging_used = get_post_meta($item['product_id'],'woo_packaging_materials_packaging',true);
                        $amount = get_post_meta($item['product_id'],'woo_packaging_materials_packaging_used',true);
                    }
                    if ( $packaging_used !== null && $packaging_used !== 0 ) {
                        $product = wc_get_product($packaging_used);
                        if ($product->get_stock_quantity() > 0) {
                            wc_update_product_stock( $packaging_used, $amount, 'decrease' );
                        }
                        if ($product->get_stock_quantity() < 0) {
                            wc_update_product_stock( $packaging_used, 0, 'set' );
                        }
                    }
                } else {
                    $packaging_used = get_post_meta($item['product_id'],'woo_packaging_materials_packaging',true);
                    $amount = get_post_meta($item['product_id'],'woo_packaging_materials_packaging_used',true);
                    if ( $packaging_used !== null && $packaging_used !== 0 ) {
                        wc_update_product_stock( $packaging_used, $amount, 'decrease' );
                        $product = wc_get_product($packaging_used);
                        if ($product->get_stock_quantity() > 0) {
                            wc_update_product_stock( $packaging_used, $amount, 'decrease' );
                        }
                        if ($product->get_stock_quantity() < 0) {
                            wc_update_product_stock( $packaging_used, 0, 'set' );
                        }
                    }
                }
            }

            // Reduce on a per-order basis
            $args = array(
                'post_type' => 'product',
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'product_type',
                        'field'    => 'slug',
                        'terms'    => 'packaging'
                    )
                ),
                'posts_per_page' => -1,
                'posts_limit' => -1,
            );

            $packaging_materials = new WP_Query( $args );

            while ( $packaging_materials->have_posts() ) : $packaging_materials->the_post();
                global $product;
                $id = $product->get_id();
                if ( metadata_exists('post',$id,'woo_packaging_materials_usage_per_order') ) {
                    $remove_amnt = get_post_meta($id,'woo_packaging_materials_usage_per_order',true);
                    if ( $remove_amnt !== null && $remove_amnt > 0 ) {
                        wc_update_product_stock( $id, $remove_amnt, 'decrease' );
                        $product = wc_get_product($id);
                        if ($product->get_stock_quantity() < 0) {
                            wc_update_product_stock( $id, 0, 'set' );
                        }
                    }
                }
            endwhile;

            wp_reset_query();

        }
    }

}
add_action( 'woocommerce_order_status_changed', 'woo_packaging_materials_reduce_packaging_stock', 20, 4 );
