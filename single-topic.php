<?php get_template_part('page-header') ?>        
<div class="content-header">            
    <h1 id="page-title"><span><?php bbp_topic_title(); ?></span></h1>

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

    <?php if (bbp_user_can_view_forum(array('forum_id' => bbp_get_topic_forum_id()))) : ?>

    <?php while (have_posts()) : the_post(); ?>

            <div id="bbp-topic-wrapper-<?php bbp_topic_id(); ?>" class="bbp-topic-wrapper">
                <div class="entry-content">

        <?php bbp_get_template_part('bbpress/content', 'single-topic'); ?>

                </div>
            </div><!-- #bbp-topic-wrapper-<?php bbp_topic_id(); ?> -->

        <?php endwhile; ?>

    <?php elseif (bbp_is_forum_private(bbp_get_topic_forum_id(), false)) : ?>

        <?php bbp_get_template_part('bbpress/feedback', 'no-access'); ?>

<?php endif; ?>

</div>
<?php get_template_part('page-footer') ?>    