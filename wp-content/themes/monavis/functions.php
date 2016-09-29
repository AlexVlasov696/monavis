<?php
/**
 * monavis functions and definitions
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * @link http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage monavis
 * @since monavis
 */

global $themename,$shortname, $sidebar_excerpt_words;
$themename = 'monavis';
$shortname = "ma";
$sidebar_excerpt_words = 10;


add_action('after_setup_theme', 'thumbnails_setup');

function thumbnails_setup()
{
    global $themename;

    add_image_size('actions', 270, 100, true);
    add_image_size('articles', 100, 80, true);
    add_image_size('blocks', 430, 300, true);
    add_image_size('decoration', 400, 210, true);
    add_image_size('design', 550, 250, true);
    add_image_size('group', 200, 200, true);
    add_image_size('interior', 260, 150, true);
    add_image_size('project', 170, 85, true);
    add_image_size('project_big', 800, 380, true);
    add_image_size('slide', 1920, 600, true);

    load_theme_textdomain($themename, get_template_directory() . '/languages');
}

require_once locate_template('/func/enqueues.php');
require_once locate_template('/func/theme-options.php');
require_once locate_template('/func/admin-options.php');
require_once locate_template('/func/posttypes.php');
require_once locate_template('/func/taxonomies-attributes.php');
require_once locate_template('/func/taxonomies.php');
require_once locate_template('/func/metabox.php');
require_once locate_template('/func/dynamic-metabox.php');
require_once locate_template('/func/shortcodes.php');
require_once locate_template('/func/disable-comments.php');
require_once locate_template('/func/change-admin.php');
require_once locate_template('/func/breadcrumbs.php');
require_once locate_template('/func/menu.php');
require_once locate_template('/func/woo-commerce.php');
require_once locate_template('/func/bootstrap-pagination.php');

remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');

function remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
}

add_action('widgets_init', 'remove_recent_comments_style');

add_theme_support('post-thumbnails');
add_theme_support('widgets');


function ma_wp_title($title, $sep)
{
    global $paged, $page;

    if (is_feed())
        return $title;

    // Add the site name.
    $title .= get_bloginfo('name', 'display');

    // Add the site description for the home/front page.
    $site_description = get_bloginfo('description', 'display');
    if ($site_description && (is_home() || is_front_page()))
        $title = "$title $sep $site_description";

    // Add a page number if necessary.
    if (($paged >= 2 || $page >= 2) && !is_404())
        $title = "$title $sep " . sprintf(__('Page %s', 'twentytwelve'), max($paged, $page));

    if (is_home()) {
        $title = get_bloginfo('name', 'display');
    }

    return $title;
}

add_filter('wp_title', 'ma_wp_title', 10, 2);

function register_menus()
{
    register_nav_menus(
        array(
            'main-menu' => __('Header Menu'),
            'foot-menu' => __('Footer Menu')
        )
    );
}

add_action('init', 'register_menus');

/*remove_shortcode('gallery', 'gallery_shortcode');
add_shortcode('gallery', 'wp_gallery_shortcode');

function wp_gallery_shortcode($attr)
{
    return $attr['ids'];
}

function getImages($ids)
{
    global $wpdb;
    $getimages = explode(',', $ids['ids']);
    return $getimages;
}*/


function ma_widgets_init()
{
    register_sidebar(array(
        'name' => __('Footer Sidebar', 'ba'),
        'id' => 'sidebar-1',
        'before_widget' => '<aside class="media">',
        'after_widget' => "</aside>",
        'before_title' => '<h3 class="space-top">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Side Sidebar', 'ba'),
        'id' => 'sidebar-2',
        'before_widget' => '<aside class="media">',
        'after_widget' => "</aside>",
        'before_title' => '<h3 class="space-top">',
        'after_title' => '</h3>',
    ));

}

add_action('widgets_init', 'ma_widgets_init');

function getImage($thumb, $size, $id)
{
    $src = '';
    if ($id) {
        $image_url = wp_get_attachment_image_src($id, $thumb);
        $src = $image_url[0];
    } else {
        $src = 'http://placehold.it/' . $size;
    }
    return $src;
}

