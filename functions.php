<?php

    // Show all errors, without needing to go back to wp-config.php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');


    // Settings page
    require_once "admin/settings.php";


     // Add support
    add_theme_support('post-thumbnails');
    add_theme_support('menus');


    // If page needs pagination nav, return true
    function show_posts_nav() {
    	global $wp_query;
    	return ($wp_query->max_num_pages > 1);
    }


    // Modifies the default excerpt [...] to say something a little more useful.
    function new_excerpt_more($more) {
        global $post;
        return '&nbsp;<a href="'. get_permalink($post->ID) . '">' . 'Read more' . '</a>';
    }
    add_filter('excerpt_more', 'new_excerpt_more');
    

    // Add first & last classes to wp_nav_menu menus
    function add_first_and_last($output) {
        $output = preg_replace('/class="menu-item/', 'class="first-menu-item menu-item', $output, 1);
        $output = substr_replace($output, 'class="last-menu-item menu-item', strripos($output, 'class="menu-item'), strlen('class="menu-item'));
        return $output;
    }
    add_filter('wp_nav_menu', 'add_first_and_last');
     

    // Add featured image to feeds
    // http://app.kodery.com/s/1314
    function insertThumbnailRSS($content) {
        global $post;
        if (has_post_thumbnail($post->ID)){
            $content = '' . get_the_post_thumbnail($post->ID, 'thumbnail', array('alt' => get_the_title(), 'title' => get_the_title(), 'style' => 'float:right;')) . '' . $content;
        }
        return $content;
    }
    add_filter('the_excerpt_rss', 'insertThumbnailRSS');
    add_filter('the_content_feed', 'insertThumbnailRSS');


    // Make search prefix pretty
    function fb_change_search_url_rewrite() {
        if (is_search() && ! empty($_GET['s'])) {
            wp_redirect(home_url("/search/") . urlencode(get_query_var('s')));
            exit();
        }
    }
    if (get_option('permalink_structure') !== '') {
        add_action('template_redirect', 'fb_change_search_url_rewrite');
    }


    // Gets the page content by ID, useful if you're trimming it down
    function get_the_content_by_id($gcbid) {
        $my_postid = $gcbid; //This is page id or post id
        $content_post = get_post($my_postid);
        $content = $content_post->post_content;
        $content = apply_filters('the_content', $content);
        $content = str_replace(']]>', ']]>', $content);
        return $content;
    }


    // Trim a string by words, so words don't get cut up
    function trim_by_words($string, $count, $ellipsis = false){
        $words = explode(' ', $string);
        if (count($words) > $count){
            array_splice($words, $count);
            $string = implode(' ', $words);
            if (is_string($ellipsis)){
                $string .= $ellipsis;
            } elseif ($ellipsis){
                $string .= '...';
            }
        }
        return $string;
    }


    // Pagination, nativly. (Only works on pretty URLs)
    $wp_rewrite->rules = $feed_rules + $wp_rewrite->rules;    
    $rules = $wp_rewrite->permalink_structure;
    function my_paginate_links() {
        global $wp_rewrite, $wp_query;
        $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
        if (empty($rules)) { $rulestouse = @add_query_arg('paged','%#%'); } else { $rulestouse = @add_query_arg('page','%#%'); }
        $pagination = array(
            'base' => $rulestouse,
            'format' => '',
            'total' => $wp_query->max_num_pages,
            'current' => $current,
            'prev_text' => __('« Previous'),
            'next_text' => __('Next »'),
            'end_size' => 1,
            'mid_size' => 2,
            'show_all' => true,
            'type' => 'plain'
        );
        if ($wp_rewrite->using_permalinks())
                $pagination['base'] = user_trailingslashit(trailingslashit(remove_query_arg('s', get_pagenum_link(1))) . 'page/%#%/', 'paged');
        if (!empty($wp_query->query_vars['s']))
                $pagination['add_args'] = array('s' => get_query_var('s'));
        echo paginate_links($pagination);
    }


    /*****
        Hide Admin Bar in WP 3.1
    *****/
    // add_filter('show_admin_bar', '__return_false');   

    // Change number of posts in search results
    // function change_wp_search_size($query) {
    //     if ($query->is_search) :
    //         $query->query_vars['posts_per_page'] = 1000;
    //     endif;
    //     return $query;
    // }
    // add_filter('pre_get_posts', 'change_wp_search_size');


    /*****
        Rename 'Posts' to 'Articles'
    *****/
    // function change_post_to_article($translated) {
    //      $translated = str_ireplace('Post', 'Article', $translated);  // ireplace is PHP5 only
    //      return $translated;
    // }
    // add_filter(  'gettext',  'change_post_to_article'  );
    // add_filter(  'ngettext',  'change_post_to_article'  );


    /*****
        Force maintenance mode to non-admins
    *****/
    // function wpr_maintenace_mode() {
    //     if ( !current_user_can("edit_themes") || !is_user_logged_in() ) {
    //         die("<h1>Maintenance, please come back soon.</h1>");
    //     }
    // }
    // add_action("get_header", "wpr_maintenace_mode");


    /*****
        Hide yellow update bar in admin
    *****/
    // // 2.3 to 2.7
    // add_action('init', create_function('$a', "remove_action('init', 'wp_version_check');"), 2);
    // add_filter('pre_option_update_core', create_function('$a', "return null;"));
    // // 2.8 to 3.0
    // remove_action('wp_version_check', 'wp_version_check');
    // remove_action('admin_init', '_maybe_update_core');
    // add_filter('pre_transient_update_core', create_function('$a', "return null;"));
    // // 3.0
    // add_filter('pre_site_transient_update_core', create_function('$a', "return null;"));


    /*****
        Show custom warning in admin pages, useful for warning it's a dev site
    *****/
    // add_action('admin_notices','my_custom_warning');
    // function my_custom_warning() {
    //     // 'error' is red, 'updated' is yellow
    //     echo '<div class="error"><p>This is a development site. Any changes to data may be <b>lost permanently</b>.</p></div>';
    // }

