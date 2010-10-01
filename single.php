<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<?php previous_post_link('&laquo; %link') ?> <?php next_post_link('%link &raquo;') ?>
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<h2><?php the_title(); ?></h2>
			<?php the_content('<p>Read the rest of this entry &raquo;</p>'); ?>
			<?php comments_template(); ?>
		</article>
	<?php endwhile; else: ?>
		<p>Sorry, no posts matched your criteria.</p>
        <?php endif; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>