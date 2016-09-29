<?php

add_action('add_meta_boxes', 'monavis_add_meta_boxes');

function monavis_add_meta_boxes()
{

    global $monavis_meta_fields, $themename, $shortname;

    add_meta_box(
        'custom_meta_box',
        __('slide options', $themename),
        'monavis_show_meta_box_callback',
        'slide',
        'normal',
        'high'
    );

    add_meta_box(
        'team_meta_boxes',
        __('Team Details', $themename),
        'monavis_show_meta_box_callback',
        'team',
        'normal',
        'high'
    );

    add_meta_box(
        'decoration_meta_boxes',
        __('Decortion options', $themename),
        'monavis_show_meta_box_callback',
        'decoration',
        'normal',
        'high'
    );

    add_meta_box(
        'project_meta_boxes',
        __('Project options', $themename),
        'monavis_show_meta_box_callback',
        'project',
        'normal',
        'high'
    );

    add_meta_box(
        'literature_meta_boxes',
        __('Literature details', $themename),
        'monavis_show_meta_box_callback',
        'literature',
        'normal',
        'high'
    );

    add_meta_box(
        'page_meta_boxes',
        __('Page options', $themename),
        'monavis_show_meta_box_callback',
        'page',
        'normal',
        'high'
    );
}

function monavis_get_slide_fields()
{

    global $themename, $shortname;
    $prefix = $shortname.'_';

    $monavis_meta_fields['main'] = array(
        'label' => __('Main', $themename),
        'desc' => __('Show on homepage', $themename),
        'id' => $prefix . 'main',
        'type' => 'checkbox'
    );

    // for extensibility, allows more meta fields to be added
    return apply_filters('monavis_fields', $monavis_meta_fields);
}

function monavis_get_custom_team_fields()
{
    global $themename, $shortname;
    $prefix = $shortname.'_';

    $monavis_meta_fields['team_position'] = array(
        'label' => __('Position', $themename),
        'id' => $prefix . 'team_position',
        'type' => 'text'
    );

    // for extensibility, allows more meta fields to be added
    return apply_filters('monavis_fields', $monavis_meta_fields);
}

function monavis_get_custom_literature_fields()
{
    global $themename, $shortname;
    $prefix = $shortname.'_';

    $monavis_meta_fields['author'] = array(
        'label' => __('Author', $themename),
        'id' => $prefix . 'author',
        'type' => 'text'
    );

    // for extensibility, allows more meta fields to be added
    return apply_filters('monavis_fields', $monavis_meta_fields);
}

function monavis_get_decoration_fields()
{

    global $wpdb, $themename, $shortname;
    $prefix = $shortname.'_';

    $products_query = $wpdb->get_results("SELECT DISTINCT p.post_name, p.post_title, p.ID FROM wp_posts AS p WHERE p.post_type= 'product' AND p.post_status = 'publish'");

    $products = $products_query;
    unset($products_query);

    $products_array = array();
    foreach ($products as $product) {
        $products_array[$product->post_name] = array();
        $products_array[$product->post_name]['label'] = $product->post_title;
        $products_array[$product->post_name]['value'] = $product->ID;
    }


    $monavis_meta_fields['related_products'] = array(
        'label' => __('Related products', $themename),
        'id' => $prefix . 'related_products',
        'type' => 'related',
        'multiple' => true,
        'options' => $products_array
    );

    // for extensibility, allows more meta fields to be added
    return apply_filters('monavis_fields', $monavis_meta_fields);
}

function monavis_get_project_fields()
{

    global $wpdb, $themename, $shortname;
    $prefix = $shortname.'_';

    $products_query = $wpdb->get_results("SELECT DISTINCT p.post_name, p.post_title, p.ID FROM wp_posts AS p WHERE p.post_type= 'decoration' AND p.post_status = 'publish'");

    $products = $products_query;
    unset($products_query);

    $products_array = array();
    foreach ($products as $product) {
        $products_array[$product->post_name] = array();
        $products_array[$product->post_name]['label'] = $product->post_title;
        $products_array[$product->post_name]['value'] = $product->ID;
    }


    $monavis_meta_fields['related_products'] = array(
        'label' => __('Related products', $themename),
        'id' => $prefix . 'related_products',
        'type' => 'related',
        'multiple' => true,
        'options' => $products_array
    );

    // for extensibility, allows more meta fields to be added
    return apply_filters('monavis_fields', $monavis_meta_fields);
}

function monavis_get_page_fields()
{

    global $post, $wpdb, $themename, $shortname;
    $prefix = $shortname.'_';


    $types = get_terms('design-type');
    $types_array = array();

    foreach ($types as $type) {
        $types_array[$type->slug] = array();
        $types_array[$type->slug]['label'] = $type->name;
        $types_array[$type->slug]['value'] = $type->term_id;
    }


    $monavis_meta_fields['types'] = array(
        'label' => __('Design types', $themename),
        'id' => $prefix . 'types',
        'type' => 'related',
        'multiple' => true,
        'options' => $types_array
    );

    $template_file = get_post_meta($post->ID,'_wp_page_template',TRUE);
    if ($template_file == 'interior-design.php') {
        return apply_filters('monavis_fields', $monavis_meta_fields);
    }
}


