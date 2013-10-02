<?php
/**
 * Single Topic
 *
 * @package bbPress
 * @subpackage Theme
 */
get_header();
global $defaultoptions;
global $options;
?>
<div class="section content" id="main-content">
    <div class="row">
        <div class="content-primary">            
            <?php $image_url = piratenkleider_get_cover(bbp_get_topic_title(), get_the_ID()); ?>
            <div class="skin">
                <?php do_action('bbp_before_main_content'); ?>
                <?php if (!(isset($image_url) && (strlen($image_url) > 4))) { ?>
                    <h1 id="page-title"><span><?php bbp_topic_title(); ?></span></h1>
                <?php } ?>
                <?php do_action('bbp_template_notices'); ?>
                <?php if (bbp_user_can_view_forum(array('forum_id' => bbp_get_topic_forum_id()))) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <div id="bbp-topic-wrapper-<?php bbp_topic_id(); ?>" class="bbp-topic-wrapper">
                            <div class="entry-content">
                                <?php bbp_get_template_part('content', 'single-topic'); ?>
                            </div>
                        </div><!-- #bbp-topic-wrapper-<?php bbp_topic_id(); ?> -->
                    <?php endwhile; ?>
                <?php elseif (bbp_is_forum_private(bbp_get_topic_forum_id(), false)) : ?>
                    <?php bbp_get_template_part('feedback', 'no-access'); ?>
                <?php endif; ?>
                <?php do_action('bbp_after_main_content'); ?>
            </div>
        </div>
        <div class="content-aside">
            <div class="skin">      
                <?php
                if (!isset($options['aktiv-circleplayer']))
                    $options['aktiv-circleplayer'] = $defaultoptions['aktiv-circleplayer'];
                if ($options['aktiv-circleplayer'] == 1) {
                    piratenkleider_echo_player();
                }
                get_sidebar('bbpress');
                ?>
            </div>
        </div>
    </div>
    <?php get_piratenkleider_socialmediaicons(2); ?>
</div>
<?php get_footer(); ?>  