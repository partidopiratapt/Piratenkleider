<?php
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
                        <h1 class="post-title"><span><?php bp_group_hierarchy_group_tree_name(); ?></span></h1>
                        <div id="item-header-content">
                            <div id="item-meta">
                                <div id="item-buttons">
                                    <h3><?php if (is_user_logged_in() && bp_user_can_create_groups()) : ?><a class="button" href="<?php echo trailingslashit(bp_get_root_domain() . '/' . bp_get_groups_root_slug() . '/create'); ?>"><?php _e('Create a Group', 'buddypress') ?></a><?php endif; ?></h3>
                                    <?php do_action('bp_before_directory_groups_content'); ?>
                                    <div id="group-dir-search" class="dir-search" role="search">
                                        <?php bp_directory_groups_search_form(); ?>
                                    </div><!-- #group-dir-search -->
                                </div><!-- #item-buttons -->
                            </div><!-- #item-meta -->
                        </div><!-- #item-header-content -->
                        <div class="symbolbild"><img src="<?php echo get_theme_root_uri() ?>/piratenkleider/images/default-author.png" title=""></div>
                    </div><!-- #item-header -->
                    <div id="item-nav">
                        <div class="item-list-tabs" role="navigation">
                            <ul>
                                <li class="selected" id="tree-all"><a href="<?php echo bp_get_root_domain() . '/' . bp_get_groups_root_slug() ?>"><?php bp_group_hierarchy_group_tree_name(); ?></a></li>
                                <?php if (is_user_logged_in() && bp_get_total_group_count_for_user(bp_loggedin_user_id())) : ?>
                                    <li id="groups-personal"><a href="<?php echo trailingslashit(bp_loggedin_user_domain() . bp_get_groups_root_slug() . '/my-groups'); ?>"><?php printf(__('My Groups <span>%s</span>', 'buddypress'), bp_get_total_group_count_for_user(bp_loggedin_user_id())); ?></a></li>
                                <?php endif; ?>
                                <?php do_action('bp_groups_directory_group_filter'); ?>
                            </ul>
                        </div><!-- .item-list-tabs -->
                    </div><!-- #item-nav -->
                </div>
            </div><!-- #item-header -->

            <div class="skin">
                <?php do_action('bp_before_directory_groups_page'); ?>
                <div id="buddypress">
                    <?php do_action('bp_before_directory_groups'); ?>

                    <form action="" method="post" id="groups-directory-form" class="dir-form">
                        <?php do_action('template_notices'); ?>
                        <div class="item-list-tabs" id="subnav" role="navigation">
                            <ul>
                                <?php do_action('bp_groups_directory_group_types'); ?>
                                <li id="groups-order-select" class="last filter">
                                    <label for="groups-order-by"><?php _e('Order By:', 'buddypress'); ?></label>
                                    <select id="groups-order-by">
                                        <option value="active"><?php _e('Last Active', 'buddypress'); ?></option>
                                        <option value="popular"><?php _e('Most Members', 'buddypress'); ?></option>
                                        <option value="newest"><?php _e('Newly Created', 'buddypress'); ?></option>
                                        <option value="alphabetical"><?php _e('Alphabetical', 'buddypress'); ?></option>
                                        <?php do_action('bp_groups_directory_order_options'); ?>
                                    </select>
                                </li>
                            </ul>
                        </div><!-- .item-list-tabs -->
                        <div id="groups-dir-list" class="groups dir-list">
                            <?php
                            $loop_template = apply_filters('bp_located_template', locate_template(array("tree/tree-loop.php"), false), "tree/tree-loop.php");
                            load_template($loop_template);
                            ?>
                        </div><!-- #groups-dir-list -->
                        <?php do_action('bp_directory_groups_content'); ?>
                        <?php wp_nonce_field('directory_groups', '_wpnonce-groups-filter'); ?>
                        <?php do_action('bp_after_directory_groups_content'); ?>
                    </form><!-- #groups-directory-form -->
                    <?php do_action('bp_after_directory_groups'); ?>
                    <?php do_action('bp_after_directory_groups_page'); ?>
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
