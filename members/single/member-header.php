<?php
/**
 * BuddyPress - Users Header
 *
 * @package BuddyPress
 * @subpackage bp-default
 */
?>
<?php do_action( 'bp_before_member_header' ); ?>
<h1 class="post-title"><span><?php bp_displayed_user_fullname(); ?></span></h1>
<div id="item-header-avatar">
		<?php bp_displayed_user_avatar( array('width' => 100, 'height' => 100, 'type' => 'full') ); ?>
</div><!-- #item-header-avatar -->
<div id="item-header-content">
	<span class="user-nicename">@<?php bp_displayed_user_username(); ?></span>
	<span class="activity"><?php bp_last_activity( bp_displayed_user_id() ); ?></span>
	<?php do_action( 'bp_before_member_header_meta' ); ?>
	<div id="item-meta">
		<?php if ( bp_is_active( 'activity' ) ) : ?>
			<div id="latest-update">
				<?php bp_activity_latest_update( bp_displayed_user_id() ); ?>
			</div>
		<?php endif; ?>
		<div id="item-buttons">
			<?php do_action( 'bp_member_header_actions' ); ?>
		</div><!-- #item-buttons -->
		<?php
		/***
		 * If you'd like to show specific profile fields here use:
		 * bp_member_profile_data( 'field=About Me' ); -- Pass the name of the field
		 */
		 do_action( 'bp_profile_header_meta' );
		 ?>
	</div><!-- #item-meta -->
</div><!-- #item-header-content -->
<div class="symbolbild"><img src="http://testppp.i3portal.net/wp-content/themes/piratenkleider/images/default-author.png" title=""></div>
<?php do_action( 'bp_after_member_header' ); ?>
<?php do_action( 'template_notices' ); ?>