<?php

function woocommerce_button_proceed_to_checkout()
{
    $checkout_url = WC()->cart->get_checkout_url();

    ?>
    <a href="<?php echo $checkout_url; ?>" class="btn btn-info alt wc-forward"><?php _e('Proceed to Checkout', 'woocommerce'); ?></a>
<?php
}

function woocommerce_form_field($key, $args, $value = null)
{
    $defaults = array(
        'type' => 'text',
        'label' => '',
        'description' => '',
        'placeholder' => '',
        'maxlength' => false,
        'required' => false,
        'id' => $key,
        'class' => array(),
        'label_class' => array(),
        'input_class' => array(),
        'return' => false,
        'options' => array(),
        'custom_attributes' => array(),
        'validate' => array(),
        'default' => '',
    );

    // Custom attribute handling
    $custom_attributes = array();

    $args = wp_parse_args($args, $defaults);
    $args = apply_filters('woocommerce_form_field_args', $args, $key, $value);

    if ((!empty($args['clear']))) {
        $after = '<div class="clear"></div>';
    } else {
        $after = '';
    }

    if ($args['required']) {
        $args['class'][] = 'validate-required';
        $required = ' <abbr class="required" title="' . esc_attr__('required', 'woocommerce') . '">*</abbr>';
        $custom_attributes['required'] = 'required';
    } else {
        $required = '';
    }

    $args['maxlength'] = ($args['maxlength']) ? 'maxlength="' . absint($args['maxlength']) . '"' : '';

    if (is_string($args['label_class'])) {
        $args['label_class'] = array($args['label_class']);
    }

    if (is_null($value)) {
        $value = $args['default'];
    }

    if (!empty($args['custom_attributes']) && is_array($args['custom_attributes'])) {
        foreach ($args['custom_attributes'] as $attribute => $attribute_value) {
            $custom_attributes[] = esc_attr($attribute) . '="' . esc_attr($attribute_value) . '"';
        }
    }

    if (!empty($args['validate'])) {
        foreach ($args['validate'] as $validate) {
            $args['class'][] = 'validate-' . $validate;
        }
    }

    switch ($args['type']) {
        case 'country' :

            $countries = $key == 'shipping_country' ? WC()->countries->get_shipping_countries() : WC()->countries->get_allowed_countries();

            if (sizeof($countries) == 1) {

                $field = '<div class="form-row form-group ' . esc_attr(implode(' ', $args['class'])) . '" id="' . esc_attr($args['id']) . '_field">';

                if ($args['label']) {
                    $field .= '<label class="' . esc_attr(implode(' ', $args['label_class'])) . '">' . $args['label'] . '</label>';
                }

                $field .= '<strong>' . current(array_values($countries)) . '</strong>';

                $field .= '<input type="hidden" name="' . esc_attr($key) . '" id="' . esc_attr($args['id']) . '" value="' . current(array_keys($countries)) . '" ' . implode(' ', $custom_attributes) . ' class="country_to_state" />';

                if ($args['description']) {
                    $field .= '<span class="description">' . esc_attr($args['description']) . '</span>';
                }

                $field .= '<span class="help-block with-errors"></span>';

                $field .= '</div>' . $after;

            } else {

                $field = '<div class="form-row form-group ' . esc_attr(implode(' ', $args['class'])) . '" id="' . esc_attr($args['id']) . '_field">'
                    . '<label for="' . esc_attr($args['id']) . '" class="' . esc_attr(implode(' ', $args['label_class'])) . '">' . $args['label'] . $required . '</label>'
                    . '<select name="' . esc_attr($key) . '" id="' . esc_attr($args['id']) . '" class="form-control bootstrap-select' . esc_attr(implode(' ', $args['input_class'])) . '" ' . implode(' ', $custom_attributes) . '>'
                    . '<option value="">' . __('Select a country&hellip;', 'woocommerce') . '</option>';

                foreach ($countries as $ckey => $cvalue) {
                    $field .= '<option value="' . esc_attr($ckey) . '" ' . selected($value, $ckey, false) . '>' . __($cvalue, 'woocommerce') . '</option>';
                }

                $field .= '</select>';

                $field .= '<noscript><input type="submit" name="woocommerce_checkout_update_totals" value="' . __('Update country', 'woocommerce') . '" /></noscript>';

                if ($args['description']) {
                    $field .= '<span class="description">' . esc_attr($args['description']) . '</span>';
                }

                $field .= '<span class="help-block with-errors"></span>';

                $field .= '</div>' . $after;

            }

            break;
        case 'state' :

            /* Get Country */
            $country_key = $key == 'billing_state' ? 'billing_country' : 'shipping_country';
            $current_cc = WC()->checkout->get_value($country_key);
            $states = WC()->countries->get_states($current_cc);

            if (is_array($states) && empty($states)) {

                $field = '<div class="form-row form-group ' . esc_attr(implode(' ', $args['class'])) . '" id="' . esc_attr($args['id']) . '_field" style="display: none">';

                if ($args['label']) {
                    $field .= '<label for="' . esc_attr($args['id']) . '" class="' . esc_attr(implode(' ', $args['label_class'])) . '">' . $args['label'] . $required . '</label>';
                }
                $field .= '<input type="hidden" class="hidden" name="' . esc_attr($key) . '" id="' . esc_attr($args['id']) . '" value="" ' . implode(' ', $custom_attributes) . ' placeholder="' . esc_attr($args['placeholder']) . '" />';

                if ($args['description']) {
                    $field .= '<span class="description">' . esc_attr($args['description']) . '</span>';
                }

                $field .= '<span class="help-block with-errors"></span>';

                $field .= '</div>' . $after;

            } elseif (is_array($states)) {

                $field = '<div class="form-row form-group ' . esc_attr(implode(' ', $args['class'])) . '" id="' . esc_attr($args['id']) . '_field">';

                if ($args['label'])
                    $field .= '<label for="' . esc_attr($args['id']) . '" class="' . esc_attr(implode(' ', $args['label_class'])) . '">' . $args['label'] . $required . '</label>';
                $field .= '<select name="' . esc_attr($key) . '" id="' . esc_attr($args['id']) . '" class="state_select ' . esc_attr(implode(' ', $args['input_class'])) . '" ' . implode(' ', $custom_attributes) . ' placeholder="' . esc_attr($args['placeholder']) . '">
						<option value="">' . __('Select a state&hellip;', 'woocommerce') . '</option>';

                foreach ($states as $ckey => $cvalue) {
                    $field .= '<option value="' . esc_attr($ckey) . '" ' . selected($value, $ckey, false) . '>' . __($cvalue, 'woocommerce') . '</option>';
                }

                $field .= '</select>';

                if ($args['description']) {
                    $field .= '<span class="description">' . esc_attr($args['description']) . '</span>';
                }

                $field .= '<span class="help-block with-errors"></span>';

                $field .= '</div>' . $after;

            } else {

                $field = '<div class="form-row form-group ' . esc_attr(implode(' ', $args['class'])) . '" id="' . esc_attr($args['id']) . '_field">';

                if ($args['label']) {
                    $field .= '<label for="' . esc_attr($args['id']) . '" class="' . esc_attr(implode(' ', $args['label_class'])) . '">' . $args['label'] . $required . '</label>';
                }
                $field .= '<input type="text" class="form-control ' . esc_attr(implode(' ', $args['input_class'])) . '" value="' . esc_attr($value) . '"  placeholder="' . esc_attr($args['placeholder']) . '" name="' . esc_attr($key) . '" id="' . esc_attr($args['id']) . '" ' . implode(' ', $custom_attributes) . ' />';

                if ($args['description']) {
                    $field .= '<span class="description">' . esc_attr($args['description']) . '</span>';
                }

                $field .= '<span class="help-block with-errors"></span>';

                $field .= '</div>' . $after;

            }

            break;
        case 'textarea' :

            $field = '<div class="form-row form-group ' . esc_attr(implode(' ', $args['class'])) . '" id="' . esc_attr($args['id']) . '_field">';

            if ($args['label']) {
                $field .= '<label for="' . esc_attr($args['id']) . '" class="' . esc_attr(implode(' ', $args['label_class'])) . '">' . $args['label'] . $required . '</label>';
            }

            $field .= '<textarea name="' . esc_attr($key) . '" class="form-control ' . esc_attr(implode(' ', $args['input_class'])) . '" id="' . esc_attr($args['id']) . '" placeholder="' . esc_attr($args['placeholder']) . '" ' . $args['maxlength'] . ' ' . (empty($args['custom_attributes']['rows']) ? ' rows="2"' : '') . (empty($args['custom_attributes']['cols']) ? ' cols="5"' : '') . implode(' ', $custom_attributes) . '>' . esc_textarea($value) . '</textarea>';

            if ($args['description']) {
                $field .= '<span class="description">' . esc_attr($args['description']) . '</span>';
            }

            $field .= '<span class="help-block with-errors"></span>';

            $field .= '</div>' . $after;

            break;
        case 'checkbox' :

            $field = '<div class="form-row form-group ' . esc_attr(implode(' ', $args['class'])) . '" id="' . esc_attr($args['id']) . '_field">
						<label class="checkbox ' . implode(' ', $args['label_class']) . '" ' . implode(' ', $custom_attributes) . '>
						<input type="' . esc_attr($args['type']) . '" class="input-checkbox ' . esc_attr(implode(' ', $args['input_class'])) . '" name="' . esc_attr($key) . '" id="' . esc_attr($args['id']) . '" value="1" ' . checked($value, 1, false) . ' /> '
                . $args['label'] . $required . '</label>';

            if ($args['description']) {
                $field .= '<span class="description">' . esc_attr($args['description']) . '</span>';
            }

            $field .= '<span class="help-block with-errors"></span>';

            $field .= '</div>' . $after;

            break;
        case 'password' :

            $field = '<div class="form-row form-group ' . esc_attr(implode(' ', $args['class'])) . '" id="' . esc_attr($args['id']) . '_field">';

            if ($args['label']) {
                $field .= '<label for="' . esc_attr($args['id']) . '" class="' . esc_attr(implode(' ', $args['label_class'])) . '">' . $args['label'] . $required . '</label>';
            }

            $field .= '<input type="password" class="form-control ' . esc_attr(implode(' ', $args['input_class'])) . '" name="' . esc_attr($key) . '" id="' . esc_attr($args['id']) . '" placeholder="' . esc_attr($args['placeholder']) . '" value="' . esc_attr($value) . '" ' . implode(' ', $custom_attributes) . ' />';

            if ($args['description']) {
                $field .= '<span class="description">' . esc_attr($args['description']) . '</span>';
            }

            $field .= '<span class="help-block with-errors"></span>';

            $field .= '</div>' . $after;

            break;

        case 'text' :

            $field = '<div class="form-row form-group ' . esc_attr(implode(' ', $args['class'])) . '" id="' . esc_attr($args['id']) . '_field">';

            if ($args['label']) {
                $field .= '<label for="' . esc_attr($args['id']) . '" class="' . esc_attr(implode(' ', $args['label_class'])) . '">' . $args['label'] . $required . '</label>';
            }

            $field .= '<input type="text" class="form-control ' . esc_attr(implode(' ', $args['input_class'])) . '" name="' . esc_attr($key) . '" id="' . esc_attr($args['id']) . '" placeholder="' . esc_attr($args['placeholder']) . '" ' . $args['maxlength'] . ' value="' . esc_attr($value) . '" ' . implode(' ', $custom_attributes) . ' />';

            if ($args['description']) {
                $field .= '<span class="description">' . esc_attr($args['description']) . '</span>';
            }

            $field .= '<span class="help-block with-errors"></span>';

            $field .= '</div>' . $after;

            break;

        case 'email' :

            $field = '<div class="form-row form-group ' . esc_attr(implode(' ', $args['class'])) . '" id="' . esc_attr($args['id']) . '_field">';

            if ($args['label']) {
                $field .= '<label for="' . esc_attr($args['id']) . '" class="' . esc_attr(implode(' ', $args['label_class'])) . '">' . $args['label'] . $required . '</label>';
            }

            $field .= '<input type="email" class="form-control ' . esc_attr(implode(' ', $args['input_class'])) . '" name="' . esc_attr($key) . '" id="' . esc_attr($args['id']) . '" placeholder="' . esc_attr($args['placeholder']) . '" ' . $args['maxlength'] . ' value="' . esc_attr($value) . '" ' . implode(' ', $custom_attributes) . ' />';

            if ($args['description']) {
                $field .= '<span class="description">' . esc_attr($args['description']) . '</span>';
            }

            $field .= '<span class="help-block with-errors"></span>';

            $field .= '</div>' . $after;

            break;

        case 'tel' :

            $field = '<div class="form-row form-group ' . esc_attr(implode(' ', $args['class'])) . '" id="' . esc_attr($args['id']) . '_field">';

            if ($args['label']) {
                $field .= '<label for="' . esc_attr($args['id']) . '" class="' . esc_attr(implode(' ', $args['label_class'])) . '">' . $args['label'] . $required . '</label>';
            }

            $field .= '<input type="tel" class="form-control ' . esc_attr(implode(' ', $args['input_class'])) . '" name="' . esc_attr($key) . '" id="' . esc_attr($args['id']) . '" placeholder="' . esc_attr($args['placeholder']) . '" ' . $args['maxlength'] . ' value="' . esc_attr($value) . '" ' . implode(' ', $custom_attributes) . ' />';

            if ($args['description']) {
                $field .= '<span class="description">' . esc_attr($args['description']) . '</span>';
            }

            $field .= '<span class="help-block with-errors"></span>';

            $field .= '</div>' . $after;

            break;

        case 'select' :

            $options = $field = '';

            if (!empty($args['options'])) {
                foreach ($args['options'] as $option_key => $option_text) {
                    if ("" === $option_key) {
                        // If we have a blank option, select2 needs a placeholder
                        if (empty($args['placeholder'])) {
                            $args['placeholder'] = $option_text ? $option_text : __('Choose an option', 'woocommerce');
                        }
                        $custom_attributes[] = 'data-allow_clear="true"';
                    }
                    $options .= '<option value="' . esc_attr($option_key) . '" ' . selected($value, $option_key, false) . '>' . esc_attr($option_text) . '</option>';
                }

                $field = '<div class="form-row form-group  ' . esc_attr(implode(' ', $args['class'])) . '" id="' . esc_attr($args['id']) . '_field">';

                if ($args['label']) {
                    $field .= '<label for="' . esc_attr($args['id']) . '" class="' . esc_attr(implode(' ', $args['label_class'])) . '">' . $args['label'] . $required . '</label>';
                }

                $field .= '<select name="' . esc_attr($key) . '" id="' . esc_attr($args['id']) . '" class="select bootstrap-select' . esc_attr(implode(' ', $args['input_class'])) . '" ' . implode(' ', $custom_attributes) . ' placeholder="' . esc_attr($args['placeholder']) . '">
							' . $options . '
						</select>';

                if ($args['description']) {
                    $field .= '<span class="description">' . esc_attr($args['description']) . '</span>';
                }

                $field .= '<span class="help-block with-errors"></span>';

                $field .= '</div>' . $after;
            }

            break;
        case 'radio' :

            $field = '<div class="form-row form-group radio ' . esc_attr(implode(' ', $args['class'])) . '" id="' . esc_attr($args['id']) . '_field">';

            if ($args['label']) {
                $field .= '<label for="' . esc_attr(current(array_keys($args['options']))) . '" class="' . esc_attr(implode(' ', $args['label_class'])) . '">' . $args['label'] . $required . '</label>';
            }

            if (!empty($args['options'])) {
                foreach ($args['options'] as $option_key => $option_text) {
                    $field .= '<input type="radio" class="input-radio ' . esc_attr(implode(' ', $args['input_class'])) . '" value="' . esc_attr($option_key) . '" name="' . esc_attr($key) . '" id="' . esc_attr($args['id']) . '_' . esc_attr($option_key) . '"' . checked($value, $option_key, false) . ' />';
                    $field .= '<label for="' . esc_attr($args['id']) . '_' . esc_attr($option_key) . '" class="radio ' . implode(' ', $args['label_class']) . '">' . $option_text . '</label>';
                }
            }

            $field .= '<span class="help-block with-errors"></span>';

            $field .= '</div>' . $after;

            break;
        default :

            $field = '<div class="form-row form-group ' . esc_attr(implode(' ', $args['class'])) . '" id="' . esc_attr($args['id']) . '_field">';

            if ($args['label']) {
                $field .= '<label for="' . esc_attr($args['id']) . '" class="' . esc_attr(implode(' ', $args['label_class'])) . '">' . $args['label'] . $required . '</label>';
            }

            $field .= '<input type="'.$args['type'].'" class="form-control ' . esc_attr(implode(' ', $args['input_class'])) . '" name="' . esc_attr($key) . '" id="' . esc_attr($args['id']) . '" placeholder="' . esc_attr($args['placeholder']) . '" ' . $args['maxlength'] . ' value="' . esc_attr($value) . '" ' . implode(' ', $custom_attributes) . ' />';

            if ($args['description']) {
                $field .= '<span class="description">' . esc_attr($args['description']) . '</span>';
            }

            $field .= '<span class="help-block with-errors"></span>';

            $field .= '</div>' . $after;

            break;

            break;
    }

    $field = apply_filters('woocommerce_form_field_' . $args['type'], $field, $key, $args, $value);

    if ($args['return']) {
        return preg_replace('~[\r\n]+~', '',$field);
    } else {
        print preg_replace('~[\r\n]+~', '',$field);
    }
}