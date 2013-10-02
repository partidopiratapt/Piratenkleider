<?php
get_header();
global $defaultoptions;
global $options;
?>
<div class="section content" id="main-content">
    <div class="row">
        <div class="content-primary">            
            <?php if (bp_has_groups()) : while (bp_groups()) : bp_the_group(); ?>
                    <div class="content-header-big">
                        <?php locate_template(array('groups/single/group-header.php'), true); ?>
                        <div id="item-nav">
                            <div class="item-list-tabs no-ajax" id="object-nav" role="navigation">
                                <ul>
                                    <?php bp_get_options_nav(); ?>
                                    <?php do_action('bp_group_plugin_options_nav'); ?>
                                </ul>
                            </div>
                        </div><!-- #item-nav -->
                    </div><!-- #item-header -->
                    <div class="skin">
                        <?php do_action('bp_before_group_plugin_template'); ?>
                        <div id="item-body">
                            <?php do_action('bp_before_group_body'); ?>
                            <?php do_action('bp_template_content'); ?>
                            <?php do_action('bp_after_group_body'); ?>
                        </div><!-- #item-body -->
                        <?php do_action('bp_after_group_plugin_template'); ?>
                    </div>
                    <?php
                endwhile;
            endif;
            ?>
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