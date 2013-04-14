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

        <div id="bbp-topic-tags" class="bbp-topic-tags">
            <div class="entry-content">

                <?php get_the_content() ? the_content() : _e('<p>This is a collection of tags that are currently popular on our forums.</p>', 'bbpress'); ?>

                <div id="bbp-topic-hot-tags">

                    <?php wp_tag_cloud(array('smallest' => 9, 'largest' => 38, 'number' => 80, 'taxonomy' => $bbp->topic_tag_id)); ?>

                </div>

            </div>
        </div><!-- #bbp-topic-tags -->

    <?php endwhile; ?>
</div>
<?php get_template_part('page-footer') ?>