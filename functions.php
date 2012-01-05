<?php

    // If page needs pagination nav, return true
    function show_posts_nav() {
    	global $wp_query;
    	return ($wp_query->max_num_pages > 1);
    }

    // Modifies the default [...] to say something a little more useful.
    function new_excerpt_more($more) {
        global $post;
        return '&nbsp;<a href="'. get_permalink($post->ID) . '">' . 'Read more' . '</a>';
    }
    add_filter('excerpt_more', 'new_excerpt_more');
    
    // Hide Admin Bar in WP 3.1
    add_filter('show_admin_bar', '__return_false');    
    
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
    
    // If page is published
    // http://app.kodery.com/s/35
    function is_published($id) {
        $page_data = get_page($id);
        if($page_data->post_status == 'publish') :
            return true;
        else :
            return false;
        endif;
    }
    
    // Support featured image
    add_theme_support('post-thumbnails');
    
    // Support menus
    add_theme_support('menus');