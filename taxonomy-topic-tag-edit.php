<?php get_template_part('page-header') ?>        
<div class="content-header">            
    <h1 id="page-title"><span><?php printf(__('Topic Tag: %s', 'bbpress'), '<span>' . bbp_get_topic_tag_name() . '</span>'); ?></span></h1>

    <?php
    if (has_post_thumbnail()) {
        echo '<div class="symbolbild">';
        the_post_thumbnail();
        echo '</div>';
    } else {
        if ($options['aktiv-defaultseitenbild'] == 1) {
            $bilderoptions = get_option('piratenkleider_theme_defaultbilder');
            $defaultbildsrc = $bilderoptions['seiten-defaultbildsrc'];
            if (isset($defaultbildsrc) && (strlen($defaultbildsrc) > 4)) {
                echo '<div class="symbolbild">';
                echo '<img src="' . $defaultbildsrc . '"  alt="">';
                echo '</div>';
            }
        }
    }
    ?>
</div>
<div class="skin">

<?php do_action('bbp_template_notices'); ?>

    <div id="topic-tag" class="bbp-topic-tag">

        <div class="entry-content">

            <?php bbp_topic_tag_description(); ?>

            <?php do_action('bbp_template_before_topic_tag_edit'); ?>

            <?php bbp_get_template_part('form', 'topic-tag'); ?>

            <?php do_action('bbp_template_after_topic_tag_edit'); ?>

        </div>
    </div><!-- #topic-tag -->
</div>
<?php get_template_part('page-footer') ?>    