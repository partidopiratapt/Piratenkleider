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
                <?php do_action('bp_before_member_home_content'); ?>
                <div id="item-body">
                    <?php
                    do_action('bp_before_member_body');
                    if (bp_is_user_activity() || !bp_current_component()) :
                        locate_template(array('members/single/activity.php'), true);
                    elseif (bp_is_user_blogs()) :
                        locate_template(array('members/single/blogs.php'), true);
                    elseif (bp_is_user_friends()) :
                        locate_template(array('members/single/friends.php'), true);
                    elseif (bp_is_user_groups()) :
                        locate_template(array('members/single/groups.php'), true);
                    elseif (bp_is_user_messages()) :
                        locate_template(array('members/single/messages.php'), true);
                    elseif (bp_is_user_profile()) :
                        locate_template(array('members/single/profile.php'), true);
                    elseif (bp_is_user_forums()) :
                        locate_template(array('members/single/forums.php'), true);
                    elseif (bp_is_user_settings()) :
                        locate_template(array('members/single/settings.php'), true);
                    // If nothing sticks, load a generic template
                    else :
                        locate_template(array('members/single/plugins.php'), true);
                    endif;
                    do_action('bp_after_member_body');
                    ?>
                </div><!-- #item-body -->
                <?php do_action('bp_after_member_home_content'); ?>
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