<?php

function woo_packaging_materials_overview_page_content() { 

    $lowstockcount = 0;
    $instockcount = 0;
    $nostockcount = 0;

    $args = array(
        'post_type' => 'product',
        'product_type' => 'packaging',
        'posts_per_page' => -1,
        'posts_limit' => -1,
    );

    $packaging_materials = new WP_Query( $args ); 

    while ( $packaging_materials->have_posts() ) : $packaging_materials->the_post();
        global $product;

        if ( $product->get_low_stock_amount() ) {
            $stock_threshold = $product->get_low_stock_amount();
        } else {
            $stock_threshold = get_option( 'woocommerce_notify_low_stock_amount' );
        }

        if ($product->get_stock_quantity() <= $stock_threshold) {
            $lowstockcount++;
        }

        if ( $product->is_in_stock() ) {
            $instockcount++;
        } else {
            $nostockcount++;
        }
    endwhile;

    wp_reset_query(); ?>

    <div class="wrap">
        <h1><?php _e('Packaging & Extras', 'woocommerce'); ?></h1>
        <div id="dashboard-widgets" class="postbox-container">
            <div id="woocommerce-packaging-overview-glance" class="postbox">
                <div class="postbox-header">
                    <h2><?php _e('At a glance', 'woocommerce'); ?></h2>
                </div>
                <div class="inside">
                    <div class="main">
                        <ul>
                            <li class="product-count">
                                <a href="<?php echo admin_url( 'edit.php?s&post_status=all&post_type=product&action=-1&product_cat&product_type=packaging&stock_status&filter_action=Filter&paged=1&action2=-1' ); ?>">
                                    <?php _e($packaging_materials->post_count . ' packaging & extras products', 'woocommerce'); ?>
                                </a>
                            </li>
                            <li class="nostock-count">
                                <a href="<?php echo admin_url( 'edit.php?s&post_status=all&post_type=product&action=-1&product_cat&product_type=packaging&stock_status=outofstock&filter_action=Filter&paged=1&action2=-1' ); ?>">
                                    <?php _e($nostockcount . ' out of stock', 'woocommerce'); ?>
                                </a>
                            </li>
                            <li class="instock-count">
                                <a href="<?php echo admin_url( 'edit.php?s&post_status=all&post_type=product&action=-1&product_cat&product_type=packaging&stock_status=instock&filter_action=Filter&paged=1&action2=-1' ); ?>">
                                    <?php _e($instockcount . ' in stock', 'woocommerce'); ?>
                                </a>
                            </li>
                            <li class="lowstock-count">
                                <a href="<?php echo admin_url( 'edit.php?s&post_status=all&post_type=product&action=-1&product_cat&product_type=packaging&stock_status&filter_action=Filter&paged=1&action2=-1' ); ?>">
                                    <?php _e($lowstockcount . ' low stock', 'woocommerce'); ?>
                                </a>
                            </li>
                        </ul>
                        <p class="nomargin">
                            <?php
                                $plugin_version = null;
                                $plugin_basename = plugin_basename(__FILE__);
                                $plugin_slug = explode('/', $plugin_basename)[0];
                                
                                $active_plugins = get_option('active_plugins');
                                
                                foreach ($active_plugins as $plugin) {
                                    if (strpos($plugin, $plugin_slug) !== false) {
                                        $plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/' . $plugin);
                                        $plugin_version = $plugin_data['Version'];
                                        $plugin_name = $plugin_data['Name'];
                                        break;
                                    }
                                }
                                
                                if ($plugin_version) {
                                    _e($plugin_name . ' version ' . $plugin_version . ' by <a href="https://fraxinus.studio" target="_blank">Fraxinus Studio</a>','woocommerce');
                                }
                            ?>
                        </p>
                    </div>
                </div>
            </div>
            <div id="woocommerce-packaging-overview-links" class="postbox">
                <div class="postbox-header">
                    <h2>Useful links</h2>
                </div>
                <div class="inside">
                    <ul>
                        <li class="support-link">
                            <a href="#" target="_blank">
                                <?php _e('Support', 'woocommerce'); ?>
                            </a>
                        </li>
                        <li class="review-link">
                            <a href="#" target="_blank">
                                <?php _e('Help us out with a 5 star review', 'woocommerce'); ?>
                            </a>
                        </li>
                        <li class="features-link">
                            <a href="https://plugins.fraxinus.studio/plugin/woocommerce-packaging-extras/" target="_blank">
                                <?php _e('Check out the pro features', 'woocommerce'); ?>
                            </a>
                        </li>
                        <li class="upgrade-link">
                            <a href="https://fraxinus-studio.lemonsqueezy.com/checkout/buy/b75dd237-43c4-465f-aebe-9ef2459cd04b?embed=1&media=0" class="lemonsqueezy-button">
                                <?php _e('Upgrade to the pro version', 'woocommerce'); ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div id="woocommerce-packaging-upgrade-msg" class="postbox">
                <div class="postbox-header">
                    <h2>Packaging & Extras Pro</h2>
                </div>
                <div class="inside">
                    <p><a href="https://fraxinus-studio.lemonsqueezy.com/checkout/buy/b75dd237-43c4-465f-aebe-9ef2459cd04b?embed=1&media=0" class="lemonsqueezy-button button button-primary" style="float: right;">Upgrade</a><a href="https://fraxinus-studio.lemonsqueezy.com/checkout/buy/b75dd237-43c4-465f-aebe-9ef2459cd04b?embed=1&media=0" class="lemonsqueezy-button">Go pro</a> for extra features and functionality, including:</p>
                    <ul>
                        <li>Conditional logic for usage per order</li>
                        <li>Multiple items per product/variation</li>
                        <li>Stock overview with downloadable reports</li>
                    </ul>
                </div>
            </div>
        </div>
        <?php
            

            while ( $packaging_materials->have_posts() ) : $packaging_materials->the_post();
                global $product;
                
            endwhile;

            wp_reset_query();

        ?>
    </div>
    
<?php }