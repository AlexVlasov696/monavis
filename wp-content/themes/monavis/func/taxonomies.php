<?php

add_action('init', 'taxonomies_register');

function taxonomies_register()
{

    global $themename, $shortname;

    $cat_labels = array(
        'name' => __('Slide categories', $themename),
        'singular_name' => __('Slide category', $themename),
        'search_items' => __('Search slide category', $themename),
        'all_items' => __('All slide categories', $themename),
        'parent_item' => __('Parent slide category', $themename),
        'parent_item_colon' => __('Parent', $themename),
        'edit_item' => __('Edit slide category', $themename),
        'update_item' => __('Update slide category', $themename),
        'add_new_item' => __('Add slide category', $themename),
        'new_item_name' => __('New slide category name', $themename),
        'menu_name' => __('Slide categories', $themename),
    );

    register_taxonomy('slides-type', 'slide', array('hierarchical' => true, 'labels' => $cat_labels, 'public' => true, 'publicly_queryable' => true, 'query_var' => true, 'rewrite' => true));


    $decoration_labels = array(
        'name' => __('Decoration types', $themename),
        'singular_name' => __('Decoration type', $themename),
        'search_items' => __('Search type', $themename),
        'all_items' => __('All', $themename),
        'parent_item' => __('Parent type', $themename),
        'parent_item_colon' => __('Parent', $themename),
        'edit_item' => __('Edit type', $themename),
        'update_item' => __('Update type', $themename),
        'add_new_item' => __('Add types', $themename),
        'new_item_name' => __('New type name', $themename),
        'menu_name' => __('Types', $themename),
    );

    register_taxonomy('decoration-type', 'decoration', array('hierarchical' => true, 'labels' => $decoration_labels, 'public' => true, 'publicly_queryable' => true, 'query_var' => true, 'rewrite' => true));

    $design_labels = array(
        'name' => __('Project types', $themename),
        'singular_name' => __('Project type', $themename),
        'search_items' => __('Search type', $themename),
        'all_items' => __('All', $themename),
        'parent_item' => __('Parent type', $themename),
        'parent_item_colon' => __('Parent', $themename),
        'edit_item' => __('Edit type', $themename),
        'update_item' => __('Update type', $themename),
        'add_new_item' => __('Add types', $themename),
        'new_item_name' => __('New type name', $themename),
        'menu_name' => __('Types', $themename),
    );

    register_taxonomy('design-type', 'project', array('hierarchical' => true, 'labels' => $design_labels, 'public' => true, 'publicly_queryable' => true, 'query_var' => true, 'rewrite' => true));

    $master_labels = array(
        'name' => __('Master class types', $themename),
        'singular_name' => __('Master class type', $themename),
        'search_items' => __('Search type', $themename),
        'all_items' => __('All', $themename),
        'parent_item' => __('Parent type', $themename),
        'parent_item_colon' => __('Parent', $themename),
        'edit_item' => __('Edit type', $themename),
        'update_item' => __('Update type', $themename),
        'add_new_item' => __('Add types', $themename),
        'new_item_name' => __('New type name', $themename),
        'menu_name' => __('Types', $themename),
    );

    register_taxonomy('master-type', 'master', array('hierarchical' => true, 'labels' => $master_labels, 'public' => true, 'publicly_queryable' => true, 'query_var' => true, 'rewrite' => true));

    if ( class_exists( 'Taxonomy_Term_Image' ) ) :
        $decorationImage = new Taxonomy_Term_Image('decoration-type', get_bloginfo('template_directory') . '/assets/js/taxonomy-term-image/');
        $designImage = new Taxonomy_Term_Image('design-type', get_bloginfo('template_directory') . '/assets/js/taxonomy-term-image/');
        $masterClassImage = new Taxonomy_Term_Image('master-type', get_bloginfo('template_directory') . '/assets/js/taxonomy-term-image/');
    endif;

}