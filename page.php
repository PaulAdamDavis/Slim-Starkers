<?php get_header(); ?>

    <?php while (have_posts()) : the_post(); ?>
        <article <?php post_class() ?> id="post-<?php the_ID(); ?>">
            <h1><?php the_title(); ?></h1>
            <?php
                if (has_post_thumbnail()) :
                    $src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'medium', false, '' );
                    echo '<img src="'. $src[0] .'" />';
                endif;
            ?>
            <?php the_content('<p>Read the rest of this page &raquo;</p>'); ?>
        </article>
    <?php endwhile; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>