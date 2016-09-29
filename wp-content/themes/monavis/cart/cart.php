<?php $woo = 'woocommerce'; ?><?php if(sizeof(WC()->session->get( 'wc_notices', array())) > 0): ?><div class="col-md-12 cart-alert"><div role="alert" class="alert alert-info alert-dismissible fade in"><button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true">×</span></button><?php wc_print_notices(); ?></div></div><?php endif; ?><?php do_action( 'woocommerce_before_cart' ); ?><form action="<?php print esc_url( WC()->cart->get_cart_url() ); ?>" method="post" class="cart-form"><div class="col-md-12"><?php do_action( 'woocommerce_before_cart_table' ); ?><table class="shop_table cart table table-hover"><thead><tr><th class="product-remove">&nbsp;</th><th class="product-thumbnail">&nbsp;</th><th class="product-name"><?php _e('Product', $woo); ?></th><th class="product-price"><?php _e('Price', $woo); ?></th><th class="product-quantity"><?php _e('Quantity', $woo); ?></th><th class="product-subtotal"><?php _e('Total', $woo); ?></th></tr></thead><tbody><?php do_action( 'woocommerce_before_cart_contents' ); ?><?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ): ?><?php $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key ); ?><?php $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key ); ?><?php if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ); ?><tr class="<?php print( apply_filters( "woocommerce_cart_item_class", "cart_item", $cart_item, $cart_item_key ) ); ?>"><td class="product-remove"><?php print apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="remove btn btn-danger" title="%s"><i class="fa fa-times"></i></a>', esc_url( WC()->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', $woo ) ), $cart_item_key ); ?></td><td class="product-thumbnail"><?php $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key ); ?><?php if ( ! $_product->is_visible() ): ?><?php else: ?><?php $image_id = $_product->get_image_id(); ?><?php if(!empty($image_id)): ?><?php $image_src = getImage('articles', '100x80', $image_id); ?><a href="esc_url( $_product->get_permalink( $cart_item ) );"><img src="<?php print($image_src); ?>" alt="<?php print($_product->get_title()); ?>" class="img-responsive"/></a><?php endif; ?><?php endif; ?></td><td class="product-name"><?php if ( ! $_product->is_visible() ): ?><?php print apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;'; ?><?php else: ?><?php print apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s </a>', esc_url( $_product->get_permalink( $cart_item ) ), $_product->get_title() ), $cart_item, $cart_item_key ); ?><?php endif; ?><?php print WC()->cart->get_item_data( $cart_item ); ?><?php if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ): ?><?php print '<p class="backorder_notification">' . esc_html__( 'Available on backorder', $woo ) . '</p>'; ?><?php endif; ?></td><td class="product-price"><?php print apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); ?></td><td class="product-quantity"><?php if ( $_product->is_sold_individually() ): ?><?php $product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key ); ?><?php else: ?><div class="input-group"><span class="input-group-btn"><button type="button" data-type="minus" data-field="<?php print('cart['.$cart_item_key.'][qty]'); ?>" class="btn btn-danger btn-number"><span class="glyphicon glyphicon-minus"></span></button></span><?php $product_quantity = woocommerce_quantity_input( array( 'input_name'  => "cart[{$cart_item_key}][qty]", 'input_value' => $cart_item['quantity'], 'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(), 'min_value'   => '0'), $_product, false ); ?><?php print apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key ); ?><span class="input-group-btn"><button type="button" data-type="plus" data-field="<?php print('cart['.$cart_item_key.'][qty]'); ?>" class="btn btn-success btn-number"><span class="glyphicon glyphicon-plus"></span></button></span></div><?php endif; ?></td><td class="product-subtotal"><?php print apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?></td></tr><?php do_action( 'woocommerce_cart_contents' ); ?><?php endforeach; ?></tbody></table></div><div class="col-md-12"><div class="row"><?php if ( WC()->cart->coupons_enabled() ): ?><div class="col-md-9 coupon"><div class="input-group"><label for="coupon_code" class="input-group-addon"><?php _e( 'Coupon', 'woocommerce' ); ?></label><input id="coupon_code" type="text" name="coupon_code" value="" placeholder="<?php _e( "Coupon code", $woo ); ?>" class="input-text form-control"/><span class="input-group-btn"><input type="submit" name="apply_coupon" value="<?php _e( "Apply Coupon", $woo); ?>" class="button btn btn-info"/><?php do_action( 'woocommerce_cart_coupon' ); ?></span></div></div><?php endif; ?><div class="col-md-3"><div class="btn-container"><input type="submit" name="update_cart" value="<?php _e( "Update Cart", $woo ); ?>" class="button update-btn btn btn-info"/><?php do_action( 'woocommerce_cart_actions' ); ?><?php wp_nonce_field( 'woocommerce-cart' ); ?></div></div></div></div><?php do_action( 'woocommerce_after_cart_contents' ); ?><?php do_action( 'woocommerce_after_cart_table' ); ?></form><div class="col-md-12 cart-bottom"><div class="cart-collaterals"><?php do_action( 'woocommerce_cart_collaterals' ); ?></div></div><?php do_action( 'woocommerce_after_cart' ); ?>