<?php
/**
 * Edit handler for topics
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
                <?php while (have_posts()) : the_post(); ?>
                    <div id="bbp-edit-page" class="bbp-edit-page">
                        <div class="entry-content">
                            <?php bbp_get_template_part('form', 'topic'); ?>
                        </div>
                    </div><!-- #bbp-edit-page -->
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