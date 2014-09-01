<?php
/**
 * Single Topic Lead Content Part
 *
 * @package bbPress
 * @subpackage Theme
 */
?>
<?php do_action( 'bbp_template_before_lead_topic' ); ?>
    <table class="bbp-lead-topic" id="bbp-topic-<?php bbp_topic_id(); ?>-lead">
		<thead class="bbp-header">
			<tr>
				<th class="bbp-topic-author"><?php _e( 'Creator', 'bbpress' ); ?></th>
				<th class="bbp-topic-content">
					<?php _e( 'Topic', 'bbpress' ); ?>
					<?php bbp_topic_subscription_link(); ?>
					<?php bbp_topic_favorite_link(); ?>
				</th>
			</tr>
		</thead>

		<tbody class="bbp-body">
			<tr class="bbp-topic-header">
				<td colspan="2">
					<?php printf( __( '%1$s at %2$s', 'bbpress' ), get_the_date(), esc_attr( get_the_time() ) ); ?>
					<a href="#bbp-topic-<?php bbp_topic_id(); ?>" title="<?php bbp_topic_title(); ?>" class="bbp-topic-permalink">#<?php bbp_topic_id(); ?></a>
				</td>
			</tr>
			<tr id="post-<?php bbp_topic_id(); ?>" <?php post_class( 'bbp-forum-topic' ); ?>>
				<td class="bbp-topic-author">
					<?php bbp_topic_author_link( array( 'sep' => '<br />' ) ); ?>
					<?php if ( is_super_admin() ) : ?>
						<div class="bbp-topic-ip"><?php bbp_author_ip( bbp_get_topic_id() ); ?></div>
					<?php endif; ?>
				</td>
				<td class="bbp-topic-content">
<?php do_action( 'bbp_theme_before_topic_content' ); ?>
					<?php bbp_topic_content(); ?>
<?php do_action( 'bbp_theme_after_topic_content' ); ?>
				</td>
			</tr><!-- #post-<?php bbp_topic_id(); ?> -->
		</tbody>
		<tfoot class="bbp-footer">
			<tr>
				<td colspan="2">
					<?php bbp_topic_admin_links(); ?>
				</td>
			</tr>
		</tfoot>
	</table><!-- #bbp-topic-<?php bbp_topic_id(); ?> -->