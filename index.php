<?php get_header(); ?>

	<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			<time datetime="<?php the_time('Y-m-d') ?>" pubdate><?php the_time('F jS, Y') ?></time> <!-- by <?php the_author() ?> -->
			<?php the_content('Read the rest of this entry &raquo;'); ?>
			<?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?>
		</article>
	<?php endwhile; ?>
	
	<?php if (show_posts_nav()) : ?>
		<nav class="nextPrevLinks">
			<?php my_paginate_links(); ?>
		</nav>
	<?php endif; ?>
	
	<?php else : ?>
		<h2>Not Found</h2>
		<p>Sorry, but you are looking for something that isn't here.</p>
		<?php get_search_form(); ?>
	<?php endif; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>