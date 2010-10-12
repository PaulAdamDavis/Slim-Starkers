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
	
?>