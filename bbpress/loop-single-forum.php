<?php
/**
 * Forums Loop - Single Forum
 *
 * @package bbPress
 * @subpackage Theme
 */
$url = "";
if (get_option('permalink_structure')) {

    // Forum link
    $url = trailingslashit(bbp_get_forum_permalink()) . 'feed';
    $url = user_trailingslashit($url, 'single_feed');
    $url = add_query_arg(array('type' => 'reply'), $url);

    // Unpretty permalinks
} else {
    $url = home_url(add_query_arg(array(
                'type' => 'reply',
                'feed' => 'rss2',
                bbp_get_forum_post_type() => get_post_field('post_name', bbp_get_forum_id())
            )));
}
?>
<tr id="bbp-forum-<?php bbp_forum_id(); ?>"  class="windowbg2">
    <td class="icon windowbg" <?php if (bbp_forum_get_subforums()) { ?> rowspan="2" <?php } ?>>
        
        <img width="49" height="49" src="<?php echo get_template_directory_uri() ?>/images/Lightbrown-Pirates-icon.png" alt="Não há novas mensagens" title="Não há novas mensagens">
    </td>

    <td class="bbp-forum-info">
        <a class="bbp-forum-title" href="<?php bbp_forum_permalink(); ?>" title="<?php bbp_forum_title(); ?>"><?php bbp_forum_title(); ?></a>&nbsp; <a href="<?php echo $url; ?>">
            <img style="margin: 0 0 0 0;" alt="rss" width="12" height="12" src="<?php echo get_template_directory_uri() ?>/images/social-media/feed-24x24.png">
        </a>
        <p><?php
$content = get_the_content($more_link_text, $stripteaser);
echo $content;
?></p>
    </td>
    <td class="stats windowbg">
        <p><?php bbp_show_lead_topic() ? bbp_forum_reply_count() : bbp_forum_post_count($id); ?> Mensagens <br />
            <?php bbp_forum_topic_count(); ?> Tópicos
        </p>
    </td>
    <td class="lastpost">
        <?php if (bbp_get_forum_topic_count() > 0) { ?>
            <p><strong>Última mensagem</strong> por <?php bbp_author_link(array('post_id' => bbp_get_forum_last_active_id($id), 'type' => 'name')); ?><br />
                em <?php $reply_id = bbp_get_forum_last_reply_id(); ?>
                <a href="<?php bbp_reply_permalink($reply_id) ?>" title="<?php bbp_reply_title($reply_id); ?>"><?php
        $limit = 22;
        $summary = bbp_get_reply_title($reply_id);

        if (strlen($summary) > $limit) {
            $summary = substr($summary, 0, $limit) . '...';
            echo $summary;
        } else
            echo $summary;
            ?></a><br />
                em <?php
                $last_active = get_post_meta(bbp_get_forum_id(), '_bbp_last_active_time', true);
                if (empty($last_active)) {
                    $reply_id = bbp_get_forum_last_reply_id();
                    if (!empty($reply_id)) {
                        $last_active = get_post_field('post_date', $reply_id);
                    } else {
                        $topic_id = bbp_get_forum_last_topic_id();
                        if (!empty($topic_id)) {
                            $last_active = bbp_get_topic_last_active_time($topic_id);
                        }
                    }
                }
                echo $last_active;
            ?> 
            </p>
        <?php } ?>
    </p>
</td>

</tr><!-- bbp-forum-<?php bbp_forum_id(); ?> -->
<?php
if (bbp_forum_get_subforums()) {
    ?>
    <tr id="board_children">
        <td colspan="3" class="children windowbg">
            <?php
            $defaults = array(
                'before' => '<strong>Sub-Quadro</strong>: ',
                'after' => '',
                'link_before' => '',
                'link_after' => '',
                'separator' => ', ',
                'forum_id' => '',
                'show_topic_count' => false,
                'show_reply_count' => false,
            );
            bbp_list_forums($defaults);
            ?>

        </td>
    </tr>
    <?php
}
?>
