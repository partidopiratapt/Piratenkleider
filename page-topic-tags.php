<?php
/**
 * Template Name: bbPress - Topic Tags
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
            <?php $image_url = piratenkleider_get_cover(get_the_title(), get_the_ID()); ?>
            <div class="skin">
                <?php do_action('bbp_before_main_content'); ?>
                <?php if (!(isset($image_url) && (strlen($image_url) > 4))) { ?>
                    <h1 id="page-title"><span><?php the_title(); ?></span></h1>
                <?php } ?>
                <?php do_action('bbp_template_notices'); ?>
                <?php while (have_posts()) : the_post(); ?>
                    <div id="bbp-topic-tags" class="bbp-topic-tags">
                        <div class="entry-content">
                            <?php get_the_content() ? the_content() : _e('<p>This is a collection of tags that are currently popular on our forums.</p>', 'bbpress'); ?>
                            <div id="bbpress-forums">
                                <div id="bbp-topic-hot-tags">
                                    <?php wp_tag_cloud(array('smallest' => 9, 'largest' => 38, 'number' => 80, 'taxonomy' => bbp_get_topic_tag_tax_id())); ?>
                                </div>
                            </div>
                        </div>
                    </div><!-- #bbp-topic-tags -->
                <?php endwhile; ?>
            </div>
            <?php do_action('bbp_after_main_content'); ?>
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