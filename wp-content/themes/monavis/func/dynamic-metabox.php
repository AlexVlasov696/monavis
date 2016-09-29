<?php

function time_js() {

    wp_register_style('time_style' , get_bloginfo('template_directory') . '/assets/js/timepicker/css/jquery.timepicker.css');
    wp_enqueue_style('time_style');
    wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css');
    wp_enqueue_script('jquery-time-picker' ,  get_bloginfo('template_directory') . '/assets/js/timepicker/js/jquery.timepicker.js',  array('jquery' ));
}

add_action('admin_head', 'time_js');

add_action( 'add_meta_boxes', 'dynamic_add_custom_box' );

/* Do something with the data entered */
add_action( 'save_post', 'dynamic_save_postdata' );

/* Adds a box to the main column on the Post and Page edit screens */
function dynamic_add_custom_box() {
    global $themename;
    add_meta_box(
        'dynamic_sectionid',
        __( 'Timetable', $themename ),
        'dynamic_inner_custom_box',
        'master');
}

/* Prints the box content */
function dynamic_inner_custom_box() {
    global $post, $themename;
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'dynamicMeta_noncename' );
    ?>
    <div id="meta_inner">
    <?php

    //get the saved meta as an arry
    $timeline = get_post_meta($post->ID,'timeline',true);

    $c = 0;
    if ( $timeline && sizeof( $timeline ) > 0 ) {
        foreach( $timeline as $time ) {
            if ( isset( $time['title'] ) || isset( $time['time'] ) ) {
                printf( '<p>'.__( 'Course name', $themename ).': <input type="text" name="timeline[%1$s][title]" value="%2$s" /> | '.__( 'Course time', $themename ).' : <input type="text" class="timeline-time" name="timeline[%1$s][time]" value="%3$s" /><span class="remove"><span class="dashicons dashicons-no"></span> %4$s</span></p>', $c, $time['title'], $time['time'], __( 'Remove timeline', $themename ) );
                $c = $c +1;
            }
        }
    }

    ?>
    <span id="here"></span>
    <span class="add"><span class="dashicons dashicons-plus"></span> <?php print(__( 'Add timeline', $themename )); ?></span>
    <script>
        var $ =jQuery.noConflict();
        $(document).ready(function() {
            var count = <?php echo $c; ?>;
            $(".add").click(function() {
                count = count + 1;

                $('#here').append('<p><?php print(__( 'Course name', $themename )); ?>: <input type="text" name="timeline['+count+'][title]" value="" /> | <?php print(__( 'Course time', $themename )); ?>: <input type="text" name="timeline['+count+'][time]" value="" /><span class="remove"><span class="dashicons dashicons-no"></span> <?php print(__( 'Remove timeline', $themename )); ?></span></p>' );
                return false;
            });
            $(".remove").live('click', function() {
                $(this).parent().remove();
            });
            $('.timeline-time').timepicker({ 'timeFormat': 'h:i A','minTime': '8:00am','maxTime': '8:00pm','showDuration': true,'step': 15});
        });
    </script>
    <style type="text/css">
        #meta_inner span.add, #meta_inner span.remove {
            line-height: 20px;
            font-size: 14px;
            height: 20px;
            display: inline-block;
            cursor: pointer;
            color: green;
        }
        #meta_inner span.add span, #meta_inner span.remove span {
            display: inline-block;
            line-height: 20px;;
        }
        #meta_inner span.remove {
            color: red;
        }
    </style>
    </div><?php

}

/* When the post is saved, saves our custom data */
function dynamic_save_postdata( $post_id ) {
    // verify if this is an auto save routine.
    // If it is our form has not been submitted, so we dont want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;

    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if ( !isset( $_POST['dynamicMeta_noncename'] ) )
        return;

    if ( !wp_verify_nonce( $_POST['dynamicMeta_noncename'], plugin_basename( __FILE__ ) ) )
        return;

    // OK, we're authenticated: we need to find and save the data

    $timeline = $_POST['timeline'];

    update_post_meta($post_id,'timeline',$timeline);
}