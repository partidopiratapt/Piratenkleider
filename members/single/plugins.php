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
                <?php do_action('bp_before_member_plugin_template'); ?>
                <div id="item-body" role="main">
                    <?php do_action('bp_before_member_body'); ?>
                    <div class="item-list-tabs no-ajax" id="subnav">
                        <ul>
                            <?php bp_get_options_nav(); ?>
                            <?php do_action('bp_member_plugin_options_nav'); ?>
                        </ul>
                    </div><!-- .item-list-tabs -->
                    <h3><?php do_action('bp_template_title'); ?></h3>
                    <?php do_action('bp_template_content'); ?>
                    <?php do_action('bp_after_member_body'); ?>
                </div><!-- #item-body -->
                <?php do_action('bp_after_member_plugin_template'); ?>
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