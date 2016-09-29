<?php

add_action('init', 'posttypes_register');

function posttypes_register()
{
    global $themename;

    add_post_type_support( 'page', 'excerpt' );

    $slides_labels = apply_filters(
        'slides_labels',
        array(
            'name' => __('Slides', $themename),
            'singular_name' => __('Slide', $themename),
            'add_new' => __('Add Slide', $themename),
            'all_items' => __('All Slides', $themename),
            'add_new_item' => __('Add Slide', $themename),
            'edit_item' => __('Edit Slide', $themename),
            'new_item' => __('New Slide', $themename),
            'view_item' => __('Show Slide', $themename),
            'search_items' => __('Search Slide', $themename),
            'not_found' => __('Slides not found', $themename),
            'not_found_in_trash' => __('Slides not found in trash', $themename)
        )
    );

    //Post types arguments

    $slides_args = apply_filters(
        'slides_args',
        array(
            'exclude_from_search' => false,
            'publicly_querable' => true,
            'show_in_nav_menus' => true,
            'show_in_admin_bar' => true,
            'public' => true,
            'show_ui' => true,
            'query_var' => 'slide',
            'menu_icon' => 'dashicons-format-gallery',
            'hierarchical' => true,
            'has_archive' => true,
            'can_export' => true,
            'capability_type' => 'post',
            'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'),
            'labels' => $slides_labels
        )
    );

    //Post types call register function

    register_post_type('slide', $slides_args);

    $literatures_labels = apply_filters(
        'literatures_labels',
        array(
            'name' => __('Literature', $themename),
            'singular_name' => __('Literature', $themename),
            'add_new' => __('Add literature', $themename),
            'all_items' => __('All literature', $themename),
            'add_new_item' => __('Add literature', $themename),
            'edit_item' => __('Edit literature', $themename),
            'new_item' => __('New literature', $themename),
            'view_item' => __('Show literature', $themename),
            'search_items' => __('Search literature', $themename),
            'not_found' => __('Literature not found', $themename),
            'not_found_in_trash' => __('Literature not found in trash', $themename)
        )
    );

    $literatures_args = apply_filters(
        'literatures_args',
        array(
            'exclude_from_search' => false,
            'publicly_querable' => true,
            'show_in_nav_menus' => true,
            'show_in_admin_bar' => true,
            'public' => true,
            'show_ui' => true,
            'query_var' => 'literature',
            'menu_icon' => 'dashicons-book-alt',
            'hierarchical' => true,
            'has_archive' => true,
            'can_export' => true,
            'capability_type' => 'post',
            'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'),
            'labels' => $literatures_labels
        )
    );

    //Post types call register function

    register_post_type('literature', $literatures_args);

    $teams_labels = apply_filters(
        'teams_labels',
        array(
            'name' => __('Team', $themename),
            'singular_name' => __('Team member', $themename),
            'add_new' => __('Add team member', $themename),
            'all_items' => __('All team members', $themename),
            'add_new_item' => __('Add team member', $themename),
            'edit_item' => __('Edit team member', $themename),
            'new_item' => __('New team member', $themename),
            'view_item' => __('Show team member', $themename),
            'search_items' => __('Search team member', $themename),
            'not_found' => __('Team member not found', $themename),
            'not_found_in_trash' => __('Team member not found in trash', $themename)
        )
    );

    $teams_args = apply_filters(
        'teams_args',
        array(
            'exclude_from_search' => false,
            'publicly_querable' => true,
            'show_in_nav_menus' => true,
            'show_in_admin_bar' => true,
            'public' => true,
            'show_ui' => true,
            'query_var' => 'team',
            'menu_icon' => 'dashicons-groups',
            'hierarchical' => true,
            'has_archive' => true,
            'can_export' => true,
            'capability_type' => 'post',
            'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'),
            'labels' => $teams_labels
        )
    );

    //Post types call register function

    register_post_type('team', $teams_args);

    $projects_labels = apply_filters(
    'projects_labels',
    array(
        'name' => __('Projects', $themename),
        'singular_name' => __('Project', $themename),
        'add_new' => __('Add project', $themename),
        'all_items' => __('All projects', $themename),
        'add_new_item' => __('Add project', $themename),
        'edit_item' => __('Edit project', $themename),
        'new_item' => __('New project', $themename),
        'view_item' => __('Show project', $themename),
        'search_items' => __('Search projects', $themename),
        'not_found' => __('Projects not found', $themename),
        'not_found_in_trash' => __('Projects not found in trash', $themename)
    )
);

    $projects_args = apply_filters(
        'projects_args',
        array(
            'exclude_from_search' => false,
            'publicly_querable' => true,
            'show_in_nav_menus' => true,
            'show_in_admin_bar' => true,
            'public' => true,
            'show_ui' => true,
            'query_var' => 'project',
            'menu_icon' => 'dashicons-clipboard',
            'hierarchical' => true,
            'has_archive' => true,
            'can_export' => true,
            'capability_type' => 'post',
            'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'),
            'labels' => $projects_labels
        )
    );

    //Post types call register function

    register_post_type('project', $projects_args);

    $decorations_labels = apply_filters(
        'decorations_labels',
        array(
            'name' => __('Decoration', $themename),
            'singular_name' => __('Decoration', $themename),
            'add_new' => __('Add decoration', $themename),
            'all_items' => __('All decorations', $themename),
            'add_new_item' => __('Add decoration', $themename),
            'edit_item' => __('Edit decoration', $themename),
            'new_item' => __('New decoration', $themename),
            'view_item' => __('Show decoration', $themename),
            'search_items' => __('Search decorations', $themename),
            'not_found' => __('Decorations not found', $themename),
            'not_found_in_trash' => __('Decorations not found in trash', $themename)
        )
    );

    $decorations_args = apply_filters(
        'decorations_args',
        array(
            'exclude_from_search' => false,
            'publicly_querable' => true,
            'show_in_nav_menus' => true,
            'show_in_admin_bar' => true,
            'public' => true,
            'show_ui' => true,
            'query_var' => 'decoration',
            'menu_icon' => 'dashicons-store',
            'hierarchical' => true,
            'has_archive' => true,
            'can_export' => true,
            'capability_type' => 'post',
            'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'),
            'labels' => $decorations_labels
        )
    );

    //Post types call register function

    register_post_type('decoration', $decorations_args);

    $masters_labels = apply_filters(
        'masters_labels',
        array(
            'name' => __('Study', $themename),
            'singular_name' => __('Master class', $themename),
            'add_new' => __('Add master class', $themename),
            'all_items' => __('All masters classes', $themename),
            'add_new_item' => __('Add master class', $themename),
            'edit_item' => __('Edit master class', $themename),
            'new_item' => __('New master class', $themename),
            'view_item' => __('Show master class', $themename),
            'search_items' => __('Search masters classes', $themename),
            'not_found' => __('Master classes not found', $themename),
            'not_found_in_trash' => __('Master classes not found in trash', $themename)
        )
    );

    $masters_args = apply_filters(
        'masters_args',
        array(
            'exclude_from_search' => false,
            'publicly_querable' => true,
            'show_in_nav_menus' => true,
            'show_in_admin_bar' => true,
            'public' => true,
            'show_ui' => true,
            'query_var' => 'master',
            'menu_icon' => 'dashicons-welcome-learn-more',
            'hierarchical' => true,
            'has_archive' => true,
            'can_export' => true,
            'capability_type' => 'post',
            'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'),
            'labels' => $masters_labels
        )
    );

    //Post types call register function

    register_post_type('master', $masters_args);

}