<?php

function ma_enqueues()
{
    wp_register_style('min', get_template_directory_uri() . '/assets/css/compiled.min.css', false, null);
    wp_enqueue_style('min');

    wp_register_script('gmap', 'http://maps.google.com/maps/api/js?sensor=false', false, null, true);
    wp_enqueue_script('gmap');

    wp_register_script('min', get_template_directory_uri() . '/assets/js/compiled.min.js', false, null, true);
    wp_enqueue_script('min');

    //global $wpdb;
    //$query = "";

    wp_localize_script('min', 'WPURLS', array('siteurl' => get_bloginfo('template_url')));

    wp_deregister_script('jquery');

    wp_dequeue_style('sharify-icon');
    wp_dequeue_style('sharify');
    wp_dequeue_style('menu-image');

}

add_action('wp_enqueue_scripts', 'ma_enqueues', 100);

add_filter( 'woocommerce_enqueue_styles', '__return_false' );

if(!is_admin()) {

    remove_action( 'wp_enqueue_scripts', 'easy_image_gallery_scripts', 20 );
    remove_action( 'wp_footer', 'easy_image_gallery_js', 20 );
    remove_filter( 'the_content', 'easy_image_gallery_append_to_content' );
}

?>
