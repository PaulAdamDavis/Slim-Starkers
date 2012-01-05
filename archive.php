<?php get_header(); ?>

	<?php if (have_posts()) : ?>

    	<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
    	<?php if (is_category()) { ?>
    	    <h1>Archive for the &#8216;<?php single_cat_title(); ?>&#8217; Category</h1>
    	<?php } elseif( is_tag() ) { ?>
    	    <h1>Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h1>
    	<?php } elseif (is_day()) { ?>
    	    <h1>Archive for <?php the_time('F jS, Y'); ?></h1>
    	<?php } elseif (is_month()) { ?>
    	    <h1>Archive for <?php the_time('F, Y'); ?></h1>
    	<?php } elseif (is_year()) { ?>
    	    <h1>Archive for <?php the_time('Y'); ?></h1>
    	<?php } elseif (is_author()) { ?>
    	    <h1>Author Archive</h1>
    	<?php } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
    	    <h1>Blog Archives</h1>
    	<?php } ?>

		<?php while (have_posts()) : the_post(); ?>
			<article <?php post_class() ?>>
				<h1 id="post-<?php the_ID(); ?>">
				    <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
				</h1>
				<time datetime="<?php the_time('Y-m-d') ?>" pubdate><?php the_time('l, F jS, Y') ?></time>
				<?php if (has_post_thumbnail()) { ?>
			        <a href="<?php the_permalink() ?>">
			            <?php
	                	    $src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), array(2000, 2000), false, '' );
	                        echo '<img style="top: 0px; right: 0px;" class="postThumb" src="'. get_bloginfo("template_url") .'/timthumb.php?src='. $src[0] .'&w=620&q=90&a=t&zc=1" />';
	                    ?>
	                </a>
	            <?php } ?>
	            <?php the_content() ?>
				<?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?>
			</article>
		<?php endwhile; ?>

		<?php if (show_posts_nav()) : ?>
			<nav class="nextPrevLinks">
				<?php my_paginate_links(); ?>
			</nav>
		<?php endif; ?>

	<?php else :

		if ( is_category() ) {
			printf("<h1>Sorry, but there aren't any posts in the %s category yet.</h1>", single_cat_title('',false));
		} else if ( is_date() ) {
			echo("<h1>Sorry, but there aren't any posts with this date.</h1>");
		} else if ( is_author() ) {
			$userdata = get_userdatabylogin(get_query_var('author_name'));
			printf("<h1>Sorry, but there aren't any posts by %s yet.</h1>", $userdata->display_name);
		} else {
			echo("<h1>No posts found.</h1>");
		}

	endif; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>