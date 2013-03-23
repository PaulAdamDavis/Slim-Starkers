<div id="comments">

    <?php if (have_comments()) : ?>
        <h2 id="comments-title">
            <?php
                if (get_comments_number() == 1) :
                    echo 'Just one comment';
                else :
                    echo convert_number_to_words(get_comments_number(), 'capitalize') . ' comments';
                endif;
            ?>
        </h2>

        <ol id="commentList">
            <?php wp_list_comments(array('callback' => 'nested_comment')); ?>
        </ol>

    <?php
        elseif (!comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) :
    ?>
        <p class="nocomments">Sorry, but comments are now closed.</p>
    <?php endif; ?>

    <?php
        $defaults = array(
            'fields' => apply_filters( 'comment_form_default_fields', array(
                'author' => '<input placeholder="Name (required)" id="author" name="author" type="text" value="' .  esc_attr( $commenter['comment_author'] ) . '" size="30" tabindex="1" />',
                'email'  => '<input placeholder="Mail (will not be published) (required)" id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" tabindex="2" />',
                'url'    => '<input placeholder="Website" id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" tabindex="3" />'
            )),
            'comment_field' => '<textarea placeholder="Your message" id="comment" name="comment" cols="45" rows="8" tabindex="4" aria-required="true"></textarea>',
            'must_log_in' => '<p class="must-log-in">' . sprintf(__('You must be <a href="%s">logged in</a> to post a comment.'), wp_login_url(apply_filters('the_permalink', get_permalink(get_the_id())))) . '</p>',
            'logged_in_as' => '<p class="logged-in-as">' . sprintf(__('Logged in as <a href="%s">%s</a>. <a title="Log out of this account" href="%s">Log out?</a></p>'), admin_url('profile.php'), $user_identity, wp_logout_url(apply_filters('the_permalink', get_permalink(get_the_id())))),
            'comment_notes_before' => false,
            'comment_notes_after' => false,
            'title_reply' => 'Leave a Reply',
            'title_reply_to' => __('Leave a Reply to %s'),
            'cancel_reply_link' => __('Cancel reply'),
            'label_submit' => __('Post Comment'),
        );
        comment_form($defaults);
    ?>

</div><!-- #comments -->
