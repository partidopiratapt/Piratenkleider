<?php

/**
 * Forums Loop - Single Forum
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

	<tr id="bbp-forum-<?php bbp_forum_id(); ?>" <?php bbp_forum_class(); ?>>

		<td class="bbp-forum-info">

			<?php do_action( 'bbp_theme_before_forum_title' ); ?>

			<a class="bbp-forum-title" href="<?php bbp_forum_permalink(); ?>" title="<?php bbp_forum_title(); ?>"><?php bbp_forum_title(); ?></a>

			<?php do_action( 'bbp_theme_after_forum_title' ); ?>
			<?php do_action( 'bbp_theme_before_forum_description' ); ?>

                        <div class="bbp-forum-description"><?php 
        $content = get_the_content($more_link_text, $stripteaser);
        echo $content; ?></div>

			<?php do_action( 'bbp_theme_after_forum_description' ); ?>

			<?php do_action( 'bbp_theme_before_forum_sub_forums' ); ?>

			<?php 
                        	$defaults = array (
		'before'            => '<div class="bbp-forums-list">&nbsp;&nbsp;&nbsp;&nbsp;Sub Quadro: ',
		'after'             => '</div>',
		'link_before'       => '',
		'link_after'        => '',
		'separator'         => ', ',
		'forum_id'          => '',
		'show_topic_count'  => false,
		'show_reply_count'  => false,
	);
                        bbp_list_forums($defaults); ?>

			<?php do_action( 'bbp_theme_after_forum_sub_forums' ); ?>

		</td>

		<td class="bbp-forum-topic-count"><?php bbp_forum_topic_count(); ?></td>

		<td class="bbp-forum-reply-count"><?php bbp_show_lead_topic() ? bbp_forum_reply_count() : bbp_forum_post_count(); ?></td>

		<td class="bbp-forum-freshness">

			<?php do_action( 'bbp_theme_before_forum_freshness_link' ); ?>

			<?php bbp_forum_freshness_link(); ?>

			<?php do_action( 'bbp_theme_after_forum_freshness_link' ); ?>

			<p class="bbp-topic-meta">

				<?php do_action( 'bbp_theme_before_topic_author' ); ?>

				<span class="bbp-topic-freshness-author"><?php bbp_author_link( array( 'post_id' => bbp_get_forum_last_active_id(), 'size' => 14 ) ); ?></span>

				<?php do_action( 'bbp_theme_after_topic_author' ); ?>

			</p>
		</td>

	</tr><!-- bbp-forum-<?php bbp_forum_id(); ?> -->