function the_post_thumbnail_description($thumbnail_id) {

    $thumbnail_image = get_posts(array('p' => $thumbnail_id, 'post_type' => 'attachment'));

    if ($thumbnail_image && isset($thumbnail_image[0])) {
        return $thumbnail_image[0]->post_content;
    }
    return '';
}

function categoryIcon($pid, $size)
{
    if (in_category('video', $pid)) {
        echo '<span class="icon ' . $size . ' video"></span>';
    } else if (in_category('photo', $pid)) {
        echo '<span class="icon ' . $size . ' gallery"></span>';
    } else if (in_category('anounce', $pid)) {
        echo '<span class="icon ' . $size . ' review"></span>';
    }
}

function postIcon($type, $size)
{
    switch ($type) {
        case 'video':
            echo '<span class="icon ' . $size . ' video"></span>';
            break;
        case 'photo':
            echo '<span class="icon ' . $size . ' gallery"></span>';
            break;
        case 'anounce':
            echo '<span class="icon ' . $size . ' review"></span>';
            break;
        case 'articles':
            echo '<span class="icon ' . $size . ' review"></span>';
            break;
        default :
            echo '<span class="icon ' . $size . ' news"></span>';
    }
}

function ma_contactmethods($contactmethods)
{
    $contactmethods['twitter'] = 'Twitter';
    $contactmethods['facebook'] = 'Facebook';
    $contactmethods['vk'] = 'Vkontakte';
    $contactmethods['position'] = 'Посада';
    return $contactmethods;
}

add_filter('user_contactmethods', 'ma_contactmethods', 10, 1);

