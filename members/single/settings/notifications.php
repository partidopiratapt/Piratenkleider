<?php
get_header();
global $defaultoptions;
global $options;
?>
<div class="section content" id="main-content">
    <div class="row">
        <div class="content-primary">            
            <div class="content-header-big">
                <?php locate_template(array('members/single/member-header.php'), true); ?>
                <div id="item-nav">
                    <div class="item-list-tabs no-ajax" id="object-nav" role="navigation">
                        <ul>
                            <?php bp_get_displayed_user_nav(); ?>
                            <?php do_action('bp_member_options_nav'); ?>
                        </ul>
                    </div>
                </div><!-- #item-nav -->
            </div><!-- #item-header -->
            <div class="skin">
                <?php do_action('bp_before_member_settings_template'); ?>

                    <form action="<?php echo bp_displayed_user_domain() . bp_get_settings_slug() . '/notifications'; ?>" method="post" class="standard-form" id="settings-form">
	<p><?php _e( 'Send an email notice when:', 'buddypress' ); ?></p>

                        <?php do_action('bp_notification_settings'); ?>
                        <?php do_action('bp_members_notification_settings_before_submit'); ?>
                        <div class="submit">
		<input type="submit" name="submit" value="<?php esc_attr_e( 'Save Changes', 'buddypress' ); ?>" id="submit" class="auto" />
                        </div>
                        <?php do_action('bp_members_notification_settings_after_submit'); ?>
                        <?php wp_nonce_field('bp_settings_notifications'); ?>
                    </form>

                <?php do_action('bp_after_member_settings_template'); ?>
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