function monavis_show_meta_box_callback()
{
    global $post;
    $post_type = get_post_type($post->ID);

    switch ($post_type) {
        case 'slide':
            $meta_fields = monavis_get_slide_fields();
            break;
        case 'team':
            $meta_fields = monavis_get_custom_team_fields();
            break;
        case 'decoration':
            $meta_fields = monavis_get_decoration_fields();
            break;
        case 'project':
            $meta_fields = monavis_get_project_fields();
            break;
        case 'literature':
            $meta_fields = monavis_get_custom_literature_fields();
            break;
        case 'page':
            $meta_fields = monavis_get_page_fields();
            break;
    }

    // Use nonce for verification
    wp_nonce_field(basename(__FILE__), 'monavis_meta_box_nonce');

    // Begin the field table and loop
    echo '<table class="form-table monavis-form-table">';

    if (!empty($meta_fields)) {
        foreach ($meta_fields as $field) {
            // get value of this field if it exists for this post
            $meta = get_post_meta($post->ID, $field['id'], true);
            // begin a table row with
            echo '<tr>
                        <th><label for="' . $field['id'] . '">' . $field['label'] . '</label></th>
                        <td>';

            if (isset($field['before']) && !empty($field['before'])) {
                call_user_func($field['before']);
            }

            switch ($field['type']) {

                // text
                case 'text':
                    echo '<input type="text" name="' . $field['id'] . '" id="' . $field['id'] . '" value="' . esc_attr($meta) . '" size="55" />
                                    <br><span class="description">' . $field['desc'] . '</span>';
                    break;

                // textarea
                case 'textarea':
                    echo '<textarea name="' . $field['id'] . '" id="' . $field['id'] . '" style="width:100%" rows="4">' . esc_attr($meta) . '</textarea>
                                    <br><span class="description">' . $field['desc'] . '</span>';
                    break;

                // number
                case 'number':
                    echo '<input class="monavis-number-roller" type="number" placeholder="0" min="0" name="' . $field['id'] . '" id="' . $field['id'] . '" value="' . esc_attr($meta) . '" /><label for="' . $field['id'] . '"><span class="description">' . $field['desc'] . '</span></label>';
                    break;

                // checkbox
                case 'checkbox':
                    echo '<input type="hidden" name="' . $field['id'] . '" value="false" />';
                    echo '<input type="checkbox" name="' . $field['id'] . '" id="' . $field['id'] . '" value="true" ', checked($meta, 'true'), ' />
                                    <label for="' . $field['id'] . '">' . $field['desc'] . '</label>';
                    break;

                // related products
                case 'related':
                    echo '<select name="'.$field['id'].'[]" style="width:100%;" id="'.$field['id'].'"' , $field['type'] == 'related' ? ' class="chosen"' : '' , isset( $field['multiple'] ) && $field['multiple'] == true ? ' multiple="multiple"' : '' , '>';
                    foreach ( $field['options'] as $option )
                        echo '<option value="' . $option['value'] . '"' , is_array( $meta ) && in_array( $option['value'], $meta ) ? ' selected="selected"' : '' , ' >' . $option['label'] . '</option>';
                    echo '</select><br /><span class="description">' . $field['desc'].'</span>';
                    echo '<script type="text/javascript">
                            jQuery(document).ready(function ($) {
                                $(".chosen").chosen();
                            });
                            </script>';
                    break;

            } //end switch

            if (isset($field['after']) && !empty($field['after'])) {
                call_user_func($field['after']);
            }

            echo '</td></tr>';
        } // end foreach
    }
    echo '</table>'; // end table
}

add_action('save_post', 'monavis_save_custom_fields', 10, 2);
/**
 * Save the custom fields
 *
 * @since 2.0
 */
function monavis_save_custom_fields($post_id, $post)
{

    $posttype = get_post_type($post_id);
    global $themename, $shortname;

    switch ($posttype) {
        case 'slide':
            $meta_fields = monavis_get_slide_fields();
            break;
        case 'team':
            $meta_fields = monavis_get_custom_team_fields();
            break;
        case 'decoration':
            $meta_fields = monavis_get_decoration_fields();
            break;
        case 'project':
            $meta_fields = monavis_get_project_fields();
            break;
        case 'literature':
            $meta_fields = monavis_get_custom_literature_fields();
            break;
        case 'page':
            $meta_fields = monavis_get_page_fields();
            break;
    }

    /* Verify the nonce before proceeding. */
    if (!isset($_POST['monavis_meta_box_nonce']) || !wp_verify_nonce($_POST['monavis_meta_box_nonce'], basename(__FILE__)))
        return $post_id;
    /* Get the post type object. */
    $post_type = get_post_type_object($post->post_type);

    /* Check if the current user has permission to edit the post. */
    if (!current_user_can($post_type->cap->edit_post, $post_id))
        return $post_id;
    if($meta_fields) {
        foreach ($meta_fields as $field) {
            $old = get_post_meta($post_id, $field['id'], true);
            $new_value = $_POST[$field['id']];
            if (is_array($new_value)) {
                $new = $new_value;
            } else {
                $new = trim($new_value);
            }


            if ($new && $new != $old) {
                if ($field['id'] == $shortname . '_main' && $new == 'true') {
                    removeMainPost($posttype);
                }
                update_post_meta($post_id, $field['id'], $new);

            } elseif ('' == $new && $old) {
                delete_post_meta($post_id, $field['id'], $old);
            }
        }
    }

}

function removeMainPost($posttype)
{
    global $wpdb, $themename, $shortname;
    $query = $wpdb->get_results("SELECT p.ID FROM wp_posts AS p
    INNER JOIN wp_postmeta AS pm ON (pm.post_id = p.ID)
    WHERE pm.meta_value= 'true' AND p.post_status = 'publish' AND post_type = '" . $posttype . "' AND pm.meta_key = $shortname.'_main'");
    foreach ($query as $post) {
        update_post_meta($post->ID, $shortname.'_main', 'false');
    }
}




