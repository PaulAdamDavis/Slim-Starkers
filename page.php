<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<h1><?php the_title(); ?></h1>
			<?php if (has_post_thumbnail()) { ?>
		        <a href="<?php the_permalink() ?>">
		            <?php
                	    $src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), array(2000, 2000), false, '' );
                        echo '<img style="top: 0px; right: 0px;" class="postThumb" src="'. get_bloginfo("template_url") .'/timthumb.php?src='. $src[0] .'&w=620&q=90&a=t&zc=1" />';
                    ?>
                </a>
            <?php } ?>
            <?php the_content('<p>Read the rest of this page &raquo;</p>'); ?>
		</article>
	<?php endwhile; endif; ?>
	
<?php get_sidebar(); ?>
<?php get_footer(); ?>