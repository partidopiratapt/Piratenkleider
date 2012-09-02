<?php get_template_part('page-header') ?>     
<div class="content-header">            
    <h1 id="page-title"><span><?php the_title(); ?></span></h1>

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

<?php while (have_posts()) : the_post(); ?>

        <div id="topics-front" class="bbp-topics-front">
            <div class="entry-content">

                <?php the_content(); ?>

                <?php bbp_set_query_name('bbp_no_replies'); ?>

                <?php if (bbp_has_topics(array('meta_key' => '_bbp_reply_count', 'meta_value' => '1', 'meta_compare' => '<', 'orderby' => 'date', 'show_stickies' => false))) : ?>

                    <?php bbp_get_template_part('bbpress/pagination', 'topics'); ?>

                    <?php bbp_get_template_part('bbpress/loop', 'topics'); ?>

                    <?php bbp_get_template_part('bbpress/pagination', 'topics'); ?>

                <?php else : ?>

                    <?php bbp_get_template_part('bbpress/feedback', 'no-topics'); ?>

                <?php endif; ?>

    <?php bbp_reset_query_name(); ?>

            </div>
        </div><!-- #topics-front -->

<?php endwhile; ?>

</div>
<?php get_template_part('page-footer') ?>