<?php $woo = 'woocommerce'; ?><div class="woocommerce-billing-fields"><?php if ( WC()->cart->ship_to_billing_address_only() && WC()->cart->needs_shipping() ) : ?><h3><?php _e( 'Billing &amp; Shipping', $woo ); ?></h3><?php else: ?><h3><?php _e( 'Billing Details', $woo ); ?></h3><?php endif; ?><?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?><?php foreach ( $checkout->checkout_fields['billing'] as $key => $field ) : ?><?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?><?php endforeach; ?><?php do_action('woocommerce_after_checkout_billing_form', $checkout ); ?><?php if ( !is_user_logged_in() && $checkout->enable_signup) : ?><?php if ( $checkout->enable_guest_checkout ) : ?><div class="input-group form-row form-row-wide create-account"><div class="checkbox"><input id="createaccount" type="checkbox" name="createaccount" value="1" class="input-checkbox form-control checkbox"/><label for="createaccount"><?php _e( 'Create an account?', $woo ); ?></label></div></div><?php endif; ?><?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?><?php if (!empty($checkout->checkout_fields['account'])) : ?><div class="create-account form-group"><div class="well"><?php _e( 'Create an account by entering the information below. If you are a returning customer please login at the top of the page.', $woo ); ?><?php foreach ( $checkout->checkout_fields['account'] as $key => $field ) : ?><?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?><?php endforeach; ?></div><div class="clear"></div></div><?php endif; ?><?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?><?php endif; ?></div>