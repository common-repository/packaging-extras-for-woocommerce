(function($){

    // Show the "Manage stock levels" option and hide the "Available for backorder" option for the packaging product type
    function woo_packaging_materials_packaging_fields(){
        if ( $('#product-type').val() == 'packaging' ) {
            $('#postdivrich, #commentsdiv, #postexcerpt, #postimagediv, #woocommerce-product-images, #product_catdiv, #tagsdiv-product_tag, #visibility, #catalog-visibility').hide();
            $('#inventory_product_data ._manage_stock_field').show();
            $('#inventory_product_data ._backorders_field').hide();
            $('#_manage_stock').attr('checked',true);
            $('._manage_stock_field, .stock_status_field').hide();
            $('.stock_fields').show();
        } else {
            $('#postdivrich, #commentsdiv, #postexcerpt, #postimagediv, #woocommerce-product-images, #product_catdiv, #tagsdiv-product_tag, #visibility, #catalog-visibility').show();
        }
    }

    $(document).ready(function(){
        woo_packaging_materials_packaging_fields();
    });

    $(document).on('change','#product-type',function(){
        woo_packaging_materials_packaging_fields();
    });

})(jQuery);