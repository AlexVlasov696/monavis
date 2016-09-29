<?php

function query_string_protection_for_login_page() {
    /*global $wpdb;
    $query = $wpdb->get_results("SELECT DISTINCT option_value as code FROM wp_options WHERE option_name = 'ba_code' LIMIT 0,1");
    $code = $query[0]->code;
    unset($query);
    wp_reset_query();
    $QS = '?code='.$code;
    $theRequest = 'http://' . $_SERVER['SERVER_NAME'] . '/' . 'wp-login.php' . '?'. $_SERVER['QUERY_STRING'];
    if ( site_url('/wp-login.php').$QS == $theRequest ) {

    } else {
        header( 'Location: http://' . $_SERVER['SERVER_NAME'] . '/' );
    }*/
}

add_action('login_head', 'query_string_protection_for_login_page');