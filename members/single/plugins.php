<?php
/**
 * BuddyPress - Users Plugins Template
 *
 * 3rd-party plugins should use this template to easily add template
 * support to their plugins for the members component.
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */
get_header();
global $defaultoptions;
global $options;
?>
<div class="section content" id="main-content">
    <div class="row">
        <div class="content-primary">            
            <div class="content-header-big">
                <div id="buddypress">
                    <div id="item-header" role="complementary">
                        <?php locate_template(array('members/single/member-header.php'), true); ?>
                    </div><!-- #item-header -->
                    <div id="item-nav">
                        <div class="item-list-tabs no-ajax" id="object-nav" role="navigation">
                            <ul>
                                <?php bp_get_displayed_user_nav(); ?>
                                <?php do_action('bp_member_options_nav'); ?>
                            </ul>
                        </div>
                    </div><!-- #item-nav -->
                </div>
            </div><!-- #item-header -->
            <div class="skin">
                <div id="buddypress">
                    <div id="item-body" role="main">
                        <?php do_action('bp_before_member_plugin_template'); ?>

                        <?php if (!bp_is_current_component_core()) : ?>

                            <div class="item-list-tabs no-ajax" id="subnav">
                                <ul>
                                    <?php bp_get_options_nav(); ?>
                                    <?php do_action('bp_member_plugin_options_nav'); ?>
                                </ul>
                            </div><!-- .item-list-tabs -->

                        <?php endif; ?>

                        <h3><?php do_action('bp_template_title'); ?></h3>
                        <?php do_action('bp_template_content'); ?>

                        <?php do_action('bp_after_member_plugin_template'); ?>
                    </div>
                </div><!-- #buddypress -->
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