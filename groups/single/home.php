<?php
get_header();
global $defaultoptions;
$options = get_option('piratenkleider_theme_options');
if (!isset($options['aktiv-defaultseitenbild']))
    $options['aktiv-defaultseitenbild'] = $defaultoptions['aktiv-defaultseitenbild'];
?>

<div class="section content">
    <div class="row">
        <div class="content-primary">
	<div id="content">
		<div class="padder">

                    <?php if ( bp_has_groups() ) : while ( bp_groups() ) : bp_the_group(); ?>

			<?php do_action( 'bp_before_group_home_content' ) ?>

			<div id="item-header" role="complementary">

				<?php locate_template( array( 'groups/single/group-header.php' ), true ); ?>

			</div><!-- #item-header -->

			<div id="item-nav">
				<div class="item-list-tabs no-ajax" id="object-nav" role="navigation">
					<ul>

						<?php bp_get_options_nav(); ?>

						<?php do_action( 'bp_group_options_nav' ); ?>

					</ul>
				</div>
			</div><!-- #item-nav -->

			<div id="item-body">

				<?php do_action( 'bp_before_group_body' );

				if ( bp_is_group_admin_page() && bp_group_is_visible() ) :
					locate_template( array( 'groups/single/admin.php' ), true );

				elseif ( bp_is_group_members() && bp_group_is_visible() ) :
					locate_template( array( 'groups/single/members.php' ), true );

				elseif ( bp_is_group_invites() && bp_group_is_visible() ) :
					locate_template( array( 'groups/single/send-invites.php' ), true );

					elseif ( bp_is_group_forum() && bp_group_is_visible() && bp_is_active( 'forums' ) && bp_forums_is_installed_correctly() ) :
						locate_template( array( 'groups/single/forum.php' ), true );

				elseif ( bp_is_group_membership_request() ) :
					locate_template( array( 'groups/single/request-membership.php' ), true );

				elseif ( bp_group_is_visible() && bp_is_active( 'activity' ) ) :
					locate_template( array( 'groups/single/activity.php' ), true );

				elseif ( bp_group_is_visible() ) :
					locate_template( array( 'groups/single/members.php' ), true );

				elseif ( !bp_group_is_visible() ) :
					// The group is not visible, show the status message

					do_action( 'bp_before_group_status_message' ); ?>

					<div id="message" class="info">
						<p><?php bp_group_status_message(); ?></p>
					</div>

					<?php do_action( 'bp_after_group_status_message' );

				else :
					// If nothing sticks, just load a group front template if one exists.
					locate_template( array( 'groups/single/front.php' ), true );

				endif;

				do_action( 'bp_after_group_body' ); ?>

			</div><!-- #item-body -->

			<?php do_action( 'bp_after_group_home_content' ); ?>

			<?php endwhile; endif; ?>

		</div><!-- .padder -->
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

<?php get_sidebar( 'buddypress' ); ?>
<?php get_footer(); ?>
