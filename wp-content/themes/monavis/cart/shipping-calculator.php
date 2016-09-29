<?php $woo = 'woocommerce'; ?><?php if ( get_option( 'woocommerce_enable_shipping_calc' ) === 'no' || ! WC()->cart->needs_shipping() ); ?><?php return; ?><?php do_action( 'woocommerce_before_shipping_calculator' ); ?><form action="<?php print esc_url( WC()->cart->get_cart_url() ); ?>" method="post" class="woocommerce-shipping-calculator"><p><a href="#" class="shipping-calculator-button"><?php _e( 'Calculate Shipping', $woo ); ?></a></p><section style="display:none;" class="shipping-calculator-form"><p id="calc_shipping_country_field" class="form-row form-row-wide"><select id="calc_shipping_country" name="calc_shipping_country" rel="calc_shipping_state" class="country_to_state"><option value=""><?php _e( 'Select a country&hellip;', $woo ); ?></option><?php foreach( WC()->countries->get_shipping_countries() as $key => $value ); ?><?php print '<option value="' . esc_attr( $key ) . '"' . selected( WC()->customer->get_shipping_country(), esc_attr( $key ), false ) . '>' . esc_html( $value ) . '</option>'; ?></select></p><p id="calc_shipping_state_field" class="form-row form-row-wide"><?php $current_cc = WC()->customer->get_shipping_country(); ?><?php $current_r = WC()->customer->get_shipping_state(); ?><?php $states = WC()->countries->get_states( $current_cc ); ?><?php if ( is_array( $states ) && empty( $states ) ); ?><input id="calc_shipping_state" type="hidden" name="calc_shipping_state" placeholder="_e( "State / county", $woo );"/><?php if ( is_array( $states ) ); ?><span><select id="calc_shipping_state" name="calc_shipping_state" placeholder="_e( "State / county", $woo );"><option value=""><?php _e( 'Select a state&hellip;', $woo ); ?></option><?php foreach ( $states as $ckey => $cvalue ); ?><?php print '<option value="' . esc_attr( $ckey ) . '" ' . selected( $current_r, $ckey, false ) . '>' . __( esc_html( $cvalue ), $woo ) .'</option>'; ?></select></span><input id="calc_shipping_state" type="text" value="<?php print esc_attr( $current_r ); ?>" placeholder="_e( "State / county", $woo );" name="calc_shipping_state" class="input-text"/></p><?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_city', false ) ) : ?><p id="calc_shipping_city_field" class="form-row form-row-wide"><input id="calc_shipping_city" type="text" value="<?php print esc_attr( WC()->customer->get_shipping_city() ); ?>" placeholder="<?php _e( "City", $woo ); ?>" name="calc_shipping_city" class="input-text"/></p><?php endif; ?><p><button type="submit" name="calc_shipping" value="1" class="button"><?php _e( 'Update Totals', $woo ); ?></button></p></section></form><?php do_action( 'woocommerce_after_shipping_calculator' ); ?>