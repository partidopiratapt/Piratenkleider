<?php get_template_part('page-header') ?>
<div class="content-header">            
    <h1 id="page-title"><span><?php _e('Create a Site', 'buddypress'); ?></span></h1>

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
<?php do_action( 'bp_before_directory_blogs_content' ); ?>
<div class="skin">

    <?php do_action('bp_before_create_blog_content_template'); ?>

    <?php do_action('template_notices'); ?>

			<h3><?php _e( 'Create a Site', 'buddypress' ); ?> &nbsp;<a class="button" href="<?php echo trailingslashit( bp_get_root_domain() . '/' . bp_get_blogs_root_slug() ); ?>"><?php _e( 'Site Directory', 'buddypress' ); ?></a></h3>

    <?php do_action('bp_before_create_blog_content'); ?>

    <?php if (bp_blog_signup_enabled()) : ?>

        <?php bp_show_blog_signup_form(); ?>

    <?php else: ?>

        <div id="message" class="info">
            <p><?php _e('Site registration is currently disabled', 'buddypress'); ?></p>
        </div>

    <?php endif; ?>

    <?php do_action('bp_after_create_blog_content'); ?>

    <?php do_action('bp_after_create_blog_content_template'); ?>

</div>
<?php do_action( 'bp_after_directory_blogs_content' ); ?>
<?php get_template_part('page-footer') ?>