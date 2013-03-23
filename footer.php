    <footer>
        <small>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></small>
    </footer>

    </div><!-- end .wrapper -->

    <!-- JavaScript / jQuery with migrate plugin inc in local file -->
    <script src="//code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.1.1.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?php bloginfo('template_url'); ?>/js/jquery-1.9.1.min.js"><\/script>')</script>
    <script src="<?php bloginfo('template_url'); ?>/js/scripts.js"></script>

    <?php wp_footer(); ?>

    <!-- <?php echo get_num_queries(); ?> queries. <?php timer_stop(1); ?> seconds. -->

</body>
</html>