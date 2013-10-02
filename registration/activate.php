<?php
get_header();
global $defaultoptions;
global $options;
?>
<div class="section content" id="main-content">
    <div class="row">
        <div class="content-primary">            
            <?php
            $image_url = piratenkleider_get_cover((bp_account_was_activated()) ? _e('Account Activated', 'buddypress') : _e('Activate your Account', 'buddypress'), get_the_ID());
            ?>
            <div class="skin">
                <?php do_action('bp_before_activation_page'); ?>
                <?php if (!(isset($image_url) && (strlen($image_url) > 4))) { ?>
                    <h1 id="page-title"><span><?php if (bp_account_was_activated()) {
                    _e('Account Activated', 'buddypress');
                } else {
                    _e('Activate your Account', 'buddypress');
                } ?></span></h1>
                    <?php } ?>
                <div class="page" id="activate-page">
                    <?php do_action('template_notices'); ?>
                    <?php do_action('bp_before_activate_content'); ?>
                    <?php if (bp_account_was_activated()) : ?>
                        <?php if (isset($_GET['e'])) : ?>
                            <p><?php _e('Your account was activated successfully! Your account details have been sent to you in a separate email.', 'buddypress'); ?></p>
    <?php else : ?>
                            <p><?php printf(__('Your account was activated successfully! You can now <a href="%s">log in</a> with the username and password you provided when you signed up.', 'buddypress'), wp_login_url(bp_get_root_domain())); ?></p>
    <?php endif; ?>
<?php else : ?>
                        <p><?php _e('Please provide a valid activation key.', 'buddypress'); ?></p>
                        <form action="" method="get" class="standard-form" id="activation-form">
                            <label for="key"><?php _e('Activation Key:', 'buddypress'); ?></label>
                            <input type="text" name="key" id="key" value="" />
                            <p class="submit">
                                <input type="submit" name="submit" value="<?php _e('Activate', 'buddypress'); ?>" />
                            </p>
                        </form>
<?php endif; ?>
<?php do_action('bp_after_activate_content'); ?>
                </div><!-- .page -->
                <?php do_action('bp_after_activation_page'); ?>
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
                get_sidebar('buddypress');
                ?>
            </div>
        </div>
    </div>
<?php get_piratenkleider_socialmediaicons(2); ?>
</div>
<?php get_footer(); ?>