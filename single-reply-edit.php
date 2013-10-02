<?php

/**
 * Edit handler for replies
 *
 * @package bbPress
 * @subpackage Theme
 */
function piratenkleider_get_form_reply_content() {

    // Get _POST data
    if (bbp_is_post_request() && isset($_POST['bbp_reply_content'])) {
        $reply_content = stripslashes($_POST['bbp_reply_content']);

        // Get edit data
    } elseif (bbp_is_reply_edit()) {
        $reply_content = get_post_field('post_content', bbp_get_reply_id()); //bbp_get_reply_content(bbp_get_reply_id());//bbp_get_global_post_field( 'post_content', 'raw' );
        // No data
    } else {
        $reply_content = '';
    }

    return apply_filters('bbp_get_form_reply_content', $reply_content);
}

get_header();
global $defaultoptions;
global $options;
?>

<div class="section content" id="main-content">
    <div class="row">
        <div class="content-primary">            
            <?php
            $image_url = piratenkleider_get_cover(get_the_title(), get_the_ID());
            ?>
            <div class="skin">
                <?php do_action('bbp_before_main_content'); ?>
                <?php if (!(isset($image_url) && (strlen($image_url) > 4))) { ?>
                    <h1 id="page-title"><span><?php the_title(); ?></span></h1>
                <?php } ?>
                <?php while (have_posts()) : the_post(); ?>
                    <div id="bbp-edit-page" class="bbp-edit-page">
                        <div class="entry-content">
                            <?php if (bbp_is_reply_edit()) : ?>
                                <div id="bbpress-forums">
                                <?php endif; ?>
                                <?php if (bbp_current_user_can_access_create_reply_form()) : ?>
                                    <div id="new-reply-<?php bbp_topic_id(); ?>" class="bbp-reply-form">
                                        <form id="new-post" name="new-post" method="post" action="<?php the_permalink(); ?>">
                                            <?php do_action('bbp_theme_before_reply_form'); ?>
                                            <fieldset class="bbp-form">
                                                <?php do_action('bbp_theme_before_reply_form_notices'); ?>
                                                <?php if (!bbp_is_topic_open() && !bbp_is_reply_edit()) : ?>
                                                    <div class="bbp-template-notice">
                                                        <p><?php _e('This topic is marked as closed to new replies, however your posting capabilities still allow you to do so.', 'bbpress'); ?></p>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (current_user_can('unfiltered_html')) : ?>
                                                    <div class="bbp-template-notice">
                                                        <p><?php _e('Your account has the ability to post unrestricted HTML content.', 'bbpress'); ?></p>
                                                    </div>
                                                <?php endif; ?>
                                                <?php do_action('bbp_template_notices'); ?>
                                                <div>
                                                    <?php bbp_get_template_part('form', 'anonymous'); ?>
                                                    <?php do_action('bbp_theme_before_reply_form_content'); ?>
                                                    <?php
                                                    if (!function_exists("getTheContent")) {
                                                        function getTheContent($args = array()) {
                                                            // Parse arguments against default values
                                                            $r = bbp_parse_args($args, array(
                                                                'context' => 'topic',
                                                                'before' => '<div class="bbp-the-content-wrapper">',
                                                                'after' => '</div>',
                                                                'wpautop' => true,
                                                                'media_buttons' => false,
                                                                'textarea_rows' => '12',
                                                                'tabindex' => bbp_get_tab_index(),
                                                                'tabfocus_elements' => 'bbp_topic_title,bbp_topic_tags',
                                                                'editor_class' => 'bbp-the-content',
                                                                'tinymce' => false,
                                                                'teeny' => true,
                                                                'quicktags' => true,
                                                                'dfw' => false
                                                                    ), 'get_the_content');

                                                            // If using tinymce, remove our escaping and trust tinymce
                                                            if (bbp_use_wp_editor() && ( false !== $r['tinymce'] )) {
                                                                remove_filter('bbp_get_form_forum_content', 'esc_textarea');
                                                                remove_filter('bbp_get_form_topic_content', 'esc_textarea');
                                                                remove_filter('bbp_get_form_reply_content', 'esc_textarea');
                                                            }

                                                            // Assume we are not editing
                                                            $post_content = call_user_func('piratenkleider_get_form_' . $r['context'] . '_content');
                                                            //$post_content = piratenkleider_get_form_reply_content();
                                                            // Start an output buffor
                                                            ob_start();
                                                            // Output something before the editor
                                                            if (!empty($r['before'])) {
                                                                echo $r['before'];
                                                            }
                                                            // Use TinyMCE if available
                                                            if (bbp_use_wp_editor()) :
                                                                // Enable additional TinyMCE plugins before outputting the editor
                                                                add_filter('tiny_mce_plugins', 'bbp_get_tiny_mce_plugins');
                                                                add_filter('teeny_mce_plugins', 'bbp_get_tiny_mce_plugins');
                                                                add_filter('teeny_mce_buttons', 'bbp_get_teeny_mce_buttons');
                                                                add_filter('quicktags_settings', 'bbp_get_quicktags_settings');

                                                                // Output the editor
                                                                wp_editor($post_content, 'bbp_' . $r['context'] . '_content', array(
                                                                    'wpautop' => $r['wpautop'],
                                                                    'media_buttons' => $r['media_buttons'],
                                                                    'textarea_rows' => $r['textarea_rows'],
                                                                    'tabindex' => $r['tabindex'],
                                                                    'tabfocus_elements' => $r['tabfocus_elements'],
                                                                    'editor_class' => $r['editor_class'],
                                                                    'tinymce' => $r['tinymce'],
                                                                    'teeny' => $r['teeny'],
                                                                    'quicktags' => $r['quicktags'],
                                                                    'dfw' => $r['dfw'],
                                                                ));

                                                                // Remove additional TinyMCE plugins after outputting the editor
                                                                remove_filter('tiny_mce_plugins', 'bbp_get_tiny_mce_plugins');
                                                                remove_filter('teeny_mce_plugins', 'bbp_get_tiny_mce_plugins');
                                                                remove_filter('teeny_mce_buttons', 'bbp_get_teeny_mce_buttons');
                                                                remove_filter('quicktags_settings', 'bbp_get_quicktags_settings');

                                                            /**
                                                             * Fallback to normal textarea.
                                                             *
                                                             * Note that we do not use esc_textarea() here to prevent double
                                                             * escaping the editable output, mucking up existing content.
                                                             */
                                                            else :
                                                                ?>
                                                                <textarea id="bbp_<?php echo esc_attr($r['context']); ?>_content" class="<?php echo esc_attr($r['editor_class']); ?>" name="bbp_<?php echo esc_attr($r['context']); ?>_content" cols="60" rows="<?php echo esc_attr($r['textarea_rows']); ?>" tabindex="<?php echo esc_attr($r['tabindex']); ?>"><?php echo $post_content; ?></textarea>
                                                            <?php
                                                            endif;

                                                            // Output something after the editor
                                                            if (!empty($r['after'])) {
                                                                echo $r['after'];
                                                            }

                                                            // Put the output into a usable variable
                                                            $output = ob_get_clean();
                                                            return apply_filters('bbp_get_the_content', $output, $args, $post_content);
                                                        }
                                                    }
                                                    echo getTheContent(array('context' => 'reply'));
                                                    ?>

                                                    <?php do_action('bbp_theme_after_reply_form_content'); ?>
                                                    <?php if (!( bbp_use_wp_editor() || current_user_can('unfiltered_html') )) : ?>
                                                        <p class="form-allowed-tags">
                                                            <label><?php _e('You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes:', 'bbpress'); ?></label><br />
                                                            <code><?php bbp_allowed_tags(); ?></code>
                                                        </p>
                                                    <?php endif; ?>
                                                    <?php if (bbp_allow_topic_tags() && current_user_can('assign_topic_tags')) : ?>
                                                        <?php do_action('bbp_theme_before_reply_form_tags'); ?>
                                                        <p>
                                                            <label for="bbp_topic_tags"><?php _e('Tags:', 'bbpress'); ?></label><br />
                                                            <input type="text" value="<?php bbp_form_topic_tags(); ?>" tabindex="<?php bbp_tab_index(); ?>" size="40" name="bbp_topic_tags" id="bbp_topic_tags" <?php disabled(bbp_is_topic_spam()); ?> />
                                                        </p>
                                                        <?php do_action('bbp_theme_after_reply_form_tags'); ?>
                                                    <?php endif; ?>
                                                    <?php if (bbp_is_subscriptions_active() && !bbp_is_anonymous() && (!bbp_is_reply_edit() || ( bbp_is_reply_edit() && !bbp_is_reply_anonymous() ) )) : ?>
                                                        <?php do_action('bbp_theme_before_reply_form_subscription'); ?>
                                                        <p>
                                                            <input name="bbp_topic_subscription" id="bbp_topic_subscription" type="checkbox" value="bbp_subscribe"<?php bbp_form_topic_subscribed(); ?> tabindex="<?php bbp_tab_index(); ?>" />
                                                            <?php if (bbp_is_reply_edit() && ( bbp_get_reply_author_id() !== bbp_get_current_user_id() )) : ?>
                                                                <label for="bbp_topic_subscription"><?php _e('Notify the author of follow-up replies via email', 'bbpress'); ?></label>
                                                            <?php else : ?>
                                                                <label for="bbp_topic_subscription"><?php _e('Notify me of follow-up replies via email', 'bbpress'); ?></label>
                                                            <?php endif; ?>
                                                        </p>
                                                        <?php do_action('bbp_theme_after_reply_form_subscription'); ?>
                                                    <?php endif; ?>
                                                    <?php if (bbp_allow_revisions() && bbp_is_reply_edit()) : ?>
                                                        <?php do_action('bbp_theme_before_reply_form_revisions'); ?>
                                                        <fieldset class="bbp-form">
                                                            <legend>
                                                                <input name="bbp_log_reply_edit" id="bbp_log_reply_edit" type="checkbox" value="1" <?php bbp_form_reply_log_edit(); ?> tabindex="<?php bbp_tab_index(); ?>" />
                                                                <label for="bbp_log_reply_edit"><?php _e('Keep a log of this edit:', 'bbpress'); ?></label><br />
                                                            </legend>
                                                            <div>
                                                                <label for="bbp_reply_edit_reason"><?php printf(__('Optional reason for editing:', 'bbpress'), bbp_get_current_user_name()); ?></label><br />
                                                                <input type="text" value="<?php bbp_form_reply_edit_reason(); ?>" tabindex="<?php bbp_tab_index(); ?>" size="40" name="bbp_reply_edit_reason" id="bbp_reply_edit_reason" />
                                                            </div>
                                                        </fieldset>
                                                        <?php do_action('bbp_theme_after_reply_form_revisions'); ?>
                                                    <?php endif; ?>
                                                    <?php do_action('bbp_theme_before_reply_form_submit_wrapper'); ?>
                                                    <div class="bbp-submit-wrapper">
                                                        <?php do_action('bbp_theme_before_reply_form_submit_button'); ?>
                                                        <?php bbp_cancel_reply_to_link(); ?>
                                                        <button type="submit" tabindex="<?php bbp_tab_index(); ?>" id="bbp_reply_submit" name="bbp_reply_submit" class="button submit"><?php _e('Submit', 'bbpress'); ?></button>
                                                        <?php do_action('bbp_theme_after_reply_form_submit_button'); ?>
                                                    </div>
                                                    <?php do_action('bbp_theme_after_reply_form_submit_wrapper'); ?>
                                                </div>
                                                <?php bbp_reply_form_fields(); ?>
                                            </fieldset>
                                            <?php do_action('bbp_theme_after_reply_form'); ?>
                                        </form>
                                    </div>
                                <?php elseif (bbp_is_topic_closed()) : ?>
                                    <div id="no-reply-<?php bbp_topic_id(); ?>" class="bbp-no-reply">
                                        <div class="bbp-template-notice">
                                            <p><?php printf(__('The topic &#8216;%s&#8217; is closed to new replies.', 'bbpress'), bbp_get_topic_title()); ?></p>
                                        </div>
                                    </div>
                                <?php elseif (bbp_is_forum_closed(bbp_get_topic_forum_id())) : ?>
                                    <div id="no-reply-<?php bbp_topic_id(); ?>" class="bbp-no-reply">
                                        <div class="bbp-template-notice">
                                            <p><?php printf(__('The forum &#8216;%s&#8217; is closed to new topics and replies.', 'bbpress'), bbp_get_forum_title(bbp_get_topic_forum_id())); ?></p>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <div id="no-reply-<?php bbp_topic_id(); ?>" class="bbp-no-reply">
                                        <div class="bbp-template-notice">
                                            <p><?php is_user_logged_in() ? _e('You cannot reply to this topic.', 'bbpress') : _e('You must be logged in to reply to this topic.', 'bbpress'); ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if (bbp_is_reply_edit()) : ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div><!-- #bbp-edit-page -->
                <?php endwhile; ?>
                <?php do_action('bbp_after_main_content'); ?>
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
                get_sidebar('bbpress');
                ?>
            </div>
        </div>
    </div>
    <?php get_piratenkleider_socialmediaicons(2); ?>
</div>
<?php get_footer(); ?>