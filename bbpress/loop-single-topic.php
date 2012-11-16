<?php
/**
 * Topics Loop - Single
 *
 * @package bbPress
 * @subpackage Theme
 */
?>

<tr>
    <td class="subject windowbg2">
        <div id="topic_9104" onmouseout="mouse_on_div = 0;" onmouseover="mouse_on_div = 1;" ondblclick="modify_topic('1706', '9104');">

<?php do_action( 'bbp_theme_before_topic_title' ); ?>
            <a href="<?php bbp_topic_permalink(); ?>" title="<?php bbp_topic_title(); ?>"><?php bbp_topic_title(); ?></a>
            <p>Iniciado por <?php echo bbp_get_topic_author_link(array('type' => 'name')) ?>
                <small id="pages9104">&#171; <?php bbp_topic_pagination(); ?> &#187;</small>
            </p>
        </div>
<?php do_action( 'bbp_theme_after_topic_meta' ); ?>
    </td>
    <td class="stats windowbg">
        <?php bbp_show_lead_topic() ? bbp_topic_reply_count() : bbp_topic_post_count(); ?> Respostas
        <br />
        <?php bbp_topic_voice_count(); ?> Participantes
    </td>
    <td class="lastpost windowbg2">
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
        echo $last_active;
        ?><br />
        por <?php bbp_author_link(array('post_id' => bbp_get_topic_last_active_id(), 'type' => 'name')); ?>
    </td>

    <?php if (bbp_is_user_home()) : ?>

        <?php if (bbp_is_favorites()) : ?>

            <td class="bbp-topic-action">

					<?php do_action( 'bbp_theme_before_topic_favorites_action' ); ?>

                <?php bbp_user_favorites_link(array('mid' => '+', 'post' => ''), array('pre' => '', 'mid' => '&times;', 'post' => '')); ?>

					<?php do_action( 'bbp_theme_after_topic_favorites_action' ); ?>

            </td>

        <?php elseif (bbp_is_subscriptions()) : ?>

            <td class="bbp-topic-action">

					<?php do_action( 'bbp_theme_before_topic_subscription_action' ); ?>

                <?php bbp_user_subscribe_link(array('before' => '', 'subscribe' => '+', 'unsubscribe' => '&times;')); ?>

					<?php do_action( 'bbp_theme_after_topic_subscription_action' ); ?>

            </td>

        <?php endif; ?>

    <?php endif; ?>

</tr><!-- #topic-<?php bbp_topic_id(); ?> -->
