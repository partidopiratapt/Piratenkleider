<?php
get_header();
global $defaultoptions;
global $options;
?>
<div class="section content" id="main-content">
    <div class="row">
        <div class="content-primary">            
            <?php
            $image_url = piratenkleider_get_cover(__('Members Directory', 'buddypress'), get_the_ID());
            ?>
            <div class="skin">
<?php do_action( 'bp_before_directory_members_page' ); ?>

<div id="buddypress">
                <?php do_action('bp_before_directory_members'); ?>
                <?php if (!(isset($image_url) && (strlen($image_url) > 4))) { ?>
                    <h1 id="page-title"><span><?php _e('Members Directory', 'buddypress'); ?></span></h1>
                <?php } ?>
                
                    <?php do_action('bp_before_directory_members_content'); ?>
                    <div id="members-dir-search" class="dir-search" role="search">
                        <?php bp_directory_members_search_form(); ?>
                    </div><!-- #members-dir-search -->

	<?php do_action( 'bp_before_directory_members_tabs' ); ?>

	<form action="" method="post" id="members-directory-form" class="dir-form">

                    <div class="item-list-tabs" role="navigation">
                        <ul>
				<li class="selected" id="members-all"><a href="<?php bp_members_directory_permalink(); ?>"><?php printf( __( 'All Members <span>%s</span>', 'buddypress' ), bp_get_total_member_count() ); ?></a></li>

                            <?php if (is_user_logged_in() && bp_is_active('friends') && bp_get_total_friend_count(bp_loggedin_user_id())) : ?>
					<li id="members-personal"><a href="<?php echo bp_loggedin_user_domain() . bp_get_friends_slug() . '/my-friends/'; ?>"><?php printf( __( 'My Friends <span>%s</span>', 'buddypress' ), bp_get_total_friend_count( bp_loggedin_user_id() ) ); ?></a></li>
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
			<?php bp_get_template_part( 'members/members-loop' ); ?>
                    </div><!-- #members-dir-list -->
                    <?php do_action('bp_directory_members_content'); ?>
                    <?php wp_nonce_field('directory_members', '_wpnonce-member-filter'); ?>
                    <?php do_action('bp_after_directory_members_content'); ?>
                </form><!-- #members-directory-form -->
                <?php do_action('bp_after_directory_members'); ?>
</div><!-- #buddypress -->

<?php do_action( 'bp_after_directory_members_page' ); ?>
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