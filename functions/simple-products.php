<?php

// Add the packaging field to the shipping product data tab
function woo_packaging_materials_add_packaging_field_to_shipping_tab() {
    global $product_object;

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
        'id' => 'woo_packaging_materials_packaging',
        'name' => 'woo_packaging_materials_packaging',
        'label' => __( 'Packaging & extras', 'woocommerce' ),
        'value' => get_post_meta( $product_object->get_id(), 'woo_packaging_materials_packaging', true ),
        'options' => $packaging_options,
        'wrapper_class' => 'show_if_simple show_if_variable woo_packaging_materials_packaging_field_wrapper',
        'desc_tip' => true,
        'description' => __( 'Select the packaging materials used for this product', 'woocommerce' ),
    ) );

    $packaging_amnt_used = get_post_meta( $product_object->get_id(), 'woo_packaging_materials_packaging_used', true );
    if ( empty($packaging_amnt_used) ) {
        $packaging_amnt_used = 0;
    }

    woocommerce_wp_text_input( array(
        'id' => 'woo_packaging_materials_packaging_used',
        'name' => 'woo_packaging_materials_packaging_used',
        'type' => 'number',
        'wrapper_class' => 'show_if_simple show_if_variable woo_packaging_materials_packaging_used',
        'label'  => __( 'Packaging/extras usage', 'woocommerce' ),
        'desc_tip' => true,
        'description' => __( 'Set the amount of packaging materials used when this product is shipped', 'woocommerce' ),
        'value' => $packaging_amnt_used
    ) );  ?>

<p><a href="https://plugins.fraxinus.studio/plugin/woocommerce-packaging-extras/" target="_blank">Upgrade to Packaging & Extras Pro to select multiple packaging/extras, and other useful features!</a></p>

<?php }
add_action( 'woocommerce_product_options_dimensions', 'woo_packaging_materials_add_packaging_field_to_shipping_tab', 10);

// Save the values
function woo_packaging_materials_save_product_packaging_fields( $post_id ) {
    $product_packaging = isset( $_POST['woo_packaging_materials_packaging'] ) ? wc_clean( $_POST['woo_packaging_materials_packaging'] ) : '';
    update_post_meta( $post_id, 'woo_packaging_materials_packaging', $product_packaging );
    $product_packaging_used = isset( $_POST['woo_packaging_materials_packaging_used'] ) ? wc_clean( $_POST['woo_packaging_materials_packaging_used'] ) : '';
    update_post_meta( $post_id, 'woo_packaging_materials_packaging_used', $product_packaging_used );
}
add_action( 'woocommerce_process_product_meta', 'woo_packaging_materials_save_product_packaging_fields' );

// "Usage per order" product data tab
function woo_packaging_materials_usage_tab($tabs) {
	$tabs['packaging_usage_per_order'] = [
		'label' => __('Usage per order', 'woocommerce'),
		'target' => 'woo_packaging_materials_usage_per_order',
		'class' => ['show_if_packaging woo_packaging_materials_usage_tab'],
		'priority' => 25
	];
	return $tabs;
}
add_filter('woocommerce_product_data_tabs', 'woo_packaging_materials_usage_tab');


function woo_packaging_materials_usage_tab_content() {
    global $product_object; ?>
    <div id="woo_packaging_materials_usage_per_order" class="panel woocommerce_options_panel hidden">

        <?php

        $used = get_post_meta( $product_object->get_id(), 'woo_packaging_materials_usage_per_order', true );
        if ( empty($used) ) {
            $used = 0;
        }

        woocommerce_wp_text_input([
            'id' => 'woo_packaging_materials_usage_per_order',
            'label' => __('Amount used','woocommerce'),
            'desc_tip' => true,
            'description' => __('Set how much stock of this item should be removed when an order is placed', 'woocommerce'),
            'value' => $used,
            'type' => 'number',
            'class' => 'short'
        ]); ?>

        <p><a href="https://plugins.fraxinus.studio/plugin/woocommerce-packaging-extras/" target="_blank">Upgrade to Packaging & Extras Pro for conditional usage logic and other useful features!</a></p>

    </div>
<?php }
add_action('woocommerce_product_data_panels', 'woo_packaging_materials_usage_tab_content');

// Save the values
function woo_packaging_materials_save_packaging_per_order_fields( $post_id ) {
    $packaging_per_order = isset( $_POST['woo_packaging_materials_usage_per_order'] ) ? wc_clean( $_POST['woo_packaging_materials_usage_per_order'] ) : '';
    update_post_meta( $post_id, 'woo_packaging_materials_usage_per_order', $packaging_per_order );
}
add_action( 'woocommerce_process_product_meta', 'woo_packaging_materials_save_packaging_per_order_fields' );