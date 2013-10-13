<?php
/**
 * Replies Loop
 *
 * @package bbPress
 * @subpackage Theme
 */
?>
<?php do_action('bbp_template_before_replies_loop'); ?>
<div id="forumposts">
    <div class="cat_bar">
        <h3>
            <span id="author"><?php _e('Author', 'bbpress'); ?></span>
            <?php if (!bbp_show_lead_topic()) : ?>
                <?php _e('Posts', 'bbpress'); ?>
                <?php bbp_user_subscribe_link(); ?>
            &nbsp;|&nbsp;
                <?php bbp_user_favorites_link(); ?>
            <?php else : ?>
                <?php _e('Replies', 'bbpress'); ?>
            <?php endif; ?>
        </h3>
    </div>
    <?php
    $i = 0;
    while (bbp_replies()) : 
        if ($i > 0) echo '<hr class="post_separator" />';
        bbp_the_reply(); ?>
        <?php bbp_get_template_part('loop', 'single-reply'); ?>
    <?php
    $i++;
    endwhile; ?>
</div>
<?php do_action('bbp_template_after_replies_loop'); ?>