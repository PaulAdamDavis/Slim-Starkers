<?php

    // Show all errors, without needing to go back to wp-config.php
    // error_reporting(E_ALL);
    // ini_set('display_errors', '1');
    
    
    // Dirty pre function with limited height and randomnlt changing border colours
    function pre($var) {
        echo '<pre style="background: #fcffb1; text-align: left; outline: 4px solid rgb('. rand(0, 250) .','. rand(0, 250) .','. rand(0, 250) .'); width: 100%; overflow: auto; max-height: 300px;">';
            if ($var) :
                print_r($var);
            else :
                echo "\n\n\t--- <b>No data recieved by pre() function</b> ---\n\n";
            endif;
        echo '</pre>';
    }


    // Dirty JS console logging function, for when you want to see some data, but not in the markup
    // TODO: Make this function recognise objects & arrays and display as such
    function consolelog($string){
        echo '<script>console.log("%c" + "'. $string .'", "color:brown;background:#ddd;font-weight:bold;padding:2px 4px;");</script>';
    }


    // Settings page
    require_once "admin/settings.php";


     // Add support
    add_theme_support('post-thumbnails');
    add_theme_support('menus');


    // Remove generator meta tag from head
    remove_action('wp_head', 'wp_generator');


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
        $output = preg_replace('/class="menu-item/', 'class="first-menu-item menu-item ', $output, 1);
        $output = substr_replace($output, 'class="last-menu-item menu-item ', strripos($output, 'class="menu-item'), strlen('class="menu-item'));
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
    function change_search_url_rewrite() {
        if (is_search() && ! empty($_GET['s'])) {
            wp_redirect(home_url("/search/") . urlencode(get_query_var('s')));
            exit();
        }
    }
    if (get_option('permalink_structure') !== '') {
        add_action('template_redirect', 'change_search_url_rewrite');
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
        Menu highlighing fix
        ---
        Means if you have the blog page as a subpage and added to wp_nav_menu, single/archive pages will highlight correctly
    *****/
    add_filter('nav_menu_css_class', 'add_parent_url_menu_class', 10, 2);
    function add_parent_url_menu_class($classes = array(), $item = false) {
        $current_url = current_url();
        $homepage_url = trailingslashit(get_bloginfo('url'));
        if (is_404() or $item->url == $homepage_url) return $classes;
        if (strstr($current_url, $item->url)) {
            $classes[] = 'current_page_item';
        }
        return $classes;
    }
    function current_url() {
        $url = ('on' == $_SERVER['HTTPS']) ? 'https://' : 'http://';
        $url .= $_SERVER['SERVER_NAME'];
        $url .= ('80' == $_SERVER['SERVER_PORT']) ? '' : ':' . $_SERVER['SERVER_PORT'];
        $url .= $_SERVER['REQUEST_URI'];
        return trailingslashit( $url );
    }


    /*****
        Has children action
    *****/
    function add_menu_parent_class($items) {
        $parents = array();
        foreach ($items as $item) {
            if ($item->menu_item_parent && $item->menu_item_parent > 0) {
                $parents[] = $item->menu_item_parent;
            }
        }
        foreach ($items as $item) {
            if (in_array( $item->ID, $parents)) {
                $item->classes[] = 'has-children';
            }
        }
        return $items;
    }
    add_filter('wp_nav_menu_objects', 'add_menu_parent_class');


    /*****
        Nested Comment
    *****/
    function nested_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        switch ($comment->comment_type) :
            case 'pingback' :
            case 'trackback' :
        ?>
        <li class="post pingback">
            <p>Pingback: <?php comment_author_link(); ?><?php edit_comment_link('Edit', '<span class="edit-link">', '</span>'); ?></p>
        <?php
                break;
            default :
        ?>

        <?php
            /*$avatar_size = 80;
            if ($depth === 1) $avatar_size = 80;
            if ($depth === 2) $avatar_size = 60;
            if ($depth === 3) $avatar_size = 50;
            if ($depth === 4) $avatar_size = 40;
            */
        ?>

        <li class="comment-item depth-<?php echo $depth; ?>" id="li-comment-<?php comment_ID(); ?>">
            <article id="comment-<?php comment_ID(); ?>" class="comment">

                <div class="left">
                    <?php comment_author_link() ?> <a href="#comment-<?php comment_id(); ?>" class="comment_hash">#</a>
                    <span><?php comment_date('F jS, Y') ?> at <?php comment_time() ?></span>
                    <?php echo get_avatar($comment, 30); ?>
                </div>

                <div class="right">
                    <?php if ($comment->comment_approved == '0') : ?>
                        <span class="red">Your comment is awaiting moderation, <?php comment_author(); ?>.</span><br>
                    <?php endif; ?>
                    <?php comment_text() ?>
                    <div class="reply">
                        <?php comment_reply_link(
                            array_merge(
                                $args,
                                array(
                                    'reply_text' => 'Reply',
                                    'depth' => $depth,
                                    'max_depth' => $args['max_depth']
                                )
                            )
                        ); ?>
                    </div><!-- .reply -->
                </div>

                <div class="clear"></div>

            </article><!-- #comment-<?php comment_id(); ?> -->

        <?php
                break;
        endswitch;
    } // end nested_comment()


    /*****
        Convert int to words
    *****/
    function convert_number_to_words($number, $alt) {

        $alt = ($alt) ? $alt : false;

        $hyphen      = '-';
        $conjunction = ' and ';
        $separator   = ', ';
        $negative    = 'negative ';
        $decimal     = ' point ';
        $dictionary  = array(
            0                   => 'zero',
            1                   => 'one',
            2                   => 'two',
            3                   => 'three',
            4                   => 'four',
            5                   => 'five',
            6                   => 'six',
            7                   => 'seven',
            8                   => 'eight',
            9                   => 'nine',
            10                  => 'ten',
            11                  => 'eleven',
            12                  => 'twelve',
            13                  => 'thirteen',
            14                  => 'fourteen',
            15                  => 'fifteen',
            16                  => 'sixteen',
            17                  => 'seventeen',
            18                  => 'eighteen',
            19                  => 'nineteen',
            20                  => 'twenty',
            30                  => 'thirty',
            40                  => 'fourty',
            50                  => 'fifty',
            60                  => 'sixty',
            70                  => 'seventy',
            80                  => 'eighty',
            90                  => 'ninety',
            100                 => 'hundred',
            1000                => 'thousand',
            1000000             => 'million',
            1000000000          => 'billion',
            1000000000000       => 'trillion',
            1000000000000000    => 'quadrillion',
            1000000000000000000 => 'quintillion'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . convert_number_to_words(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds  = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= convert_number_to_words($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        if ($alt == 'capitalize') {
            $string = ucwords($string);
        }

        return $string;
    }


    /*****
        Hide Admin Bar in WP 3.1
    *****/
    // add_filter('show_admin_bar', '__return_false');


    /*****
        Change number of posts in search results
    *****/
    // function change_wp_search_size($query) {
    //     if ($query->is_search) :
    //         $query->query_vars['posts_per_page'] = 1000;
    //     endif;
    //     return $query;
    // }
    // add_filter('pre_get_posts', 'change_wp_search_size');


    /*****
        Change number of posts in archive results
    *****/
    // function change_wp_archive_size($query) {
    //     if ($query->is_archive) : // Make sure it is a search page
    //         $query->query_vars['posts_per_page'] = 1000;
    //     endif;
    //     return $query;
    // }
    // add_filter('pre_get_posts', 'change_wp_archive_size');



    /*****
        Rename 'Post' to 'Article'
    *****/
    // function change_post_to_article($translated) {
    //      $translated = str_ireplace('Post', 'Article', $translated);  // ireplace is PHP5 only
    //      return $translated;
    // }
    // add_filter('gettext', 'change_post_to_article');
    // add_filter('ngettext', 'change_post_to_article');


    /*****
        Force maintenance mode to non-admins
    *****/
    // function wpr_maintenace_mode() {
    //     if (!current_user_can("edit_themes") || !is_user_logged_in()) {
    //         die("<h1>Maintenance, please come back soon.</h1>");
    //     }
    // }
    // add_action("get_header", "wpr_maintenace_mode");


    /*****
        Show custom warning in admin pages, useful for warning it's a dev site
    *****/
    // add_action('admin_notices','my_custom_warning');
    // function my_custom_warning() {
    //     // 'error' class is red, 'updated' class is yellow
    //     echo '<div class="error"><p>This is a development site. Any changes to data may be <b>lost permanently</b>.</p></div>';
    // }
