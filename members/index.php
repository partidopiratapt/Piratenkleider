<?php
get_header();
global $defaultoptions;
$options = get_option('piratenkleider_theme_options');
if (!isset($options['aktiv-defaultseitenbild']))
    $options['aktiv-defaultseitenbild'] = $defaultoptions['aktiv-defaultseitenbild'];
?>

<?php do_action('bp_before_directory_members_page'); ?>
<div class="section content">
    <div class="row">
        <div class="content-primary">
            <div id="content">
                <?php do_action('bp_before_directory_members'); ?>

                <form action="" method="post" id="members-directory-form" class="dir-form">

                    <h3><?php _e('Members Directory', 'buddypress'); ?></h3>

                    <?php do_action('bp_before_directory_members_content'); ?>

                    <div id="members-dir-search" class="dir-search" role="search">

                        <?php bp_directory_members_search_form(); ?>

                    </div><!-- #members-dir-search -->

                    <div class="item-list-tabs" role="navigation">
                        <ul>
                            <li class="selected" id="members-all"><a href="<?php echo trailingslashit(bp_get_root_domain() . '/' . bp_get_members_root_slug()); ?>"><?php printf(__('All Members <span>%s</span>', 'buddypress'), bp_get_total_member_count()); ?></a></li>

                            <?php if (is_user_logged_in() && bp_is_active('friends') && bp_get_total_friend_count(bp_loggedin_user_id())) : ?>

                                <li id="members-personal"><a href="<?php echo bp_loggedin_user_domain() . bp_get_friends_slug() . '/my-friends/' ?>"><?php printf(__('My Friends <span>%s</span>', 'buddypress'), bp_get_total_friend_count(bp_loggedin_user_id())); ?></a></li>

                            <?php endif; ?>

                            <?php do_action('bp_members_directory_member_types'); ?>

                        </ul>
                    </div><!-- .item-list-tabs -->

                    <div class="item-list-tabs" id="subnav" role="navigation">
                        <ul>

                            <?php do_action('bp_members_directory_member_sub_types'); ?>

                            <li id="members-order-select" class="last filter">

                                <label for="members-order-by"><?php _e('Order By:', 'buddypress'); ?></label>
                                <select id="members-order-by">
                                    <option value="active"><?php _e('Last Active', 'buddypress'); ?></option>
                                    <option value="newest"><?php _e('Newest Registered', 'buddypress'); ?></option>

                                    <?php if (bp_is_active('xprofile')) : ?>

                                        <option value="alphabetical"><?php _e('Alphabetical', 'buddypress'); ?></option>

                                    <?php endif; ?>

                                    <?php do_action('bp_members_directory_order_options'); ?>

                                </select>
                            </li>
                        </ul>
                    </div>

                    <div id="members-dir-list" class="members dir-list">

                        <?php locate_template(array('members/members-loop.php'), true); ?>

                    </div><!-- #members-dir-list -->

                    <?php do_action('bp_directory_members_content'); ?>

                    <?php wp_nonce_field('directory_members', '_wpnonce-member-filter'); ?>

                    <?php do_action('bp_after_directory_members_content'); ?>

                </form><!-- #members-directory-form -->

                <?php do_action('bp_after_directory_members'); ?>
            </div><!-- #content -->
        </div>
        <div class="content-aside">
            <div class="skin">      

                <h1 class="skip"><?php echo $defaultoptions['default_text_title_sidebar']; ?></h1>

                <?php
                if (!isset($options['zeige_subpagesonly']))
                    $options['zeige_subpagesonly'] = $defaultoptions['zeige_subpagesonly'];

                if (!isset($options['zeige_sidebarpagemenu']))
                    $options['zeige_sidebarpagemenu'] = $defaultoptions['zeige_sidebarpagemenu'];

                if ($options['zeige_sidebarpagemenu'] == 1) {
                    if ($options['zeige_subpagesonly'] == 1) {
                        //if the post has a parent

                        if ($post->post_parent) {
                            //collect ancestor pages
                            $relations = get_post_ancestors($post->ID);
                            //get child pages
                            $result = $wpdb->get_results('SELECT ID FROM '.$wpdb->prefix.'posts WHERE post_parent = '.$post->ID.' AND post_type=\'page\'');
                            if ($result) {
                                foreach ($result as $pageID) {
                                    array_push($relations, $pageID->ID);
                                }
                            }
                            //add current post to pages
                            array_push($relations, $post->ID);
                            //get comma delimited list of children and parents and self
                            $relations_string = implode(",", $relations);
                            //use include to list only the collected pages. 
                            $sidelinks = wp_list_pages("sort_column=menu_order&title_li=&echo=0&include=" . $relations_string);
                        } else {
                            // display only main level and children
                            $sidelinks = wp_list_pages("sort_column=menu_order&title_li=&echo=0&depth=1&child_of=" . $post->ID);
                        }

                        if ($sidelinks) {
                            ?>
                            <ul class="menu">
                                <?php
                                //links in <li> tags
                                echo $sidelinks;
                                ?>
                            </ul>         
                            <?php
                        }
                    } else {

                        if (has_nav_menu('primary')) {
                            wp_nav_menu(array('depth' => 0, 'container_class' => 'menu-header', 'theme_location' => 'primary', 'walker' => new My_Walker_Nav_Menu()));
                        } else {
                            ?>
                            <ul class="menu">
                                <?php wp_page_menu(); ?>
                            </ul> 
                            <?php
                        }
                    }
                }

                $custom_fields = get_post_custom();
                if ($custom_fields['right_column'][0] <> '') {
                    echo $custom_fields['right_column'][0];
                }
                ?>
                <?php get_sidebar(); ?>
            </div>
        </div>

    </div>
</div>
<?php do_action('bp_after_directory_members_page'); ?>

<?php get_footer(); ?>
