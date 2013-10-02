<?php
/**
 * Topics Loop
 *
 * @package bbPress
 * @subpackage Theme
 */
?>
<?php
$stickCount = 0;
$normalCount = 0;
while (bbp_topics()) : bbp_the_topic();
    if (bbp_is_topic_sticky()) {
        $stickCount++;
    } else {
        $normalCount++;
    }
endwhile;
?>
<?php do_action('bbp_template_before_topics_loop'); ?>
<div class="tborder topic_table" id="messageindex">
    <table class="table_grid" cellspacing="0">
        <thead>
            <tr class="catbg">
                <th scope="col" class="lefttext">Assunto / Iniciado por</th>
                <th scope="col" width="14%">Respostas / Participantes</th>
                <th scope="col" class="lefttext" width="22%">&Uacute;ltima mensagem</th>
<?php if (( bbp_is_user_home() && ( bbp_is_favorites() || bbp_is_subscriptions() ))) : ?><th class="bbp-topic-action"><?php _e('Remove', 'bbpress'); ?></th><?php endif; ?>
            </tr>
        </thead>
        <tbody>
<?php if ($stickCount > 0) { ?>
                <tr class="titlebg"><td colspan="<?php echo ( bbp_is_user_home() && ( bbp_is_favorites() || bbp_is_subscriptions() ) ) ? '4' : '3'; ?>" style="padding:8px 4px;">T&oacute;picos Importantes</td></tr>
                <?php
                while (bbp_topics()) : bbp_the_topic();
                    if (bbp_is_topic_sticky()) {
                        bbp_get_template_part('loop', 'single-topic');
                    }
                endwhile;
                ?>
                <tr class="titlebg"><td colspan="<?php echo ( bbp_is_user_home() && ( bbp_is_favorites() || bbp_is_subscriptions() ) ) ? '4' : '3'; ?>" style="padding:8px 4px;">T&oacute;picos Normais</td></tr>
                <?php
            }
            while (bbp_topics()) : bbp_the_topic();
                if (!bbp_is_topic_sticky()) {
                    bbp_get_template_part('loop', 'single-topic');
                }
            endwhile;
            ?>

        </tbody>

    </table><!-- #bbp-forum-<?php bbp_topic_id(); ?> -->
</div>
<?php do_action('bbp_template_after_topics_loop'); ?>
