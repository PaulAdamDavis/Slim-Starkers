<?php get_header(); ?>

	<?php if (have_posts()) : ?>

    	<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
    	<?php if (is_category()) { ?>
    	    <h2>Archive for the &#8216;<?php single_cat_title(); ?>&#8217; Category</h2>
    	<?php } elseif( is_tag() ) { ?>
    	    <h2>Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h2>
    	<?php } elseif (is_day()) { ?>
    	    <h2>Archive for <?php the_time('F jS, Y'); ?></h2>
    	<?php } elseif (is_month()) { ?>
    	    <h2>Archive for <?php the_time('F, Y'); ?></h2>
    	<?php } elseif (is_year()) { ?>
    	    <h2>Archive for <?php the_time('Y'); ?></h2>
    	<?php } elseif (is_author()) { ?>
    	    <h2>Author Archive</h2>
    	<?php } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
    	    <h2>Blog Archives</h2>
    	<?php } ?>

		<?php while (have_posts()) : the_post(); ?>
			<article <?php post_class() ?>>
				<h3 id="post-<?php the_ID(); ?>">
				    <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
				</h3>
				<time datetime="<?php the_time('Y-m-d') ?>" pubdate><?php the_time('l, F jS, Y') ?></time>
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
			printf("<h2>Sorry, but there aren't any posts in the %s category yet.</h2>", single_cat_title('',false));
		} else if ( is_date() ) {
			echo("<h2>Sorry, but there aren't any posts with this date.</h2>");
		} else if ( is_author() ) {
			$userdata = get_userdatabylogin(get_query_var('author_name'));
			printf("<h2>Sorry, but there aren't any posts by %s yet.</h2>", $userdata->display_name);
		} else {
			echo("<h2>No posts found.</h2>");
		}
		get_search_form();

	endif; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>