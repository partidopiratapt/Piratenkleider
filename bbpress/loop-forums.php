<?php
/**
 * Forums Loop
 *
 * @package bbPress
 * @subpackage Theme
 */
?>

<?php do_action('bbp_template_before_forums_loop'); ?>
<?php
$cateCount = 0;
$forumCount = 0;
while (bbp_forums()) : bbp_the_forum();
    if (bbp_is_forum_category()) {
        $cateCount++;
    } else {
        $forumCount++;
    }
endwhile;
?>
<?php
if ($cateCount > 0) {
    while (bbp_forums()) : bbp_the_forum();
        if (bbp_is_forum_category()) {
            $subFs = bbp_forum_get_subforums();
        ?>
        <h3><?php bbp_forum_title(); ?></h3>

        <table class="bbp-forums">

            <thead>
                <tr>
                    <th class="bbp-forum-info"><?php _e('Forum', 'bbpress'); ?></th>
                    <th class="bbp-forum-topic-count"><?php _e('Topics', 'bbpress'); ?></th>
                    <th class="bbp-forum-reply-count"><?php bbp_show_lead_topic() ? _e('Replies', 'bbpress') : _e('Posts', 'bbpress'); ?></th>
                    <th class="bbp-forum-freshness"><?php _e('Freshness', 'bbpress'); ?></th>
                </tr>
            </thead>

            <tfoot>
                <tr><td colspan="4">&nbsp;</td></tr>
            </tfoot>

            <tbody>
                <?php
                        for ($i = 0;$i < count($subFs);$i++) {
                            echo $i;
                            $id = $subFs[$i]->ID;
                            echo $id;
                ?>
 	<tr id="bbp-forum-<?php bbp_forum_id($id); ?>" <?php bbp_forum_class($id); ?>>

		<td class="bbp-forum-info">

			<?php do_action( 'bbp_theme_before_forum_title' ); ?>

			<a class="bbp-forum-title" href="<?php bbp_forum_permalink($id); ?>" title="<?php bbp_forum_title($id); ?>"><?php bbp_forum_title($id); ?></a>

			<?php do_action( 'bbp_theme_after_forum_title' ); ?>
			<?php do_action( 'bbp_theme_before_forum_description' ); ?>

                        <div class="bbp-forum-description"><?php 
        echo $subFs[$i]->post_content; ?></div>

			<?php do_action( 'bbp_theme_after_forum_description' ); ?>

			<?php do_action( 'bbp_theme_before_forum_sub_forums' ); ?>

			<?php 
                        	$defaults = array (
		'before'            => '<div class="bbp-forums-list">&nbsp;&nbsp;&nbsp;&nbsp;Sub Quadro: ',
		'after'             => '</div>',
		'link_before'       => '',
		'link_after'        => '',
		'separator'         => ', ',
		'forum_id'          => $id,
		'show_topic_count'  => false,
		'show_reply_count'  => false,
	);
                        bbp_list_forums($defaults); ?>

			<?php do_action( 'bbp_theme_after_forum_sub_forums' ); ?>

		</td>

		<td class="bbp-forum-topic-count"><?php bbp_forum_topic_count($id); ?></td>

		<td class="bbp-forum-reply-count"><?php bbp_show_lead_topic() ? bbp_forum_reply_count($id) : bbp_forum_post_count($id); ?></td>

		<td class="bbp-forum-freshness">

			<?php do_action( 'bbp_theme_before_forum_freshness_link' ); ?>

			<?php bbp_forum_freshness_link($id); ?>

			<?php do_action( 'bbp_theme_after_forum_freshness_link' ); ?>

			<p class="bbp-topic-meta">

				<?php do_action( 'bbp_theme_before_topic_author' ); ?>

				<span class="bbp-topic-freshness-author"><?php bbp_author_link( array( 'post_id' => bbp_get_forum_last_active_id($id), 'size' => 14 ) ); ?></span>

				<?php do_action( 'bbp_theme_after_topic_author' ); ?>

			</p>
		</td>

	</tr><!-- bbp-forum-<?php bbp_forum_id($id); ?> -->
               
                <?php
                        }
                ?>
            </tbody>

        </table>

        <?php
        }
    endwhile;
}
?>
<?php
if ($forumCount > 0) {
    ?>
    <table class="bbp-forums">

        <thead>
            <tr>
                <th class="bbp-forum-info"><?php _e('Forum', 'bbpress'); ?></th>
                <th class="bbp-forum-topic-count"><?php _e('Topics', 'bbpress'); ?></th>
                <th class="bbp-forum-reply-count"><?php bbp_show_lead_topic() ? _e('Replies', 'bbpress') : _e('Posts', 'bbpress'); ?></th>
                <th class="bbp-forum-freshness"><?php _e('Freshness', 'bbpress'); ?></th>
            </tr>
        </thead>

        <tfoot>
            <tr><td colspan="4">&nbsp;</td></tr>
        </tfoot>

        <tbody>
            <?php
            while (bbp_forums()) : bbp_the_forum();

                if (!bbp_is_forum_category()) {
                    ?>
                    <?php bbp_get_template_part('bbpress/loop', 'single-forum'); ?>

                <?php
                }
            endwhile;
            ?>
        </tbody>

    </table>
    <?php }
?>


<?php do_action('bbp_template_after_forums_loop'); ?>