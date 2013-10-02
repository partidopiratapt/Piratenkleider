<?php
/**
 * Template Name: bbPress - User Login
 *
 * @package bbPress
 * @subpackage Theme
 */
// No logged in users
bbp_logged_in_redirect();
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
                    <div id="bbp-login" class="bbp-login">
                        <div class="entry-content">
                            <?php the_content(); ?>
                            <div id="bbpress-forums">
                                <?php bbp_get_template_part('form', 'user-login'); ?>
                            </div>
                        </div>
                    </div><!-- #bbp-login -->
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