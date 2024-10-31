<?php

// Add the packaging field to the product variations
function woo_packaging_materials_add_packaging_field_to_variations( $loop, $variation_data, $variation ) {

    $packaging_options = array();
    $packaging_options[0] = 'Select packaging/extras used for this product';
    $args = array(
        'type' => 'packaging',
    );
    $products = wc_get_products( $args );
    foreach ( $products as $product ) {
        $packaging_options[ $product->id ] = $product->name;
    }

    woocommerce_wp_select( array(
        'id' => 'woo_packaging_materials_packaging_' . $loop,
        'name' => 'woo_packaging_materials_packaging_' . $loop,
        'label' => __( 'Packaging & extras', 'woocommerce' ),
        'value' => get_post_meta( $variation->ID, 'woo_packaging_materials_packaging', true ),
        'options' => $packaging_options,
        'wrapper_class' => 'form-row form-row-full hide_if_variation_virtual woo_packaging_materials_packaging_field_wrapper',
        'desc_tip' => true,
        'description' => __( 'Select the packaging materials used for this variation', 'woocommerce' ),
    ) );

    $packaging_amnt_used = get_post_meta( $variation->ID, 'woo_packaging_materials_packaging_used', true );
    if ( empty($packaging_amnt_used) ) {
        $packaging_amnt_used = 0;
    }

    woocommerce_wp_text_input( array(
        'id' => 'woo_packaging_materials_packaging_used_' . $loop,
        'name' => 'woo_packaging_materials_packaging_used_' . $loop,
        'type' => 'number',
        'wrapper_class' => 'form-row form-row-full hide_if_variation_virtual woo_packaging_materials_packaging_used',
        'label' => __( 'Packaging & extras usage', 'woocommerce' ),
        'desc_tip' => true,
        'description' => __( 'Set the amount of packaging materials used when this variation is shipped', 'woocommerce' ),
        'value' => $packaging_amnt_used,
    ) ); ?>

<p><a href="https://plugins.fraxinus.studio/plugin/woocommerce-packaging-extras/" target="_blank">Upgrade to Packaging & Extras Pro to select multiple packaging/extras, and other useful features!</a></p>

<?php }
add_action( 'woocommerce_variation_options_dimensions', 'woo_packaging_materials_add_packaging_field_to_variations', 10, 3 );

// Save the packaging field value for variable products
function woo_packaging_materials_save_packaging_field_to_variations( $variation_id, $i ) {
   $packaging = isset( $_POST['woo_packaging_materials_packaging_' . $i] ) ? wc_clean( $_POST['woo_packaging_materials_packaging_' . $i] ) : '';
   update_post_meta( $variation_id, 'woo_packaging_materials_packaging', $packaging );
   $packaging_used = isset( $_POST['woo_packaging_materials_packaging_used_' . $i] ) ? wc_clean( $_POST['woo_packaging_materials_packaging_used_' . $i] ) : '';
   update_post_meta( $variation_id, 'woo_packaging_materials_packaging_used', $packaging_used );
}
add_action( 'woocommerce_save_product_variation', 'woo_packaging_materials_save_packaging_field_to_variations', 10, 2 );

