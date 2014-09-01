<?php
/**
 * Single Reply
 *
 * @package bbPress
 * @subpackage Theme
 */
get_header();
global $defaultoptions;
global $options;
?>
<div class="section content" id="main-content">
    <div class="row">
        <div class="content-primary">            
            <?php $image_url = piratenkleider_get_cover(bbp_get_reply_title(), get_the_ID()); ?>
            <div class="skin">
                <?php do_action('bbp_before_main_content'); ?>
                <?php if (!(isset($image_url) && (strlen($image_url) > 4))) { ?>
                    <h1 id="page-title"><span><?php bbp_reply_title(); ?></span></h1>
                <?php } ?>
                <?php do_action('bbp_template_notices'); ?>

	<?php if ( bbp_user_can_view_forum( array( 'forum_id' => bbp_get_reply_forum_id() ) ) ) : ?>

                <?php while (have_posts()) : the_post(); ?>
                    <div id="bbp-reply-wrapper-<?php bbp_reply_id(); ?>" class="bbp-reply-wrapper">
                        <div class="entry-content">
                            <table class="bbp-replies" id="topic-<?php bbp_topic_id(); ?>-replies">
                                <thead>
                                    <tr>
                                        <th class="bbp-reply-author"><?php _e('Author', 'bbpress'); ?></th>
                                        <th class="bbp-reply-content"><?php _e('Replies', 'bbpress'); ?></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td colspan="2"><?php bbp_topic_admin_links(); ?></td>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <tr class="bbp-reply-header">
                                        <td class="bbp-reply-author">
                                            <?php bbp_reply_author_display_name(); ?>
                                        </td>
                                        <td class="bbp-reply-content">
                                            <a href="<?php bbp_reply_url(); ?>" title="<?php bbp_reply_title(); ?>">#</a>
                                            <?php printf(__('Posted on %1$s at %2$s', 'bbpress'), get_the_date(), esc_attr(get_the_time())); ?>
                                            <span><?php bbp_reply_admin_links(); ?></span>
                                        </td>
                                    </tr>
                                    <tr id="reply-<?php bbp_reply_id(); ?>" <?php bbp_reply_class(); ?>>
                                        <td class="bbp-reply-author"><?php bbp_reply_author_link(array('type' => 'avatar')); ?></td>
                                        <td class="bbp-reply-content">
                                            <?php bbp_reply_content(); ?>
                                        </td>
                                   </tr><!-- #topic-<?php bbp_topic_id(); ?>-replies -->
                                </tbody>
                            </table>
                        </div><!-- .entry-content -->
                    </div><!-- #bbp-reply-wrapper-<?php bbp_reply_id(); ?> -->
                <?php endwhile; ?>
	<?php elseif ( bbp_is_forum_private( bbp_get_reply_forum_id(), false ) ) : ?>

		<?php bbp_get_template_part( 'feedback', 'no-access' ); ?>

	<?php endif; ?>

	<?php do_action( 'bbp_after_main_content' ); ?>
            </div>
        </div>
        <div class="content-aside">
            <div class="skin">      
                <?php
                if (!isset($options['aktiv-circleplayer']))
                    $options['aktiv-circleplayer'] = $defaultoptions['aktiv-circleplayer'];
                if ($options['aktiv-circleplayer'] == 1) {
                    piratenkleider_echo_player();
                }
                get_sidebar('bbpress');
                ?>
            </div>
        </div>
    </div>
    <?php get_piratenkleider_socialmediaicons(2); ?>
</div>
<?php get_footer(); ?> 