function getAuthorViews($uid)
{
    global $wpdb;
    $query = $wpdb->get_results("SELECT SUM(pm.meta_value) AS views FROM wp_posts AS p
    INNER JOIN wp_postmeta AS pm ON (pm.post_id = p.ID)
    WHERE p.post_author= '$uid' AND p.post_status = 'publish' AND pm.meta_key = 'views'");
    $post = $query;
    unset($query);
    wp_reset_query();
    return $post[0]->views;
}

function getPostTaxonomy($post_type, $pID)
{
    switch ($post_type) {
        case 'region-news':
            return get_the_terms($pID, 'region');
            break;
        case 'anounce-news':
            return get_the_terms($pID, 'anounce');
            break;
        case 'media-news':
            return get_the_terms($pID, 'media');
            break;
        default:
            return $categories = get_the_category();
    }
}

function getNavObjects($pid, $menuname)
{
    global $wpdb;
    if ($menuname) {
        $query = $wpdb->get_results("SELECT DISTINCT p.post_title, p.post_excerpt, p.ID, pm.meta_value AS menu_type, ppm.meta_value AS parent, (SELECT count(*) FROM wp_postmeta AS c WHERE c.meta_value = p.ID AND c.meta_key = '_menu_item_menu_item_parent') AS child_count FROM wp_posts AS p
        INNER JOIN wp_postmeta AS pm ON (pm.post_id = p.ID)
        INNER JOIN wp_postmeta AS ppm ON (ppm.post_id = p.ID)
        INNER JOIN wp_terms AS t ON(t.name = '$menuname')
        INNER JOIN wp_term_taxonomy AS tt ON (tt.term_id = t.term_id)
        INNER JOIN wp_term_relationships AS tr ON(tr.term_taxonomy_id = tt.term_taxonomy_id)
        WHERE p.post_type= 'nav_menu_item' AND p.post_status = 'publish' AND pm.meta_key = '_menu_item_type' AND ppm.meta_key = '_menu_item_menu_item_parent'
        AND ppm.meta_value = $pid
        AND p.ID = tr.object_id
        ORDER BY p.menu_order");
    } else {
        $query = $wpdb->get_results("SELECT DISTINCT p.post_title, p.post_excerpt, p.ID, pm.meta_value AS menu_type, ppm.meta_value AS parent, (SELECT count(*) FROM wp_postmeta AS c WHERE c.meta_value = p.ID AND c.meta_key = '_menu_item_menu_item_parent') AS child_count FROM wp_posts AS p
        INNER JOIN wp_postmeta AS pm ON (pm.post_id = p.ID)
        INNER JOIN wp_postmeta AS ppm ON (ppm.post_id = p.ID)
        WHERE p.post_type= 'nav_menu_item' AND p.post_status = 'publish' AND pm.meta_key = '_menu_item_type' AND ppm.meta_key = '_menu_item_menu_item_parent'
        AND ppm.meta_value = $pid
        ORDER BY p.menu_order");
    }

    $post = $query;
    unset($query);
    wp_reset_query();

    foreach ($post as $nav_item) {
        $nav_item->class = '';
        $nav_item->megaclass = '';
        $nav_item->mega_menu = '';

        if ($nav_item->child_count) {
            $nav_item->class = 'submenu';
        }

        if (!empty($nav_item->post_excerpt)) {
            $nav_item->class = 'submenu';
            $nav_item->megaclass = 'mega_menu_parent';
            $nav_item->mega_menu = $nav_item->post_excerpt;
        }

        switch ($nav_item->menu_type) {
            case 'custom':
                $nav_item->title = $nav_item->post_title;
                $cLink = get_post_meta($nav_item->ID, '_menu_item_url');
                $nav_item->link = $cLink[0];
                break;
            case 'post_type':
                $pID = get_post_meta($nav_item->ID, '_menu_item_object_id');
                if (!empty($nav_item->post_title) && $nav_item->post_title != get_the_title($pID[0])) {
                    $nav_item->title = $nav_item->post_title;
                } else {
                    $nav_item->title = get_the_title($pID[0]);
                }
                $nav_item->link = get_the_permalink($pID[0]);
                break;
            case 'taxonomy':
                $tID = get_post_meta($nav_item->ID, '_menu_item_object_id');
                $tType = get_post_meta($nav_item->ID, '_menu_item_object');
                $term = get_term_by('id', $tID[0], $tType[0]);
                $nav_item->title = $term->name;
                $nav_item->link = get_term_link($term);
                break;
        }

    }
    return $post;
}

function getRegionsInfo()
{
    global $wpdb;
    $query = $wpdb->get_results("SELECT p.post_title, p.post_excerpt, p.post_name, p.ID FROM wp_posts AS p
    INNER JOIN wp_postmeta AS pm ON (pm.post_id = p.ID)
    WHERE p.post_status = 'publish' AND p.post_type = 'map-posts' ORDER BY p.post_title ");
    $posts = $query;
    unset($query);
    wp_reset_query();
    $regions = array();
    foreach ($posts as $post) {
        $regions[$post->post_name] = array();
        $regions[$post->post_name]['title'] = $post->post_title;
        $regions[$post->post_name]['text'] = $post->post_excerpt;
        $regions[$post->post_name]['center'] = get_post_meta($post->ID, 'ma_center', true);
        $regions[$post->post_name]['press'] = get_post_meta($post->ID, 'ma_press', true);
        $regions[$post->post_name]['consult'] = get_post_meta($post->ID, 'ma_consult', true);
    }
    unset($post);
    unset($posts);
    return $regions;
}

function trim_title($text)
{
    return wp_trim_words($text, 12);
}

function trim_excerpt($text)
{
    return wp_trim_words($text, 25);
}

### Function Show Post main Column in WP-Admin
add_action('manage_posts_custom_column', 'add_postmain_column_content');
add_filter('manage_posts_columns', 'add_postmain_column');
add_action('manage_pages_custom_column', 'add_postmain_column_content');
add_filter('manage_pages_columns', 'add_postmain_column');

function add_postmain_column($defaults)
{
    global $themename;

    $post_type = get_post_type();
    if ($post_type == 'region-news' || $post_type == 'post') {
        $defaults['main'] = __('Home page', $themename);
    } elseif ($post_type == 'media-news') {
        $defaults['fcount'] = __('Count', $themename);
    }
    return $defaults;
}


function the_main($display = true, $prefix = '', $postfix = '', $always = false)
{
    $post_main = get_post_meta(get_the_ID(), 'ma_main', true);
    if ($post_main == 'true') {
        echo '<span class="dashicons dashicons-yes"></span>';
    }
}

function the_fcount($display = true, $prefix = '', $postfix = '', $always = false)
{
    $pcontent = get_the_content();
    $ids = explode('ids="', $pcontent);
    $dids = explode('"]', $ids[1]);
    $cids = explode(",", $dids[0]);
    if ($cids[0] != "") {
        echo count($cids);
    }
}

### Functions Fill In The main Count
function add_postmain_column_content($column_name)
{
    if ($column_name == 'main') {
        if (function_exists('the_main')) {
            the_main(true, '', '', true);
        }
    } else if ($column_name == 'fcount') {
        if (function_exists('the_fcount')) {
            the_fcount(true, '', '', true);
        }
    }
}

### Function Sort Columns
add_filter('manage_edit-post_sortable_columns', 'sort_postmain_column');
add_filter('manage_edit-page_sortable_columns', 'sort_postmain_column');
function sort_postmain_column($defaults)
{
    $defaults['main'] = 'main';
    $defaults['fcount'] = 'fcount';
    return $defaults;
}

add_action('pre_get_posts', 'sort_postmain');
function sort_postmain($query)
{
    if (!is_admin())
        if ($query->is_main_query() && is_post_type_archive('social-posts')) {
            $query->set('posts_per_page', '20');
        } elseif ($query->is_main_query() && is_post_type_archive('region-news')) {
            $query->set('posts_per_page', '15');
        }
    return;
    $orderby = $query->get('orderby');
    if ('main' == $orderby) {
        $query->set('meta_key', 'ma_main');
        $query->set('orderby', 'meta_value_num');
    }
}

function showDate()
{
    $dateformat = get_option('ma_timeformat');
    if (empty($dateformat)) $dateformat = 'Y-m-d H:i';
    echo get_the_date($dateformat);
}

function getArrayElement($array)
{
    if ($array) {
        return array_shift(array_slice($array, 0, 1, true));
    }
}

function echo_the_meta_description()
{
    if (is_singular()) {
        global $post;
        setup_postdata($post);
        $meta_description = get_the_excerpt();
        return $meta_description;
    } elseif (is_search()) {
        return 'Пошук по запиту: ' . get_search_query();
    } elseif (is_category()) {
        $category_description = category_description();
        $category_description = strip_tags($category_description);
        $category_title = single_cat_title('', false);
        if ($category_description != '') {
            return $category_description;
        } else {
            return 'Категорія ' . $category_title;
        }
    } elseif (is_archive()) {
        $archive_period = 'архів за період ' . get_the_date($d) . ' | ' . get_bloginfo('name');
        return 'Пости у ' . $archive_period;
    } elseif (is_home()) {
        return get_bloginfo('description');
    } else {
        return get_bloginfo('description');
    }
}

function getMetaImage()
{

    $ogImage = get_template_directory_uri() . '/images/logo.gif';

    if (is_singular()) {
        global $post;
        setup_postdata($post);
        if (has_post_thumbnail($post->ID)) {
            $image = getImage('large-thumb', '330x242', get_post_thumbnail_id($post->ID));
        } else {
            $image = $ogImage;
        }
    } elseif (is_search()) {
        $image = $ogImage;
    } elseif (is_category()) {
        $image = $ogImage;
    } elseif (is_archive()) {
        $image = $ogImage;
    } else {
        $image = $ogImage;
    }

    return $image;
}


function mytheme_add_admin()
{
    global $themename, $options;
    if ($_GET['page'] == basename(__FILE__)) {
        if ('save' == $_REQUEST['action']) {
            foreach ($options as $value) {
                update_option($value['id'], $_REQUEST[$value['id']]);
            }
            foreach ($options as $value) {
                if (isset($_REQUEST[$value['id']])) {
                    update_option($value['id'], $_REQUEST[$value['id']]);
                } else {
                    delete_option($value['id']);
                }
            }
            header("Location: themes.php?page=functions.php&saved=true");
            die;
        } else if ('reset' == $_REQUEST['action']) {
            foreach ($options as $value) {
                delete_option($value['id']);
            }
            header("Location: themes.php?page=functions.php&reset=true");
            die;
        }
    }
    add_menu_page(__("Theme settings",$themename), __("Theme settings",$themename), 'edit_themes', basename(__FILE__), 'mytheme_admin');
}

add_action('admin_menu', 'mytheme_add_admin');

function admin_add_javascripts()
{
    wp_enqueue_script('jquery.tools.min', get_bloginfo('template_directory') . '/assets/js/tabs/jquery.tools.min.js', array('jquery'), '0.5');
}

if (is_admin()) {
    if (isset($_GET['page']) && $_GET['page'] == 'functions.php') {
        add_action('wp_print_scripts', 'admin_add_javascripts');
    }
}

function admin_chosen()
{
    wp_enqueue_script('jquery.chosen', get_bloginfo('template_directory') . '/assets/js/chosen/chosen.jquery.js');
    wp_register_style('chosen', get_template_directory_uri() . '/assets/js/chosen/chosen.css');
    wp_enqueue_style('chosen');
}

if (is_admin()) {
    add_action('wp_print_scripts', 'admin_chosen');
}

function give_linked_images_class($html, $id, $caption, $title, $align, $url, $size, $alt = '')
{
    $classes = 'lightbox';

    if (preg_match('/<a.*? class=".*?">/', $html)) {
        $html = preg_replace('/(<a.*? class=".*?)(".*?>)/', '$1 ' . $classes . '$2', $html);
    } else {
        $html = preg_replace('/(<a.*?)>/', '$1 class="' . $classes . '" >', $html);
    }
    return $html;
}

add_filter('image_send_to_editor', 'give_linked_images_class', 10, 8);

add_filter('pre_get_posts', 'set_post_order_in_admin');

function set_post_order_in_admin($wp_query)
{
    global $pagenow;
    if (is_admin() && 'edit.php' == $pagenow && !isset($_GET['orderby'])) {
        $wp_query->set('orderby', 'date');
        $wp_query->set('order', 'DSC');
    }
}

add_action('restrict_manage_posts', 'ma_filter_post_type_by_taxonomy');

function ma_filter_post_type_by_taxonomy()
{
    global $typenow, $themename;

    $filtered_pages[0]['post_type'] = 'media-news';
    $filtered_pages[0]['taxonomy'] = 'media';
    $filtered_pages[1]['post_type'] = 'region-news';
    $filtered_pages[1]['taxonomy'] = 'region';
    $filtered_pages[2]['post_type'] = 'social-posts';
    $filtered_pages[2]['taxonomy'] = 'author';

    foreach ($filtered_pages as $filtered_page) {
        if ($typenow == $filtered_page['post_type']) {
            $selected = isset($_GET[$filtered_page['taxonomy']]) ? $_GET[$filtered_page['taxonomy']] : '';
            $info_taxonomy = get_taxonomy($filtered_page['taxonomy']);
            wp_dropdown_categories(array(
                'show_option_all' => sprintf(__('Show all %s', $themename), mb_strtolower($info_taxonomy->label, 'UTF-8')),
                'taxonomy' => $filtered_page['taxonomy'],
                'name' => $filtered_page['taxonomy'],
                'orderby' => 'name',
                'selected' => $selected,
                'show_count' => true,
                'hide_empty' => true,
            ));
        };
    }
}

add_filter('parse_query', 'ma_term_in_query');

function ma_term_in_query($query)
{
    global $pagenow;

    $filtered_pages[0]['post_type'] = 'media-news';
    $filtered_pages[0]['taxonomy'] = 'media';
    $filtered_pages[1]['post_type'] = 'region-news';
    $filtered_pages[1]['taxonomy'] = 'region';
    $filtered_pages[2]['post_type'] = 'social-posts';
    $filtered_pages[2]['taxonomy'] = 'author';

    $q_vars = &$query->query_vars;
    foreach ($filtered_pages as $filtered_page) {
        if ($pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $filtered_page['post_type'] && isset($q_vars[$filtered_page['taxonomy']]) && is_numeric($q_vars[$filtered_page['taxonomy']]) && $q_vars[$filtered_page['taxonomy']] != 0) {
            $term = get_term_by('id', $q_vars[$filtered_page['taxonomy']], $filtered_page['taxonomy']);
            $q_vars[$filtered_page['taxonomy']] = $term->slug;
        }
    }
}

function ma_myme_types($mime_types)
{
    $mime_types['docx'] = 'application/msword';
    $mime_types['doc'] = 'application/msword';
    $mime_types['rtf'] = 'application/msword';
    $mime_types['xls'] = 'application/vnd.ms-excel';
    $mime_types['xlt'] = 'application/vnd.ms-excel';
    $mime_types['xla'] = 'application/vnd.ms-excel';
    $mime_types['ppt'] = 'application/vnd.ms-powerpoint';
    $mime_types['pot'] = 'application/vnd.ms-powerpoint';
    $mime_types['pps'] = 'application/vnd.ms-powerpoint';
    $mime_types['ppa'] = 'application/vnd.ms-powerpoint';
    $mime_types['csv'] = 'application/vnd.ms-excel';
    $mime_types['pdf'] = ' application/pdf';
    return $mime_types;
}

add_filter('upload_mimes', 'ma_myme_types', 1, 1);

function disable_emojis()
{
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
}

add_action('init', 'disable_emojis');

function addLinks($text)
{
    $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,5}(\/\S*)?/";

    if (preg_match($reg_exUrl, $text, $url)) {
        return preg_replace($reg_exUrl, "<a target='_blank' href='{$url[0]}'>{$url[0]}</a> ", $text);
    } else {
        return $text;
    }
}

function addEmails($text)
{
    preg_match_all('/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6})/', $text, $potentialEmails, PREG_SET_ORDER);

    $potentialEmailsCount = count($potentialEmails);
    for ($i = 0; $i < $potentialEmailsCount; $i++) {
        if (filter_var($potentialEmails[$i][0], FILTER_VALIDATE_EMAIL)) {
            $text = str_replace($potentialEmails[$i][0], '<a href="mailto:' . $potentialEmails[$i][0] . '">' . $potentialEmails[$i][0] . '</a>', $text);
        }
    }
    return $text;
}

function gravityforms_updates($value)
{
    if (!empty($value)) {
        unset($value->response['gravityforms/gravityforms.php']);
        return $value;
    }
}

add_filter('site_transient_update_plugins', 'gravityforms_updates');

function getPageTitle()
{

    global $post;

    $title = '';
    if (is_single() || is_page()) {
        $title = get_the_title();
    } elseif (!empty(get_queried_object()->labels->name)) {
        $title = get_queried_object()->labels->name;
    } elseif (is_day()) {
        $title = __("News for", "batkivshcyna") . ' ' . get_the_time('d.m.Y');
    } else {
        $title = get_queried_object()->name;
    }

    return $title;
}

function getPostImage()
{
    global $post;
    $image_id = get_post_thumbnail_id();
    if (!empty($image_id)) {
        $image_array = wp_get_attachment_image_src($image_id, 'full');
        $image_url = $image_array[0];
        return $image_url;
    }
    return false;
}

add_filter('woocommerce_currency_symbol', 'change_existing_currency_symbol', 10, 2);

function change_existing_currency_symbol( $currency_symbol, $currency ) {
    global $themename;
    switch( $currency ) {
        case 'UAH': $currency_symbol = __('uah', $themename); break;
    }
    return $currency_symbol;
}

add_action( 'woocommerce_add_to_cart' , 'repair_woocommerce_2_2_8_session_add_to_cart');

function repair_woocommerce_2_2_8_session_add_to_cart( ){
    wc_setcookie( 'woocommerce_items_in_cart', 1 );
    wc_setcookie( 'woocommerce_cart_hash', md5( json_encode( WC()->cart->get_cart() ) ) );
    do_action( 'woocommerce_set_cart_cookies', true );
}