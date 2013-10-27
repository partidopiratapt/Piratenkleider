<?php
/**
 * Replies Loop - Single Reply
 *
 * @package bbPress
 * @subpackage Theme
 */
?>
<div class="windowbg">
    <div class="post_wrapper">
        <div class="poster">
            <?php do_action('bbp_theme_before_reply_author_details'); ?>
            <?php //bbp_reply_author_link(array('sep' => '<br />', 'show_role' => true)); ?>
            <h4 style="text-align: center;">
                <!-- <img src="http://www.forum.partidopiratapt.eu/Themes/mysticjade/images/useroff.gif" alt="Offline" style="margin: 0 0 0 0; vertical-align: middle; "> -->
                <a href="<?php bbp_reply_author_url(); ?>" title="Ver o perfil de <?php bbp_reply_author_display_name() ?>"><?php bbp_reply_author_display_name() ?></a>
            </h4>
            <ul class="reset smalltext" id="msg_396_extra_info">
                <li class="postgroup"><?php bbp_reply_author_role(); ?></li>
                <li class="avatar">
                    <a href="<?php bbp_reply_author_url(); ?>">
                        <?php bbp_reply_author_avatar(bbp_get_reply_id(), 80); ?>
                    </a>
                </li>
                <!-- <li class="postcount">Mensagens: <?php //bbp_reply  ?></li> -->
            </ul>
            <?php do_action('bbp_theme_after_reply_author_details'); ?>
        </div>
        <div class="postarea">
            <div class="flow_hidden">
                <div class="keyinfo">
                    <h5 id="subject_396">
                        <a href="<?php bbp_reply_url(); ?>" rel="nofollow"><?php bbp_reply_title(); ?></a>
                    </h5>
                    <div class="smalltext">« <strong> em:</strong> <?php printf(__('%1$s, %2$s', 'bbpress'), get_the_date(), get_the_time()); ?> »</div>
                </div>
                <ul class="reset smalltext quickbuttons">
                    <?php
                    $array = explode('|', bbp_get_reply_admin_links(array('before' => '', 'after' => '', 'sep' => '|', 'links' => array('edit' => bbp_get_reply_edit_link(), 'move' => bbp_get_reply_move_link(), 'split' => bbp_get_topic_split_link(), 'trash' => bbp_get_reply_trash_link(), 'spam' => bbp_get_reply_spam_link()))));
                    foreach ($array as $value) {
                            echo '<li>' . $value . '</li>';
                    }
                    ?>
                </ul>
            </div>
            <div class="post">
                <div class="inner">
                    <?php //do_action('bbp_theme_before_reply_content'); ?>
                    <?php bbp_reply_content(); ?>
                    <?php //do_action('bbp_theme_after_reply_content'); ?>
                </div>
            </div>
        </div>
        <div class="moderatorbar">
            <?php
            $assinatura = get_the_author_meta("_forum_signature", bbp_get_reply_author_id());
            if ($assinatura != '') {
            ?>
            <div class="signature"><?php echo do_shortcode($assinatura) ?></div>
            <?php } ?>
        </div>
    </div>
</div>