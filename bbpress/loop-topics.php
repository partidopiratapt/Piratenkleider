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

<table class="table_grid" cellspacing="0">
    <thead>
        <tr>
            <th class="bbp-topic-title">Assunto / Iniciado por</th>
            <th class="bbp-topic-count">Respostas / Participantes</th>
            <th class="bbp-topic-freshness">&Uacute;ltima mensagem</th>
            <?php if (( bbp_is_user_home() && ( bbp_is_favorites() || bbp_is_subscriptions() ))) : ?><th class="bbp-topic-action"><?php _e('Remove', 'bbpress'); ?></th><?php endif; ?>
        </tr>
    </thead>

    <tfoot>
        <tr><td colspan="<?php echo ( bbp_is_user_home() && ( bbp_is_favorites() || bbp_is_subscriptions() ) ) ? '4' : '3'; ?>">&nbsp;</td></tr>
    </tfoot>

    <tbody>

        <?php if ($stickCount > 0) { ?>
            <tr><th colspan="<?php echo ( bbp_is_user_home() && ( bbp_is_favorites() || bbp_is_subscriptions() ) ) ? '4' : '3'; ?>">Tópicos Importantes</th></tr>
            <?php
            while (bbp_topics()) : bbp_the_topic();
                if (bbp_is_topic_sticky()) {
                    bbp_get_template_part('bbpress/loop', 'single-topic');
                }
            endwhile;
            ?>
            <tr><th colspan="<?php echo ( bbp_is_user_home() && ( bbp_is_favorites() || bbp_is_subscriptions() ) ) ? '4' : '3'; ?>">Tópicos Normais</th></tr>
            <?php
        }

        while (bbp_topics()) : bbp_the_topic();
            if (!bbp_is_topic_sticky()) {
                bbp_get_template_part('bbpress/loop', 'single-topic');
            }
        endwhile;
        ?>

    </tbody>

</table><!-- #bbp-forum-<?php bbp_topic_id(); ?> -->

<?php do_action('bbp_template_after_topics_loop'); ?>
