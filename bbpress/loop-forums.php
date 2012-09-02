<?php

/**
 * Forums Loop
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

	<?php do_action( 'bbp_template_before_forums_loop' ); ?>



			<?php while ( bbp_forums() ) : bbp_the_forum(); ?>
	<table class="bbp-forums">

		<thead>
			<tr>
				<th class="bbp-forum-info"><?php _e( 'Forum', 'bbpress' ); ?></th>
				<th class="bbp-forum-topic-count"><?php _e( 'Topics', 'bbpress' ); ?></th>
				<th class="bbp-forum-reply-count"><?php bbp_show_lead_topic() ? _e( 'Replies', 'bbpress' ) : _e( 'Posts', 'bbpress' ); ?></th>
				<th class="bbp-forum-freshness"><?php _e( 'Freshness', 'bbpress' ); ?></th>
			</tr>
		</thead>

		<tfoot>
			<tr><td colspan="4">&nbsp;</td></tr>
		</tfoot>

		<tbody>
				<?php bbp_get_template_part( 'bbpress/loop', 'single-forum' ); ?>

		</tbody>

	</table>
			<?php endwhile; ?>


	<?php do_action( 'bbp_template_after_forums_loop' ); ?>
