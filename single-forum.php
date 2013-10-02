<?php
/**
 * Single Forum
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
            <?php $image_url = piratenkleider_get_cover(bbp_get_forum_title(), get_the_ID()); ?>
            <div class="skin">
                <?php do_action('bbp_before_main_content'); ?>
                <?php if (!(isset($image_url) && (strlen($image_url) > 4))) { ?>
                    <h1 id="page-title"><span><?php bbp_forum_title(); ?></span></h1>
                <?php } ?>
                <?php do_action('bbp_template_notices'); ?>
                <?php while (have_posts()) : the_post(); ?>
                    <?php if (bbp_user_can_view_forum()) : ?>
                        <div id="forum-<?php bbp_forum_id(); ?>" class="bbp-forum-content">
                            <div class="entry-content">
                                <?php bbp_get_template_part('content', 'single-forum'); ?>
                            </div>
                        </div><!-- #forum-<?php bbp_forum_id(); ?> -->
                    <?php else : // Forum exists, user no access  ?>
                        <?php bbp_get_template_part('feedback', 'no-access'); ?>
                    <?php endif; ?>
                <?php endwhile; ?>
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