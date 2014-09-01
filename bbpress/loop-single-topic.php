<?php
/**
 * Topics Loop - Single
 *
 * @package bbPress
 * @subpackage Theme
 */
?>
<tr>
    <td class="subject">
        <div id="topic_<?php bbp_topic_id(); ?>">
            <span id="msg_<?php bbp_topic_id(); ?>"><a href="<?php bbp_topic_permalink(); ?>"><?php bbp_topic_title(); ?></a></span>
            <p>Iniciado por <?php echo bbp_get_topic_author_link(array('type' => 'name')) ?>
                <small id="pages<?php bbp_topic_id(); ?>"><?php bbp_topic_pagination(array('before'=>'&#171; ', 'after'=>' &#187;')); ?></small>
            </p>
        </div>
    </td>
    <td class="stats">
        <?php bbp_topic_reply_count(); ?> Respostas
        <br />
        <?php bbp_topic_voice_count(); ?> Participantes
    </td>
    <td class="lastpost">
        <?php
        $last_active = get_post_meta(bbp_get_topic_id(), '_bbp_last_active_time', true);
    if (empty($last_active)) {
        $reply_id = bbp_get_topic_last_reply_id(bbp_get_topic_id());
        if (!empty($reply_id)) {
            $last_active = get_post_field('post_date', $reply_id);
        } else {
            $last_active = get_post_field('post_date', bbp_get_topic_id());
        }
    }
    $time = strtotime($last_active);
        echo date('d', $time) . ' de ' . meses(date('m', $time)) . ' de ' . date('Y, H:i:s', $time);
        ?><br />
        por <?php bbp_author_link(array('post_id' => bbp_get_topic_last_active_id(), 'type' => 'name')); ?>
    </td>
    <?php if (bbp_is_user_home()) : ?>
        <?php if (bbp_is_favorites()) : ?>
            <td class="bbp-row-action">
<?php do_action( 'bbp_theme_before_topic_favorites_action' ); ?>

					<?php bbp_topic_favorite_link( array( 'before' => '', 'favorite' => '+', 'favorited' => '&times;' ) ); ?>

<?php do_action( 'bbp_theme_after_topic_favorites_action' ); ?>
            </td>
        <?php elseif (bbp_is_subscriptions()) : ?>
            <td class="bbp-row-action">
<?php do_action( 'bbp_theme_before_topic_subscription_action' ); ?>

					<?php bbp_topic_subscription_link( array( 'before' => '', 'subscribe' => '+', 'unsubscribe' => '&times;' ) ); ?>

<?php do_action( 'bbp_theme_after_topic_subscription_action' ); ?>
            </td>
        <?php endif; ?>
    <?php endif; ?>
</tr><!-- #topic-<?php bbp_topic_id(); ?> -->
